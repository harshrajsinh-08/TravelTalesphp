<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html");
    exit();
}

$userEmail = $_SESSION['user'];

// Naya trip add karne ka process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_trip') {
    $destination = $conn->real_escape_string($_POST['destination']);
    $startDate = $conn->real_escape_string($_POST['start_date']);
    $endDate = $conn->real_escape_string($_POST['end_date']);
    $notes = isset($_POST['notes']) ? $conn->real_escape_string($_POST['notes']) : '';
    $userEmail = $conn->real_escape_string($userEmail);

    $query = "INSERT INTO trips (user_email, destination, start_date, end_date, notes, created_at) VALUES ('$userEmail', '$destination', '$startDate', '$endDate', '$notes', NOW())";
    $conn->query($query);
    
    header("Location: trip-planner.php?success=1");
    exit();
}

// Trip delete karne ka process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_trip') {
    $tripId = $conn->real_escape_string($_POST['trip_id']);
    $userEmail = $conn->real_escape_string($userEmail);
    
    $query = "DELETE FROM trips WHERE id = '$tripId' AND user_email = '$userEmail'";
    $conn->query($query);
    
    header("Location: trip-planner.php?deleted=1");
    exit();
}

// User ke saare trips fetch karte hain
$userEmail = $conn->real_escape_string($userEmail);
$query = "SELECT * FROM trips WHERE user_email = '$userEmail' ORDER BY start_date ASC";
$result = $conn->query($query);
$trips = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trips[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Trips - TravelTales</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"/>
  <style>
    body { font-family: "Poppins", sans-serif; }
    .nav-link:hover { color: #f97316; transition: color 0.3s ease; }
  </style>
</head>
<body class="bg-gray-50">

<!-- Navbar -->
<nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 shadow-sm">
  <div class="container mx-auto px-4 py-4">
    <div class="flex justify-between items-center">
      <a href="index.php" class="text-2xl font-bold text-orange-500 hover:text-orange-600 transition">
        TravelTales
      </a>
      <div class="hidden md:flex space-x-6 font-medium">
        <a href="explore.php" class="nav-link hover:text-orange-500 transition">Explore</a>
        <a href="blogs.php" class="nav-link hover:text-orange-500 transition">Blog</a>
        <a href="trip-planner.php" class="nav-link text-orange-500 font-semibold">My Trips</a>
        <a href="profile.php" class="nav-link hover:text-orange-500 transition">Profile</a>
        <a href="about.php" class="nav-link hover:text-orange-500 transition">About</a>
        <a href="contact.php" class="nav-link hover:text-orange-500 transition">Contact</a>
      </div>
      <div class="hidden md:flex items-center space-x-4">
        <span class="text-sm text-gray-600"><?= htmlspecialchars($userEmail) ?></span>
        <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition">
          Logout
        </a>
      </div>
      <button id="mobile-menu-toggle" class="md:hidden">
        <i class="bi bi-list text-2xl"></i>
      </button>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t opacity-0 -translate-y-5 transition-all duration-200">
      <div class="px-4 py-4 space-y-3">
        <a href="explore.php" class="block py-2 text-gray-700 hover:text-orange-500 transition">Explore</a>
        <a href="blogs.php" class="block py-2 text-gray-700 hover:text-orange-500 transition">Blog</a>
        <a href="trip-planner.php" class="block py-2 text-orange-500 font-semibold">My Trips</a>
        <a href="profile.php" class="block py-2 text-gray-700 hover:text-orange-500 transition">Profile</a>
        <a href="about.php" class="block py-2 text-gray-700 hover:text-orange-500 transition">About</a>
        <a href="contact.php" class="block py-2 text-gray-700 hover:text-orange-500 transition">Contact</a>
        <div class="pt-3 border-t">
          <span class="block text-sm text-gray-600 mb-2"><?= htmlspecialchars($userEmail) ?></span>
          <a href="logout.php" class="block bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm text-center transition">
            Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Trip Planner Section -->
<section class="container mx-auto px-4 py-32">
  <h1 class="text-4xl font-bold mb-8 text-center">My Trip Planner</h1>
  
  <?php if (isset($_GET['success'])): ?>
    <div class="bg-green-100 text-green-700 p-4 mb-6 rounded-lg text-center">
      Trip added successfully!
    </div>
  <?php endif; ?>
  
  <?php if (isset($_GET['deleted'])): ?>
    <div class="bg-blue-100 text-blue-700 p-4 mb-6 rounded-lg text-center">
      Trip deleted successfully!
    </div>
  <?php endif; ?>

  <!-- Add New Trip Form -->
  <div class="bg-white rounded-xl shadow-md p-6 mb-8 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Plan a New Trip</h2>
    <form method="POST" class="space-y-4">
      <input type="hidden" name="action" value="add_trip">
      
      <div>
        <label class="block font-semibold mb-2">Destination</label>
        <input type="text" name="destination" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block font-semibold mb-2">Start Date</label>
          <input type="date" name="start_date" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>
        <div>
          <label class="block font-semibold mb-2">End Date</label>
          <input type="date" name="end_date" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>
      </div>
      
      <div>
        <label class="block font-semibold mb-2">Notes (Optional)</label>
        <textarea name="notes" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500" placeholder="Add any notes about your trip..."></textarea>
      </div>
      
      <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg transition">
        Add Trip
      </button>
    </form>
  </div>

  <!-- My Trips List -->
  <div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">My Planned Trips</h2>
    
    <?php if ($trips): ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($trips as $trip): ?>
          <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($trip['destination']) ?></h3>
            <p class="text-gray-600 mb-2">
              <i class="bi bi-calendar"></i> 
              <?= date('M j, Y', strtotime($trip['start_date'])) ?> - 
              <?= date('M j, Y', strtotime($trip['end_date'])) ?>
            </p>
            <?php if ($trip['notes']): ?>
              <p class="text-gray-700 mb-4"><?= htmlspecialchars($trip['notes']) ?></p>
            <?php endif; ?>
            
            <div class="flex justify-between items-center">
              <span class="text-sm text-gray-500">
                Added <?= date('M j, Y', strtotime($trip['created_at'])) ?>
              </span>
              <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this trip?')">
                <input type="hidden" name="action" value="delete_trip">
                <input type="hidden" name="trip_id" value="<?= $trip['id'] ?>">
                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="text-center text-gray-600 py-12">
        <i class="bi bi-map text-4xl mb-4"></i>
        <p class="text-lg">No trips planned yet. Start planning your next adventure!</p>
      </div>
    <?php endif; ?>
  </div>

  <!-- Back to Home -->
  <div class="text-center mt-12">
    <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition">
      ← Back to Home
    </a>
  </div>
</section>

<script src="public/js/navigation.js"></script>

</body>
</html>