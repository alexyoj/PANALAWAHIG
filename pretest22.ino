#include <SoftwareSerial.h>
#include <OneWire.h>
#include <DallasTemperature.h>

// Pin setup for DS18B20
#define ONE_WIRE_BUS 2
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

// Create software serial connection for SIM900 (RX on pin 8, TX on pin 7)
SoftwareSerial mySerial(7, 8); 

// Sensor Pins (adjust according to your setup)
int phPin = A0; 
int turbidityPin = A1;
int tdsPin = A2;

void setup() {
  Serial.begin(9600);
  mySerial.begin(9600);
  
  sensors.begin();  // Start DS18B20 temperature sensor

  Serial.println("Initializing SIM900 module...");
  delay(5000);  // Wait for SIM900 to initialize

  // Check SIM card status
  if (checkSIMStatus()) {
    // Check signal strength
    checkSignalStrength();
  
    // Check network registration
    if (checkNetworkRegistration()) {
      // Read all sensor data
      float phValue = readPH();
      float turbidityValue = readTurbidity();
      float tdsValue = readTDS();
      float temperatureValue = readTemperature();

      // Send SMS to the specified numbers
      sendSMS("+639772464748", phValue, turbidityValue, tdsValue, temperatureValue);
      sendSMS("+639093499202", phValue, turbidityValue, tdsValue, temperatureValue); // New number added
      sendSMS("+639090455998", phValue, turbidityValue, tdsValue, temperatureValue); // New number added
    } else {
      Serial.println("Failed to register on the network. Please check your connection.");
    }
  } else {
    Serial.println("SIM card issue detected. Please check the SIM card.");
  }
}

bool checkSIMStatus() {
  Serial.println("Checking SIM card status...");
  mySerial.println("AT+CPIN?");
  delay(1000);
  while (mySerial.available()) {
    String response = mySerial.readString();
    Serial.println(response);
    
    if (response.indexOf("READY") != -1) {
      Serial.println("SIM card is ready.");
      return true;
    } else if (response.indexOf("ERROR") != -1) {
      Serial.println("SIM card error! Please check the SIM card.");
      return false;
    }
  }
  return false;
}

void checkSignalStrength() {
  Serial.println("Checking signal strength...");
  mySerial.println("AT+CSQ");
  delay(1000);  // Wait for a moment to receive the response
  
  // Read and print the response from the SIM900
  while (mySerial.available()) {
    Serial.println(mySerial.readString());
  }
}

float readPH() {
  int phValue = analogRead(phPin);
  return (phValue * 5.0 / 1024); // Example conversion
}

float readTurbidity() {
  int turbidityValue = analogRead(turbidityPin);
  return (turbidityValue * 5.0 / 1024); // Example conversion
}

float readTDS() {
  int tdsValue = analogRead(tdsPin);
  return (tdsValue * 5.0 / 1024); // Example conversion
}

float readTemperature() {
  sensors.requestTemperatures(); 
  return sensors.getTempCByIndex(0); // Read temperature in Celsius
}

void sendSMS(String phoneNumber, float phValue, float turbidityValue, float tdsValue, float temperatureValue) {
  Serial.println("Setting SMS mode to text...");
  mySerial.println("AT+CMGF=1"); // Set SMS to text mode
  delay(1000);

  Serial.println("Sending SMS to: " + phoneNumber);
  mySerial.println("AT+CMGS=\"" + phoneNumber + "\""); // Send SMS command with the number
  delay(1000);

  // Updated message with spaces between data
  String message = "Hi, I'm PANALAWAHIG: Water Quality Testing System made by KAJA Group\n\n";
  message += "pH: " + String(phValue) + "\n\n"; // Added space
  message += "Turbidity: " + String(turbidityValue) + "\n\n"; // Added space
  message += "Total Dissolve Solids (TDS): " + String(tdsValue) + "\n\n"; // Added space
  message += "Temperature: " + String(temperatureValue) + "C";

  mySerial.println(message); // Send the message
  mySerial.write(26); // Send CTRL+Z to indicate end of message
  delay(5000); // Wait for SMS to send

  Serial.println("Message sent. Checking response...");
  while (mySerial.available()) {
    Serial.println(mySerial.readString());
  }
}

bool checkNetworkRegistration() {
  Serial.println("Checking network registration...");
  mySerial.println("AT+CREG?");
  delay(2000);

  while (mySerial.available()) {
    String response = mySerial.readString();
    Serial.println(response);

    if (response.indexOf("+CREG: 0,1") != -1 || response.indexOf("+CREG: 0,5") != -1) {
      Serial.println("Network registration successful.");
      return true;
    }
  }
  
  Serial.println("No response or failed to register on the network.");
  return false;
}

void loop() {
  // Leave empty
}
