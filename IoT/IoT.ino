#include <OneWire.h>
#include <DallasTemperature.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <SoftwareSerial.h>

#define ONE_WIRE_BUS 2
#define TDS_SENSOR_PIN A0
#define TURBIDITY_SENSOR_PIN A3
#define PH_SENSOR_PIN A1
#define VREF 5.0
#define SCOUNT 30

OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);
LiquidCrystal_I2C lcd(0x27, 16, 2);
SoftwareSerial mySerial(7, 8); // RX, TX for SIM900

// TDS variables
int analogBuffer[SCOUNT];
int analogBufferTemp[SCOUNT];
float averageVoltage = 0;

// Calibration constants
float TDS_CALIBRATION_FACTOR = 1.25;
const float PH_CALIBRATION_SLOPE = 0.92;       
const float PH_CALIBRATION_OFFSET = 0.4;
const int NUM_PH_SAMPLES = 15;  
const float referenceVoltage = 5.0;

// Safe range constants
const float PH_MIN_SAFE = 6.5;
const float PH_MAX_SAFE = 8.5;
const float TURBIDITY_MAX_SAFE = 5.0;
const float TDS_MAX_SAFE = 1500.0;
const float TEMP_MIN_SAFE = 10.0;
const float TEMP_MAX_SAFE = 30.0;

// GSM and ThingSpeak settings
bool smsSent = false;
String phoneNumbers[] = {"+639772464748", "+639090455998", "+639093499202"};
String apiKey = "USTGNC1OLEAVKVK9";

byte degreeSymbol[8] = {
  0b00000, 0b00100, 0b00100, 0b00000,
  0b00000, 0b00100, 0b00100, 0b00000
};

int getMedianNum(int bArray[], int iFilterLen) {
  int bTab[iFilterLen];
  for (byte i = 0; i < iFilterLen; i++)
    bTab[i] = bArray[i];
  int i, j, bTemp;
  for (j = 0; j < iFilterLen - 1; j++) {
    for (i = 0; i < iFilterLen - j - 1; i++) {
      if (bTab[i] > bTab[i + 1]) {
        bTemp = bTab[i];
        bTab[i] = bTab[i + 1];
        bTab[i + 1] = bTemp;
      }
    }
  }
  return bTab[(iFilterLen - 1) / 2];
}

void setup() {
  Serial.begin(9600);
  mySerial.begin(9600);
  sensors.begin();
  lcd.begin();
  lcd.backlight();
  lcd.createChar(0, degreeSymbol);
  pinMode(TDS_SENSOR_PIN, INPUT);
  
  showStartupMessages();
  initializeGPRS();
}

void showStartupMessages() {
  lcd.clear();
  lcd.setCursor(3, 0);
  lcd.print("PANALAWAHIG");
  delay(5000);
  
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("   Sensors");
  lcd.setCursor(0, 1);
  lcd.print("  Calibrating");
  delay(5000);
  
  lcd.clear();
  lcd.setCursor(3, 0);
  lcd.print("Sensors");
  lcd.setCursor(4, 1);
  lcd.print("Ready!");
  delay(3000);
  
  lcd.clear();
}

void initializeGPRS() {
  Serial.println("Initializing SIM900 module...");
  
  mySerial.println("AT");
  delay(1000);
  printResponse();

  mySerial.println("AT+CSQ");
  delay(1000);
  printResponse();

  mySerial.println("AT+CPIN?");
  delay(1000);
  printResponse();

  mySerial.println("AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\"");
  delay(1000);
  printResponse();

  mySerial.println("AT+SAPBR=3,1,\"APN\",\"smartbro\"");
  delay(1000);
  printResponse();

  // Close any existing connection first
  mySerial.println("AT+SAPBR=0,1");
  delay(2000);
  printResponse();

  mySerial.println("AT+SAPBR=1,1");
  delay(5000);  // Increased delay
  printResponse();

  mySerial.println("AT+SAPBR=2,1");
  delay(1000);
  printResponse();
}

