<!-- START MIRAHEZE CONTENT -->

= PANALAWAHIG =
'''IoT-Based Water Quality Testing System for Far-Flung Areas of Davao City'''

== Project Overview ==
'''Panalawahig''' is an innovative IoT-based water quality testing system designed to address the challenges faced by remote and far-flung areas of Davao City in monitoring water safety. Many communities in these regions lack access to reliable water testing facilities, which poses significant health risks due to the potential for contaminated water sources. This project was developed to bridge that gap by providing a portable and easy-to-use system for on-site water quality testing.

Our system offers real-time water quality analysis and transmits the results to a cloud-based platform for remote monitoring. This eliminates the need for physically transporting water samples to distant laboratories, ensuring faster and more accessible results. By utilizing a user-friendly web interface, '''Panalawahig''' allows authorities and local communities to access historical data and track trends in water quality over time, facilitating informed decision-making.

Additionally, '''Panalawahig''' integrates an automated notification system that sends SMS alerts to local authorities with the latest water quality data after each test. This ensures that relevant parties receive timely updates, allowing them to respond quickly to any potential water contamination issues.

== Key Features ==
* '''Real-time water quality testing''' with multiple parameters such as temperature, pH, turbidity, dissolved oxygen, and more.
* '''Web interface''' for real-time data visualization and historical trend tracking, accessible remotely via the ThingSpeak API.
* '''SMS notifications''' for local authorities to receive instant alerts after every water quality test.
* '''Portable design''' suitable for deployment in remote and hard-to-reach areas.
* '''Data-driven decision-making''' to support local communities and government agencies in maintaining clean water resources.

== Hardware Components ==

The system utilizes the following components for comprehensive water quality testing:

* '''DS18B20 Temperature Sensor''': Measures water temperature with high accuracy, critical for assessing water conditions.
* '''TDS Sensor (Total Dissolved Solids)''': Measures the concentration of dissolved solids (salts, minerals, etc.) in water, displayed in ppm (parts per million).
* '''pH Sensor''': Determines the water's acidity or alkalinity on a scale from 0 to 14, essential for evaluating water quality.
* '''Turbidity Sensor''': Measures water clarity by detecting suspended particles, an indicator of water pollution.
* '''Dissolved Oxygen (DO) Sensor''': Assesses the amount of oxygen dissolved in the water, which is crucial for aquatic life sustainability.
* '''Conductivity Sensor''': Measures the water's ability to conduct electricity, which is often correlated with salinity and overall water quality.
* '''ORP Sensor (Oxidation-Reduction Potential)''': Measures the water’s ability to neutralize contaminants, providing insight into water’s purification potential.
* '''Flow Sensor''': Monitors the flow rate of water, useful for dynamic testing environments, especially in rivers or streams.
* '''Water Level Sensor''': Detects fluctuations in water levels, useful for flood monitoring or drought detection.
* '''Temperature and Humidity Sensor (DHT11/DHT22)''': Monitors environmental factors that may affect water quality, such as ambient temperature and humidity.

=== Other Components: ===
* '''Arduino Uno R3''': The microcontroller that processes sensor data and coordinates communication with other components.
* '''I2C LCD Screen''': Provides real-time visual feedback of sensor readings, offering an easy interface for on-site monitoring.
* '''SIM900 GSM Module''': Enables remote data transmission via SMS, ensuring timely communication with local authorities.
* '''Portable Power Supply''': A power bank with adequate capacity to ensure uninterrupted operation in off-grid locations.

== System Overview ==

The '''Panalawahig''' system operates by continuously collecting data from various sensors to evaluate water quality. The sensor data is processed by the Arduino Uno, which then sends the results to a cloud platform via the ThingSpeak API. Local authorities and community members can access this data through a web interface, providing real-time insights into the state of water resources in their area.

'''Panalawahig''' is powered by a portable power source, making it ideal for deployment in remote locations that lack consistent electricity access. The integration of the SIM900 GSM module allows for easy and efficient communication, sending SMS alerts directly to local authorities and other relevant stakeholders whenever the water quality readings exceed predefined thresholds.

=== System Benefits: ===
* '''Real-time monitoring''': Provides immediate data on water quality, allowing for quick responses to contamination.
* '''Cost-effective''': Reduces the need for expensive laboratory testing, enabling more frequent assessments at a fraction of the cost.
* '''Portable and durable''': Designed for use in remote and harsh environments, ensuring reliability and ease of use in areas with limited resources.
* '''Empowering communities''': By providing direct access to water quality data, the system helps local authorities and residents make informed decisions about water usage and safety.

== Future Developments ==

While the current system is designed to monitor the most critical water quality parameters, future iterations of '''Panalawahig''' will aim to incorporate additional sensors and features, such as:
* Integration with weather forecasting systems to correlate environmental data with water quality trends.
* Advanced data analytics and machine learning models to predict potential contamination events before they occur.
* Expanded SMS and email notification features for broader coverage, including nearby health departments and environmental agencies.

== Conclusion ==

'''Panalawahig''' is more than just a water testing system; it is a vital tool that empowers communities in remote areas of Davao City to monitor and safeguard their water resources. With its combination of real-time testing, remote data access, and automated notifications, it provides a comprehensive solution to the pressing issue of water contamination in isolated regions.

By equipping local authorities with accurate, up-to-date information, '''Panalawahig''' contributes to better water management, healthier communities, and a safer environment for all.

---

'''KAJA Group'''

<!-- END MIRAHEZE CONTENT -->
