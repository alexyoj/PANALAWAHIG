<!-- START MIRAHEZE CONTENT -->

# PANALAWAHIG
IoT-Based Water Quality Testing System for far-flung Areas of Davao City

## Project Overview
**Panalawahig** is an IoT-based water quality testing system designed specifically for remote and far-flung areas of Davao City. We developed this project to address the critical challenge faced by communities located far from water testing laboratories. These communities often lack access to timely water quality testing, which can pose serious health risks. Our portable system enables on-site water quality assessment and remote data transmission, eliminating the need for physical samples to be transported to distant laboratories.

In addition to real-time testing, Panalawahig features a user-friendly web interface that allows users to view historical data, helping communities and authorities track water quality trends over time. This web platform is connected via the ThingSpeak API, enabling seamless data transfer from the device to the online system for remote access and monitoring.

Moreover, after every water quality test, the device automatically sends an SMS notification to local authorities in remote areas, providing them with the latest water quality data. This ensures timely updates and quick responses in case of any detected water contamination.

## Hardware Components

The system utilizes the following components:
- DS18B20 Temperature Sensor — Measures water temperature accurately.
- TDS Sensor (Total Dissolved Solids) — Measures the concentration of dissolved particles (salts, minerals, etc.) in water (in ppm).
- pH Sensor — Determines the acidity or alkalinity of water (scale from 0 to 14).
- Turbidity Sensor — Measures water clarity by detecting suspended particles.
- Dissolved Oxygen (DO) Sensor — Checks the amount of oxygen dissolved in water, crucial for aquatic life.
- Conductivity Sensor — Measures the water's ability to conduct electricity, often linked to salinity.
- ORP Sensor (Oxidation-Reduction Potential) — Assesses water’s ability to break down contaminants.
- Flow Sensor — Monitors the flow rate of water, useful for dynamic testing environments.
- Water Level Sensor — Detects changes in water levels, useful for checking overflows or drought conditions.
-Temperature and Humidity Sensor (DHT11/DHT22) — Monitors environmental conditions that may affect water quality.

Other Components:
- Arduino Uno R3 (microcontroller)
- I2C LCD screen (for displaying real-time sensor readings)
- SIM900 GSM module (for remote data transmission and SMS notifications)
- Powerbank (portable power supply)
  
These components work together to provide comprehensive water quality analysis in areas where traditional laboratory testing is impractical due to geographic isolation.

Alexis Joseph Yoj Bacaltos
<!-- END MIRAHEZE CONTENT -->
