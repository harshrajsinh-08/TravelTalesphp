<?php
// TravelTales Configuration File

// Environment Configuration
define('ENVIRONMENT', 'development'); // Change to 'production' for live site

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'traveltales');
define('DB_USER', 'root');
define('DB_PASS', '00001111');

// Application Configuration
define('APP_NAME', 'TravelTales');
define('APP_URL', 'http://localhost/traveltales');
define('APP_VERSION', '1.0.0');

// File Upload Configuration
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('UPLOAD_PATH', 'uploads/');

// Security Configuration
define('SESSION_LIFETIME', 3600); // 1 hour

// Email Configuration (for contact forms)
define('SMTP_HOST', '');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('FROM_EMAIL', 'noreply@traveltales.com');
define('FROM_NAME', 'TravelTales');

// Pagination
define('POSTS_PER_PAGE', 12);
define('BLOGS_PER_PAGE', 9);

// API Configuration
define('MAPS_API_KEY', ''); // Add your maps API key if needed

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Error Reporting
error_reporting(0);
ini_set('display_errors', 0);
?>