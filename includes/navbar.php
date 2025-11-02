<?php
$current_page = basename($_SERVER['PHP_SELF']);
$userEmail = $_SESSION['user'] ?? null;
?>

<!-- Navbar -->
<nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 shadow-sm">
  <div class="container mx-auto px-4 py-4">
    <div class="flex justify-between items-center">
      
      <!-- Logo -->
      <a href="index.php" class="text-2xl font-bold text-orange-500 hover:text-orange-600 transition">
        TravelTales
      </a>

      <!-- Desktop Menu -->
      <div class="hidden md:flex space-x-6 font-medium">
        <a href="explore.php" class="nav-link <?= $current_page === 'explore.php' ? 'text-orange-500 font-semibold' : 'hover:text-orange-500' ?> transition">Explore</a>
        <a href="blogs.php" class="nav-link <?= $current_page === 'blogs.php' ? 'text-orange-500 font-semibold' : 'hover:text-orange-500' ?> transition">Blog</a>
        <a href="weather.php" class="nav-link <?= $current_page === 'weather.php' ? 'text-orange-500 font-semibold' : 'hover:text-orange-500' ?> transition">Weather</a>
        <a href="trip-planner.php" class="nav-link <?= $current_page === 'trip-planner.php' ? 'text-orange-500 font-semibold' : 'hover:text-orange-500' ?> transition">My Trips</a>
        <a href="profile.php" class="nav-link <?= $current_page === 'profile.php' ? 'text-orange-500 font-semibold' : 'hover:text-orange-500' ?> transition">Profile</a>
        <a href="about.php" class="nav-link <?= $current_page === 'about.php' ? 'text-orange-500 font-semibold' : 'hover:text-orange-500' ?> transition">About</a>
        <a href="contact.php" class="nav-link <?= $current_page === 'contact.php' ? 'text-orange-500 font-semibold' : 'hover:text-orange-500' ?> transition">Contact</a>
      </div>

      <!-- Right Buttons -->
      <div class="hidden md:flex items-center space-x-4">
        <?php if ($userEmail): ?>
          <span class="text-sm text-gray-600"><?= htmlspecialchars($userEmail) ?></span>
          <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition">
            Logout
          </a>
        <?php else: ?>
          <a href="templates/login.html" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition">
            Login
          </a>
        <?php endif; ?>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-toggle" class="md:hidden">
        <i class="bi bi-list text-2xl"></i>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden flex-col gap-4 px-4 py-6 mt-2 bg-white shadow-md rounded-lg">
      <a href="explore.php" class="nav-link text-gray-700">Explore</a>
      <a href="blogs.php" class="nav-link text-gray-700">Blog</a>
      <a href="weather.php" class="nav-link text-gray-700">Weather</a>
      <a href="trip-planner.php" class="nav-link text-gray-700">My Trips</a>
      <a href="profile.php" class="nav-link text-gray-700">Profile</a>
      <a href="about.php" class="nav-link text-gray-700">About</a>
      <a href="contact.php" class="nav-link text-gray-700">Contact</a>

      <?php if ($userEmail): ?>
        <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition w-full text-center">
          Logout
        </a>
      <?php else: ?>
        <a href="templates/login.html" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm transition w-full text-center">
          Login
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>