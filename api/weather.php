<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Simple weather API endpoint for future integration
// This is a placeholder that returns mock data
// In production, this would integrate with OpenWeatherMap or similar service

$action = $_GET['action'] ?? '';
$city = $_GET['city'] ?? '';
$lat = $_GET['lat'] ?? '';
$lon = $_GET['lon'] ?? '';

function generateMockWeatherData($cityName) {
    $baseTemp = 25;
    $tempVariation = rand(-10, 10);
    $temp = $baseTemp + $tempVariation;
    
    $conditions = ['Clear', 'Clouds', 'Rain', 'Drizzle', 'Mist'];
    $condition = $conditions[array_rand($conditions)];
    
    $descriptions = [
        'Clear' => 'clear sky',
        'Clouds' => 'scattered clouds',
        'Rain' => 'light rain',
        'Drizzle' => 'light drizzle',
        'Mist' => 'mist'
    ];
    
    return [
        'name' => $cityName,
        'sys' => ['country' => 'IN'],
        'main' => [
            'temp' => $temp,
            'feels_like' => $temp + rand(-2, 2),
            'temp_min' => $temp - 3,
            'temp_max' => $temp + 5,
            'humidity' => rand(40, 80)
        ],
        'weather' => [[
            'main' => $condition,
            'description' => $descriptions[$condition]
        ]],
        'wind' => [
            'speed' => rand(2, 12)
        ],
        'visibility' => rand(5000, 10000)
    ];
}

function generateMockForecastData($cityName) {
    $forecasts = [];
    $baseTemp = 25;
    
    for ($i = 0; $i < 5; $i++) {
        $date = time() + ($i * 24 * 60 * 60);
        $tempVariation = rand(-7, 7);
        $temp = $baseTemp + $tempVariation;
        
        $conditions = ['Clear', 'Clouds', 'Rain', 'Drizzle'];
        $condition = $conditions[array_rand($conditions)];
        
        $descriptions = [
            'Clear' => 'clear sky',
            'Clouds' => 'few clouds',
            'Rain' => 'light rain',
            'Drizzle' => 'light drizzle'
        ];
        
        $forecasts[] = [
            'dt' => $date,
            'main' => [
                'temp' => $temp,
                'humidity' => rand(50, 80)
            ],
            'weather' => [[
                'main' => $condition,
                'description' => $descriptions[$condition]
            ]]
        ];
    }
    
    return ['list' => $forecasts];
}

try {
    switch ($action) {
        case 'current':
            if (empty($city)) {
                throw new Exception('City parameter is required');
            }
            $weatherData = generateMockWeatherData($city);
            echo json_encode($weatherData);
            break;
            
        case 'forecast':
            if (empty($city)) {
                throw new Exception('City parameter is required');
            }
            $forecastData = generateMockForecastData($city);
            echo json_encode($forecastData);
            break;
            
        case 'current_coords':
            if (empty($lat) || empty($lon)) {
                throw new Exception('Latitude and longitude parameters are required');
            }
            $weatherData = generateMockWeatherData('Your Location');
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