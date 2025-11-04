<?php
header('Content-Type: application/json');
require '../config/db.php';

$city = isset($_GET['city']) ? strtolower(trim($_GET['city'])) : '';
if ($city === '') {
    echo json_encode(["error" => "City is required"]);
    exit;
}

// City name ko safely escape karte hain SQL injection se bachne ke liye
$city = $conn->real_escape_string($city);

// Attractions aur city info fetch karte hain - MySQLi use kar rahe hain
$query = "SELECT 
    a.name, a.price_range, a.city_image,
    c.how_to_reach, c.nearest_station, c.nearest_airport
FROM attractions a
LEFT JOIN city_info c ON LOWER(a.city) = LOWER(c.city)
WHERE LOWER(a.city) = '$city'";

$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    echo json_encode(["city_image" => null, "attractions" => []]);
    exit;
}

// Get the first row for city info
$firstRow = $result->fetch_assoc();
$cityImage = $firstRow['city_image'];
$howToReach = $firstRow['how_to_reach'];
$nearestStation = $firstRow['nearest_station'];
$nearestAirport = $firstRow['nearest_airport'];

// Reset result pointer and collect all attractions
$result->data_seek(0);
$attractions = [];
while ($row = $result->fetch_assoc()) {
    $attractions[] = [
        "name" => $row['name'],
        "price_range" => $row['price_range']
    ];
}

echo json_encode([
    "city_image" => $cityImage,
    "attractions" => $attractions,
    "how_to_reach" => $howToReach,
    "nearest_station" => $nearestStation,
    "nearest_airport" => $nearestAirport
]);

$conn->close();
?>