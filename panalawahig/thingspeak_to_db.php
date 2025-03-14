<?php
class ThingSpeakSync {
    private $db;
    private $thingspeak_read_key = 'DYA9VXKKOIC2GVX9';
    private $channel_id = '2624484';
    private $location = 'Malagamot'; // Default location
    private $sync_interval = 60; // Changed to 60 seconds (1 minute)

    public function __construct() {
        try {
            $this->db = new mysqli('localhost', 'root', '', 'panalawahig_db');
            
            if ($this->db->connect_error) {
                throw new Exception('Connection failed: ' . $this->db->connect_error);
            }

            // Set timezone
            date_default_timezone_set('Asia/Manila');
            
        } catch (Exception $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }

    public function fetchFromThingSpeak() {
        try {
            $url = "https://api.thingspeak.com/channels/{$this->channel_id}/feeds/last.json?" .
                   "api_key={$this->thingspeak_read_key}";
            
            $response = file_get_contents($url);
            if (!$response) {
                throw new Exception("Failed to fetch data from ThingSpeak");
            }

            $data = json_decode($response, true);
            if (!$data) {
                throw new Exception("Invalid data received from ThingSpeak");
            }

            return [
                'success' => true,
                'data' => [
                    'timestamp' => $data['created_at'],
                    'temperature' => floatval($data['field1']),
                    'turbidity' => floatval($data['field2']),
                    'tds' => floatval($data['field3']),
                    'ph' => floatval($data['field4'])
                ]
            ];
        } catch (Exception $e) {
            error_log("ThingSpeak Fetch Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function saveToDatabase($data) {
        try {
            // Check if this reading already exists
            $checkQuery = "SELECT id FROM sensor_readings 
                         WHERE timestamp = ? AND location = ?";
            $checkStmt = $this->db->prepare($checkQuery);
            $timestamp = date('Y-m-d H:i:s', strtotime($data['timestamp']));
            $checkStmt->bind_param('ss', $timestamp, $this->location);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                error_log("Reading already exists for timestamp: $timestamp");
                return [
                    'success' => false,
                    'error' => 'Reading already exists'
                ];
            }

            // Insert new reading
            $query = "INSERT INTO sensor_readings (timestamp, temperature, turbidity, tds, ph, location) 
                     VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param(
                'sdddds',
                $timestamp,
                $data['temperature'],
                $data['turbidity'],
                $data['tds'],
                $data['ph'],
                $this->location
            );

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            error_log("Successfully saved reading for timestamp: $timestamp");
            return [
                'success' => true,
                'message' => 'Data saved successfully'
            ];

        } catch (Exception $e) {
            error_log("Database Save Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function syncData() {
        $thingspeakData = $this->fetchFromThingSpeak();
        
        if (!$thingspeakData['success']) {
            return $thingspeakData;
        }

        return $this->saveToDatabase($thingspeakData['data']);
    }

    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}

// Handle the sync process
$sync = new ThingSpeakSync();
$result = $sync->syncData();

// Output result for logging
echo json_encode($result);
?>