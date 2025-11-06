<?php
session_start();
require 'config/db.php';

$page_title = "Newsletter Subscription - TravelTales";
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = trim($_POST['email'] ?? '');
        
        // Email validation - basic check karte hain
        if (empty($email)) {
            throw new Exception('Email is required');
        }
        
        // Simple email validation - student project ke liye basic hai
        if (empty($email) || !strpos($email, '@')) {
            throw new Exception('Please enter a valid email address');
        }
    
        
        // Check if email already exists
        $email = $conn->real_escape_string($email);
        $checkQuery = "SELECT id, is_active FROM newsletter_subscribers WHERE email = '$email'";
        $result = $conn->query($checkQuery);
        
        if (!$result) {
            throw new Exception('Database error occurred. Please try again later.');
        }
        
        $existing = $result->fetch_assoc();
        
        if ($existing) {
            if ($existing['is_active']) {
                $message = 'This email is already subscribed to our newsletter';
                $messageType = 'info';
            } else {
                // Reactivate subscription
                $updateQuery = "UPDATE newsletter_subscribers SET is_active = TRUE, subscribed_at = CURRENT_TIMESTAMP WHERE email = '$email'";
                if (!$conn->query($updateQuery)) {
                    throw new Exception('Database error occurred. Please try again later.');
                }
                
                $message = 'Welcome back! Your subscription has been reactivated.';
                $messageType = 'success';
            }
        } else {
            // Insert new subscription
            $insertQuery = "INSERT INTO newsletter_subscribers (email) VALUES ('$email')";
            if (!$conn->query($insertQuery)) {
                // Check if it's a duplicate entry error
                if ($conn->errno == 1062) {
                    $message = 'This email is already subscribed to our newsletter';
                    $messageType = 'info';
                } else {
                    throw new Exception('Database error occurred. Please try again later.');
                }
            } else {
                $message = 'Thank you for subscribing! You\'ll receive our latest travel updates.';
                $messageType = 'success';
            }
        }
        
    } catch (Exception $e) {
        $message = $e->getMessage();
        $messageType = 'error';
        error_log("Newsletter subscription error: " . $e->getMessage());
    }
}
?>

<?php include 'includes/header.php'; ?>

<style>
  .hero-section { 
    height: 40vh; 
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
  }
</style>

<?php include 'includes/navbar.php'; ?>

<!-- Hero Section -->
<header class="hero-section relative flex items-center justify-center">
  <div class="absolute inset-0 shadow-md p-8" ></div>
  <div class="relative text-center text-white px-4">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">Newsletter Subscription</h1>
    <p class="text-xl opacity-90">Stay updated with the latest travel stories and tips</p>
  </div>
</header>

<!-- Main Content -->
<section class="container mx-auto px-4 py-16">
  <div class="max-w-2xl mx-auto">
    
    <?php if ($message): ?>
      <div class="mb-8 p-6 rounded-lg <?php 
        echo $messageType === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 
             ($messageType === 'info' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 
              'bg-red-50 text-red-700 border border-red-200'); 
      ?>">
        <div class="flex items-center gap-3">
          <i class="bi <?php 
            echo $messageType === 'success' ? 'bi-check-circle' : 
                 ($messageType === 'info' ? 'bi-info-circle' : 'bi-exclamation-triangle'); 
          ?> text-xl"></i>
          <p class="font-medium"><?= htmlspecialchars($message) ?></p>
        </div>
      </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-md p-8">
      <h2 class="text-2xl font-bold mb-6 text-center">Subscribe to Our Newsletter</h2>
      
      <form action="newsletter-subscribe.php" method="POST" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            Email Address
          </label>
          <input 
            type="email" 
            id="email"
            name="email" 
            placeholder="Enter your email address"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
            required
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
          />
        </div>
        
        <button 
          type="submit" 
          class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 px-6 rounded-lg transition font-medium"
        >
          Subscribe to Newsletter
        </button>
      </form>
      
      <div class="mt-6 text-center">
        <p class="text-gray-600 text-sm">
          By subscribing, you agree to receive travel updates and tips from TravelTales. 
          You can unsubscribe at any time.
        </p>
      </div>
    </div>

    <!-- Benefits Section -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="text-center p-6">
        <i class="bi bi-envelope text-3xl text-orange-500 mb-4"></i>
        <h3 class="font-bold text-lg mb-2">Weekly Updates</h3>
        <p class="text-gray-600">Get the latest travel stories and destination guides delivered to your inbox.</p>
      </div>
      
      <div class="text-center p-6">
        <i class="bi bi-map text-3xl text-orange-500 mb-4"></i>
        <h3 class="font-bold text-lg mb-2">Travel Tips</h3>
        <p class="text-gray-600">Discover hidden gems and insider tips from experienced travelers.</p>
      </div>
      
      <div class="text-center p-6">
        <i class="bi bi-gift text-3xl text-orange-500 mb-4"></i>
        <h3 class="font-bold text-lg mb-2">Exclusive Offers</h3>
        <p class="text-gray-600">Be the first to know about special deals and travel opportunities.</p>
      </div>
    </div>

    <div class="text-center mt-8">
      <a href="index.php" class="inline-flex items-center gap-2 text-orange-500 hover:text-orange-600 font-medium">
        <i class="bi bi-arrow-left"></i>
        Back to Home
      </a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>