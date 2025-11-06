<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// OpenWeatherMap API configuration
const OPENWEATHER_API_KEY = '0803af3c4dd129fe61e0256095fc930f';
const OPENWEATHER_BASE_URL = 'https://api.openweathermap.org/data/2.5';

$action = $_GET['action'] ?? '';
$city = $_GET['city'] ?? '';
$lat = $_GET['lat'] ?? '';
$lon = $_GET['lon'] ?? '';

function fetchWeatherData($url) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'user_agent' => 'TravelTales Weather App'
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        throw new Exception('Failed to fetch weather data from API');
    }
    
    $data = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON response from weather API');
    }
    
    if (isset($data['cod']) && $data['cod'] !== 200 && $data['cod'] !== '200') {
        throw new Exception($data['message'] ?? 'Weather API error');
    }
    
    return $data;
}

function getCurrentWeatherByCity($city) {
    $url = OPENWEATHER_BASE_URL . '/weather?' . http_build_query([
        'q' => $city,
        'appid' => OPENWEATHER_API_KEY,
        'units' => 'metric'
    ]);
    
    return fetchWeatherData($url);
}





try {
    switch ($action) {
        case 'current':
            if (empty($city)) {
                throw new Exception('City parameter is required');
            }
            $weatherData = getCurrentWeatherByCity($city);
            echo json_encode($weatherData);
            break;
            

            

            
        case 'cities':
            // Return popular Indian cities
            $cities = [
                ['name' => 'Mumbai', 'state' => 'Maharashtra'],
                ['name' => 'Delhi', 'state' => 'National Capital Territory'],
                ['name' => 'Bangalore', 'state' => 'Karnataka'],
                ['name' => 'Chennai', 'state' => 'Tamil Nadu'],
                ['name' => 'Kolkata', 'state' => 'West Bengal'],
                ['name' => 'Hyderabad', 'state' => 'Telangana'],
                ['name' => 'Pune', 'state' => 'Maharashtra'],
                ['name' => 'Ahmedabad', 'state' => 'Gujarat'],
                ['name' => 'Jaipur', 'state' => 'Rajasthan'],
                ['name' => 'Surat', 'state' => 'Gujarat']
            ];
            echo json_encode($cities);
            break;
            
        default:
            throw new Exception('Invalid action parameter');
    }
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}
?>