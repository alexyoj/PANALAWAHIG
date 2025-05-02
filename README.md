# PANALAWAHIG

<div align="center">
  <h2>IoT-Based Water Quality Testing System for Far-Flung Areas of Davao City</h2>
  <img src="https://img.shields.io/badge/Status-In%20Development-yellow" alt="Status: In Development">
  <img src="https://img.shields.io/badge/License-MIT-blue" alt="License: MIT">
  <img src="https://img.shields.io/badge/Version-1.0-green" alt="Version: 1.0">
</div>

## 📋 Table of Contents
- [Project Overview](#project-overview)
- [Key Features](#key-features)
- [System Architecture](#system-architecture)
- [Hardware Components](#hardware-components)
- [Software Requirements](#software-requirements)
- [Installation Guide](#installation-guide)
- [Usage Instructions](#usage-instructions)
- [Data Visualization](#data-visualization)
- [System Benefits](#system-benefits)
- [Future Developments](#future-developments)
- [Contributing](#contributing)
- [License](#license)
- [Project Team](#project-team)

## 🌊 Project Overview

**Panalawahig** is an innovative IoT-based water quality testing system designed to address the challenges faced by remote and far-flung areas of Davao City in monitoring water safety. Many communities in these regions lack access to reliable water testing facilities, which poses significant health risks due to the potential for contaminated water sources. 

This project bridges that gap by providing a portable and easy-to-use system for on-site water quality testing. Our system offers real-time water quality analysis and transmits the results to a cloud-based platform for remote monitoring. This eliminates the need for physically transporting water samples to distant laboratories, ensuring faster and more accessible results.

By utilizing a user-friendly web interface, **Panalawahig** allows authorities and local communities to access historical data and track trends in water quality over time, facilitating informed decision-making. Additionally, the system integrates an automated notification system that sends SMS alerts to local authorities with the latest water quality data after each test, ensuring timely updates and quick responses to potential water contamination issues.

## ✨ Key Features

- **Real-time Monitoring**: Instant water quality testing with multiple parameters
- **Web Interface**: Remote data visualization and historical trend tracking via ThingSpeak API
- **SMS Notifications**: Automated alerts to authorities after each water quality test
- **Portable Design**: Suitable for deployment in remote and hard-to-reach areas
- **Data-driven Decision Making**: Supports communities in maintaining clean water resources
- **Low Power Consumption**: Designed for extended use in off-grid locations
- **Easy Deployment**: Simple setup process requiring minimal technical knowledge

## 🏗️ System Architecture

```
┌─────────────────────────────────────────┐
│             PANALAWAHIG SYSTEM          │
└───────────────────┬─────────────────────┘
                    │
        ┌───────────▼───────────┐
        │  Data Acquisition     │
        │    Components         │
        └───────────┬───────────┘
                    │
┌───────────────────▼───────────────────┐
│            Sensor Array               │
├─────────────┬─────────────┬───────────┤
│ Temperature │    pH       │ Turbidity │
├─────────────┼─────────────┼───────────┤
│     TDS     │Dissolved O₂ │Conductivity│
├─────────────┼─────────────┼───────────┤
│     ORP     │  Flow Rate  │Water Level │
└─────────────┴──────┬──────┴───────────┘
                     │
         ┌───────────▼──────────┐
         │   Data Processing    │
         │    (Arduino Uno)     │
         └───────────┬──────────┘
                     │
           ┌─────────▼─────────┐
           │  Local Display    │
           │   (I2C LCD)       │
           └─────────┬─────────┘
                     │
       ┌─────────────┴─────────────┐
       │                           │
┌──────▼───────┐           ┌──────▼───────┐
│  SMS Alerts  │           │ Cloud Storage │
│ (SIM900 GSM) │           │ (ThingSpeak) │
└──────────────┘           └──────┬───────┘
                                  │
                          ┌───────▼───────┐
                          │  Web Interface │
                          │  (Dashboard)   │
                          └───────────────┘
```

## 💻 Hardware Components

| Component | Description | Function |
|-----------|-------------|----------|
| **DS18B20 Temperature Sensor** | High-precision digital temperature sensor | Measures water temperature with ±0.5°C accuracy |
| **TDS Sensor** | Analog sensor for dissolved solids | Measures concentration in ppm (parts per million) |
| **pH Sensor** | Glass electrode sensor | Determines acidity/alkalinity on 0-14 scale |
| **Turbidity Sensor** | Optical sensor | Measures water clarity by detecting suspended particles |
| **Dissolved Oxygen Sensor** | Galvanic or optical sensor | Assesses oxygen content crucial for aquatic life |
| **Conductivity Sensor** | Two-electrode sensor | Measures water's electrical conductivity |
| **ORP Sensor** | Platinum electrode sensor | Measures water's oxidation-reduction potential |
| **Flow Sensor** | Hall effect sensor | Monitors water flow rate in dynamic environments |
| **Water Level Sensor** | Capacitive or ultrasonic sensor | Detects fluctuations in water levels |
| **DHT11/DHT22** | Digital sensor | Monitors ambient temperature and humidity |
| **Arduino Uno R3** | Microcontroller | Processes sensor data and coordinates communication |
| **I2C LCD Screen** | 16x2 or 20x4 display | Provides real-time visual feedback of readings |
| **SIM900 GSM Module** | Cellular communication module | Enables remote data transmission via SMS |
| **Portable Power Supply** | Rechargeable power bank | Ensures uninterrupted operation in off-grid locations |

## 📊 Software Requirements

- Arduino IDE (1.8.x or later)
- Required Libraries:
  - OneWire
  - DallasTemperature
  - LiquidCrystal_I2C
  - ThingSpeak
  - SoftwareSerial
  - DHT
  - Additional sensor-specific libraries

## 🛠️ Installation Guide

1. Clone this repository:
   ```bash
   git clone https://github.com/username/panalawahig.git
   cd panalawahig
   ```

2. Connect hardware components according to the wiring diagram in `/docs/wiring_diagram.pdf`

3. Install required Arduino libraries through the Arduino IDE Library Manager

4. Upload the main sketch:
   ```bash
   arduino-cli compile --upload panalawahig.ino --port /dev/ttyUSB0
   ```

5. Configure your ThingSpeak API key in the `config.h` file

## 📝 Usage Instructions

1. Power on the device using the portable power supply
2. Immerse the water sensors in the water source to be tested
3. Wait approximately 60 seconds for sensor calibration
4. Read real-time values on the LCD display
5. Data is automatically transmitted to ThingSpeak and SMS alerts are sent
6. Access the web dashboard for detailed analysis at `https://thingspeak.com/channels/your-channel-id`

## 📊 Data Visualization

Data visualization is available through:
- On-device LCD screen (real-time values)
- ThingSpeak web dashboard (historical data with graphs)
- Exported CSV files for offline analysis
- SMS notifications with current readings

## 🌟 System Benefits

- **Real-time monitoring**: Provides immediate data on water quality, allowing for quick responses to contamination
- **Cost-effective**: Reduces the need for expensive laboratory testing, enabling more frequent assessments
- **Portable and durable**: Designed for use in remote and harsh environments with limited resources
- **Empowering communities**: Provides direct access to water quality data for informed decision-making
- **Low maintenance**: Designed for minimal upkeep in areas with limited technical support
- **Scalable**: System can be easily replicated for multiple deployment locations

## 🚀 Future Developments

- Integration with weather forecasting systems to correlate environmental data with water quality trends
- Advanced data analytics and machine learning models to predict potential contamination events
- Expanded notification features including email and mobile app integration
- Solar power integration for extended field deployment
- Additional sensor integration for comprehensive water quality assessment
- Mobile application development for easier access to data and system management

## 👥 Contributing

We welcome contributions to the Panalawahig project! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on how to get started.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Project Team

Developed by the KAJA Group:
- [Amores, Jancil Joy | Technical Writer](https://www.facebook.com/janciljoy.amores)
- [Bacaltos, Alexis Joseph Yoj P. | Programmer](https://www.facebook.com/captainalexisyoj)
- [Sebandal, Kate Andrea | UI/UX Designer](https://www.facebook.com/kateandrea17)
- [Tejero, Asianna Grace | System Analyst](https://www.facebook.com/grc.versil07)

---

<p align="center">
  Made with ❤️ in Davao City, Philippines
</p>
