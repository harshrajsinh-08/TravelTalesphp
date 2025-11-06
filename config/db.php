
<?php
require_once __DIR__ . '/config.php';

// Yahan MySQLi connection banate hain - PDO se simple hai
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Connection check karte hain - agar fail ho gaya toh error show karo
if ($conn->connect_error) {
    die("Database Not connected " . $conn->connect_error);
}
?>