#include <SoftwareSerial.h>

// Create software serial connection on pins 2 (RX) and 3 (TX)
SoftwareSerial mySerial(2, 3);

// Function to check network registration
void checkRegistration() {
  mySerial.println("AT+CREG?");
  delay(2000); // Give it time to respond
  
  while (mySerial.available()) {
    String response = mySerial.readString(); // Read the entire response
    Serial.println(response); // Print the response to Serial Monitor
    if (response.indexOf("+CREG: 0,1") > 0 || response.indexOf("+CREG: 0,5") > 0) {
      Serial.println("Network Registration OK");
      return;
    } else {
      Serial.println("Not Registered. Attempting to list networks...");
      listAvailableNetworks(); // List available networks if not registered
    }
  }
}

// Function to list available networks
void listAvailableNetworks() {
  mySerial.println("AT+COPS=?");
  delay(10000); // Wait for the response
  
  while (mySerial.available()) {
    String response = mySerial.readString(); // Read the entire response
    Serial.println(response); // Print the response to Serial Monitor
  }
  
  // Attempt to register to SMART or Globe network
  Serial.println("Attempting to register to Globe network...");
  mySerial.println("AT+COPS=1,0,\"GLOBE\""); // Change to "GLOBE" if needed
  delay(5000); // Wait for registration attempt
}

void setup() {
  // Start communication with the computer and GSM module
  Serial.begin(9600);
  mySerial.begin(9600);

  // Wait for GSM module to initialize
  delay(1000);

  // Checking signal strength
  Serial.println("Checking Signal Strength...");
  mySerial.println("AT+CSQ");
  delay(2000); // Wait for signal strength response

  // Checking network registration
  checkRegistration();  // Call the function to check registration

  // Sending SMS (only if registered)
  Serial.println("Sending SMS...");
  mySerial.println("AT+CMGF=1"); // Set to text mode
  delay(1000);

  // Send the SMS command with the number (with country code)
  mySerial.println("AT+CMGS=\"+639772464748\"");
  delay(1000);

  // The message to be sent
  mySerial.println("Hi, This is Panalawahig");

  // End the SMS with a CTRL+Z character
  mySerial.write(26);
  delay(1000);

  // Check for response from the GSM module
  while (mySerial.available()) {
    String response = mySerial.readString(); // Read the entire response
    Serial.println(response); // Print the response to Serial Monitor
  }

  Serial.println("SMS sending process completed.");
}

void loop() {
  // If the GSM module sends data, display it on Serial Monitor
  if (mySerial.available()) {
    Serial.write(mySerial.read());
  }
}
