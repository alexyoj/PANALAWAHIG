<?php
class DatabaseFetcher {
    private $db;
    private $thingspeak_write_key = 'USTGNC1OLEAVKVK9';
    private $thingspeak_read_key = 'DYA9VXKKOIC2GVX9';
    private $channel_id = '2624484';
    private $updateInterval = 15; // minimum seconds between updates

    public function __construct() {
        try {
            $this->db = new mysqli('localhost', 'root', '', 'panalawahig_db');
            
            if ($this->db->connect_error) {
                throw new Exception('Connection failed: ' . $this->db->connect_error);
            }
        } catch (Exception $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }

    private function canUpdate() {
        $query = "SELECT timestamp FROM sensor_readings ORDER BY timestamp DESC LIMIT 1";
        $result = $this->db->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            $lastUpdate = strtotime($row['timestamp']);
            $timeSinceUpdate = time() - $lastUpdate;
            return $timeSinceUpdate >= $this->updateInterval;
        }
        return true;
    }

    public function sendToThingSpeak($data) {
        try {
            if (!$this->canUpdate()) {
                error_log("Update too frequent, skipping ThingSpeak update");
                return [
                    'success' => false,
                    'error' => 'Update too frequent'
                ];
            }

            // Get last reading for validation
            $lastData = $this->getThingSpeakData(1);
            if ($lastData['success'] && !empty($lastData['data'])) {
                $last = $lastData['data'][0];
                
                // Validate TDS changes
                if (isset($last['field3']) && isset($data['tds'])) {
                    $lastTDS = floatval($last['field3']);
                    $currentTDS = floatval($data['tds']);
                    $percentChange = abs(($currentTDS - $lastTDS) / $lastTDS * 100);
                    
                    if ($percentChange > 20) {
                        error_log("TDS change too large: Previous = $lastTDS, Current = $currentTDS");
                        return [
                            'success' => false,
                            'error' => 'TDS variation too large'
                        ];
                    }
                }

                // Validate pH changes
                if (isset($last['field1']) && isset($data['ph'])) {
                    $lastPH = floatval($last['field1']);
                    $currentPH = floatval($data['ph']);
                    if (abs($currentPH - $lastPH) > 1.0) {
                        error_log("pH change too large: Previous = $lastPH, Current = $currentPH");
                        return [
                            'success' => false,
                            'error' => 'pH variation too large'
                        ];
                    }
                }
            }

            $url = "https://api.thingspeak.com/update?api_key=" . $this->thingspeak_write_key;
            
            if (isset($data['ph'])) $url .= "&field1=" . $data['ph'];
            if (isset($data['turbidity'])) $url .= "&field2=" . $data['turbidity'];
            if (isset($data['tds'])) $url .= "&field3=" . $data['tds'];
            if (isset($data['temperature'])) $url .= "&field4=" . $data['temperature'];
            
            error_log("Sending to ThingSpeak: " . $url);
            
            $response = file_get_contents($url);
            error_log("ThingSpeak Response: " . $response);
            
            return [
                'success' => $response !== false,
                'response' => $response
            ];
        } catch (Exception $e) {
            error_log("ThingSpeak Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getThingSpeakData($results = 2) {
        try {
            $url = "https://api.thingspeak.com/channels/{$this->channel_id}/feeds.json?" .
                   "api_key={$this->thingspeak_read_key}&results={$results}";
            
            error_log("Fetching ThingSpeak data: " . $url);
            
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            
            if (!$data) {
                throw new Exception("Failed to fetch ThingSpeak data");
            }
            
            return [
                'success' => true,
                'data' => $data['feeds']
            ];
        } catch (Exception $e) {
            error_log("ThingSpeak Fetch Error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getAveragedThingSpeakData($samples = 5) {
        try {
            $data = $this->getThingSpeakData($samples);
            if (!$data['success']) {
                throw new Exception("Failed to fetch ThingSpeak data");
            }

            $sum = [
                'tds' => 0,
                'ph' => 0,
                'turbidity' => 0,
                'temperature' => 0
            ];
            $count = 0;

            foreach ($data['data'] as $reading) {
                if (isset($reading['field1'])) $sum['temperature'] += floatval($reading['field1']);
                if (isset($reading['field2'])) $sum['turbidity'] += floatval($reading['field2']);
                if (isset($reading['field3'])) $sum['tds'] += floatval($reading['field3']);
                if (isset($reading['field4'])) $sum['ph'] += floatval($reading['field4']);
                $count++;
            }

            if ($count > 0) {
                return [
                    'success' => true,
                    'data' => [
                        'ph' => round($sum['ph'] / $count, 2),
                        'turbidity' => round($sum['turbidity'] / $count, 2),
                        'tds' => round($sum['tds'] / $count, 2),
                        'temperature' => round($sum['temperature'] / $count, 2)
                    ]
                ];
            }

            throw new Exception("No valid data found");
        } catch (Exception $e) {
            error_log("Average calculation error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function fetchData($place) {
        try {
            error_log("Fetching data for location: " . $place);

            $locationMap = [
                'Malagamot' => 'Malagamot',
                'ACD' => 'ACD'
            ];

            $databasePlace = $locationMap[$place] ?? $place;
            
            $query = "SELECT * FROM sensor_readings 
                     WHERE location = ? 
                     ORDER BY timestamp DESC 
                     LIMIT 1";
                     
            $stmt = $this->db->prepare($query);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->db->error);
            }

            $stmt->bind_param('s', $databasePlace);

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            
            $readings = [];
            while ($row = $result->fetch_assoc()) {
                error_log("Processing row: " . json_encode($row));
                
                $readings[] = [
                    'timestamp' => $row['timestamp'],
                    'ph' => $row['ph'] !== null ? floatval($row['ph']) : null,
                    'turbidity' => $row['turbidity'] !== null ? floatval($row['turbidity']) : null,
                    'temperature' => $row['temperature'] !== null ? floatval($row['temperature']) : null,
                    'tds' => $row['tds'] !== null ? floatval($row['tds']) : null,
                    'location' => $row['location']
                ];

                if ($this->canUpdate()) {
                    $thingspeakResult = $this->sendToThingSpeak($row);
                    error_log("ThingSpeak upload result: " . json_encode($thingspeakResult));
                }
            }
            
            $stmt->close();
            
            return [
                'success' => true,
                'data' => $readings
            ];

        } catch (Exception $e) {
            error_log("Data fetch error: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Database error: ' . $e->getMessage()
            ];
        }
    }

    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}

// Handle requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    
    try {
        $fetcher = new DatabaseFetcher();

        // Get averaged data
        if (isset($_GET['averaged'])) {
            echo json_encode($fetcher->getAveragedThingSpeakData(5));
            exit;
        }

        // Test endpoint
        if (isset($_GET['test'])) {
            try {
                $db = new mysqli('localhost', 'root', '', 'panalawahig_db');
                $result = $db->query("SELECT DISTINCT location FROM sensor_readings");
                echo "Available locations:\n";
                while ($row = $result->fetch_assoc()) {
                    echo $row['location'] . "\n";
                }
                
                echo "\nSample data:\n";
                $result = $db->query("SELECT * FROM sensor_readings LIMIT 1");
                print_r($result->fetch_assoc());
                
                $db->close();
                exit;
            } catch (Exception $e) {
                echo "Test failed: " . $e->getMessage();
                exit;
            }
        }

        // ThingSpeak test
        if (isset($_GET['thingspeak_test'])) {
            $testData = [
                'ph' => 7.0,
                'turbidity' => 1.5,
                'tds' => 128,
                'temperature' => 25.5
            ];
            
            echo "Testing ThingSpeak Write:\n";
            print_r($fetcher->sendToThingSpeak($testData));
            
            echo "\nTesting ThingSpeak Read:\n";
            print_r($fetcher->getThingSpeakData(2));
            exit;
        }

        // Normal data fetch
        $place = $_GET['place'] ?? '';
        
        if (empty($place)) {
            echo json_encode([
                'success' => false,
                'error' => 'Place parameter is required'
            ]);
            exit;
        }

        echo json_encode($fetcher->fetchData($place));

    } catch (Exception $e) {
        error_log("Main execution error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => 'Server error occurred'
        ]);
    }
}
?>