<?php
// Basic error handler for TravelTales

error_reporting(0);
ini_set('display_errors', 0);

// Security helper functions
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}


?>