float readTDS() {
  for(int i = 0; i < SCOUNT; i++) {
    analogBuffer[i] = analogRead(TDS_SENSOR_PIN);
    delay(10);
  }
  
  for(int i = 0; i < SCOUNT; i++) {
    analogBufferTemp[i] = analogBuffer[i];
  }
  
  int rawReading = getMedianNum(analogBufferTemp, SCOUNT);
  float averageVoltage = rawReading * (VREF / 1024.0);
  
  float temperature = sensors.getTempCByIndex(0);
  float compensationCoefficient = 1.0 + 0.02 * (temperature - 25.0);
  float compensationVoltage = averageVoltage / compensationCoefficient;
  
  float tdsValue = (133.42 * compensationVoltage * compensationVoltage * compensationVoltage 
                   - 255.86 * compensationVoltage * compensationVoltage 
                   + 857.39 * compensationVoltage) * 0.2;  
  
  return constrain(tdsValue, 0, 500); 
}

float readTurbidity() {
  float turbidityAvgReading = 0;
  for(int i = 0; i < 100; i++) {
    turbidityAvgReading += analogRead(TURBIDITY_SENSOR_PIN);
    delay(10);
  }
  turbidityAvgReading = turbidityAvgReading / 100;
  
  float turbidityVolts = turbidityAvgReading * (5.0 / 1024.0);
  float turbidityValue;
  
  if(turbidityVolts >= 2.5) {
    turbidityValue = 0;
  } else if(turbidityVolts <= 1.0) {
    turbidityValue = 3.0;  
  } else {
    turbidityValue = (-1.2 * turbidityVolts) + 3.5; 
  }
  
  return constrain(turbidityValue, 0, 3.0); 
}

float readPH() {
  float sumPH = 0;
  float avgVoltage = 0;
  
  for(int i = 0; i < NUM_PH_SAMPLES; i++) {
    int rawPHValue = analogRead(PH_SENSOR_PIN);
    float voltage = (rawPHValue * referenceVoltage) / 1024.0;
    avgVoltage += voltage;
    delay(10);
  }
  
  avgVoltage = avgVoltage / NUM_PH_SAMPLES;
  float phValue = -3.50 * avgVoltage + 12.84;  // Adjusted for lower pH reading
  
  return constrain(phValue, 0.0, 14.0);
}

String getSimpleStatus(float value, float minSafe, float maxSafe) {
    return (value >= minSafe && value <= maxSafe) ? "SAFE" : "NEEDS TREATMENT";
}

String getOverallStatus(float tempC, float turbidity, float tds, float pH) {
    bool isTemperatureSafe = (tempC >= TEMP_MIN_SAFE && tempC <= TEMP_MAX_SAFE);
    bool isTurbiditySafe = (turbidity <= TURBIDITY_MAX_SAFE);
    bool isTDSSafe = (tds <= TDS_MAX_SAFE);
    bool isPHSafe = (pH >= PH_MIN_SAFE && pH <= PH_MAX_SAFE);
    
    return (isTemperatureSafe && isTurbiditySafe && isTDSSafe && isPHSafe) ? 
           "Overall Status: SAFE" : 
           "Overall Status: NEEDS TREATMENT";
}

void sendToThingSpeak(float tempC, float turbidity, float tds, float pH) {
  mySerial.println("AT+HTTPINIT");
  delay(1000);
  printResponse();

  mySerial.println("AT+HTTPPARA=\"CID\",1");
  delay(1000);
  printResponse();

  mySerial.print("AT+HTTPPARA=\"URL\",\"http://api.thingspeak.com/update?api_key=USTGNC1OLEAVKVK9");
  mySerial.print("&field1=");
  mySerial.print(tempC, 1);
  mySerial.print("&field2=");
  mySerial.print(turbidity, 1);
  mySerial.print("&field3=");
  mySerial.print(tds, 0);
  mySerial.print("&field4=");
  mySerial.print(pH, 1);
  mySerial.println("\"");
  delay(2000);
  printResponse();

  mySerial.println("AT+HTTPACTION=0");
  delay(5000);
  printResponse();

  mySerial.println("AT+HTTPREAD");
  delay(1000);
  printResponse();

  mySerial.println("AT+HTTPTERM");
  delay(1000);
  printResponse();
}

