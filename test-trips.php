<?php
// Simple test script to check trips functionality
require 'config/db.php';

echo "<h2>Database Connection Test</h2>";

// Test database connection
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit();
} else {
    echo "<p style='color: green;'>✅ Database connected successfully</p>";
}

// Test if trips table exists
$result = $conn->query("SHOW TABLES LIKE 'trips'");
if ($result->num_rows > 0) {
    echo "<p style='color: green;'>✅ Trips table exists</p>";
} else {
    echo "<p style='color: red;'>❌ Trips table does not exist</p>";
    echo "<p>Run the database_schema.sql file to create the table</p>";
    exit();
}

// Test trips table structure
$result = $conn->query("DESCRIBE trips");
if ($result) {
    echo "<h3>Trips Table Structure:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Test sample data
$result = $conn->query("SELECT COUNT(*) as count FROM trips");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>Total trips in database: " . $row['count'] . "</p>";
}

echo "<p><a href='trip-planner.php'>← Back to Trip Planner</a></p>";
?>