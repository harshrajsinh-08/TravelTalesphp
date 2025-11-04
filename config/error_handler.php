<?php
// Student project ke liye simple helper functions

// Basic input sanitization - XSS se bachne ke liye
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// MySQLi ke liye string escape karne ka function
function escapeString($conn, $input) {
    return $conn->real_escape_string($input);
}
?>