void sendSMS(String phoneNumber, float tempC, float turbidity, float tds, float pH) {
  mySerial.println("AT+CMGF=1");
  delay(1000);
  mySerial.println("AT+CMGS=\"" + phoneNumber + "\"");
  delay(1000);

  String message = "PANALAWAHIG: Water Quality Testing System\n";
  message += "Temperature: " + String(tempC, 1) + "C\n";
  message += "Turbidity: " + String(turbidity, 1) + " NTU\n";
  message += "TDS: " + String(tds, 0) + " ppm\n";
  message += "pH: " + String(pH, 1);

  mySerial.println(message);
  mySerial.write(26);
  delay(5000);
  printResponse();
}

void sendStatusSMS(String phoneNumber, float tempC, float turbidity, float tds, float pH) {
    Serial.println("Starting status SMS");
    mySerial.println("AT+CMGF=1");
    delay(2000);  // Increased delay
    
    Serial.println("Setting phone number");
    mySerial.println("AT+CMGS=\"" + phoneNumber + "\"");
    delay(2000);  // Increased delay

    String message2 = "Status Report:\n\n";
    message2 += "Temperature: " + getSimpleStatus(tempC, TEMP_MIN_SAFE, TEMP_MAX_SAFE) + "\n";
    message2 += "Turbidity: " + getSimpleStatus(turbidity, 0, TURBIDITY_MAX_SAFE) + "\n";
    message2 += "TDS: " + getSimpleStatus(tds, 0, TDS_MAX_SAFE) + "\n";
    message2 += "pH: " + getSimpleStatus(pH, PH_MIN_SAFE, PH_MAX_SAFE) + "\n";    
    message2 += "\n";
    message2 += getOverallStatus(tempC, turbidity, tds, pH);
    message2 += "\n\nKAJA Group";

    Serial.println("Sending status message");
    mySerial.println(message2);
    mySerial.write(26);
    delay(10000);  // Increased delay
    printResponse();
    Serial.println("Status SMS completed");
}

void printResponse() {
  while (mySerial.available()) {
    Serial.print(mySerial.readString());
  }
}

void loop() {
  sensors.requestTemperatures();
  float tempC = sensors.getTempCByIndex(0);
  
  if(tempC == -127.0) {
    delay(1000);
    sensors.requestTemperatures();
    tempC = sensors.getTempCByIndex(0);
  }

  float tdsValue = readTDS();
  float turbidityValue = readTurbidity();
  float pHValue = readPH();

  printSensorData(tempC, turbidityValue, tdsValue, pHValue);
  updateLCD(tempC, turbidityValue, tdsValue, pHValue);
  
  sendToThingSpeak(tempC, turbidityValue, tdsValue, pHValue);

  if (!smsSent) {
    for (int i = 0; i < 3; i++) {
      sendSMS(phoneNumbers[i], tempC, turbidityValue, tdsValue, pHValue);
      delay(5000);  // Wait between messages
      sendStatusSMS(phoneNumbers[i], tempC, turbidityValue, tdsValue, pHValue);
      delay(5000);  // Wait before next number
    }
    smsSent = true;
  }
  
  delay(15000);
}

void printSensorData(float tempC, float turbidity, float tds, float pH) {
  Serial.print("Temperature: "); 
  Serial.print(tempC, 1); 
  Serial.println(" C");
  Serial.print("Turbidity: "); 
  Serial.print(turbidity, 1); 
  Serial.println(" NTU");
  Serial.print("TDS: "); 
  Serial.print(tds, 0); 
  Serial.println(" ppm");
  Serial.print("pH: "); 
  Serial.println(pH, 1);
  Serial.println();
}

void updateLCD(float tempC, float turbidity, float tds, float pH) {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("TP:"); lcd.print(tempC, 1); lcd.write(0);
  lcd.print("TU:"); lcd.print(turbidity, 1);

  lcd.setCursor(0, 1);
  lcd.print("TDS:"); lcd.print(tds, 0);
  lcd.print(" pH:"); lcd.print(pH, 1);
}