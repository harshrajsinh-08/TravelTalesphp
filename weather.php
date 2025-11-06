<?php
session_start();
require 'config/db.php';

$page_title = "Weather - TravelTales";
$additional_scripts = ['public/js/weather.js'];

// Redirect if user not logged in
if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html");
    exit();
}

$userEmail = $_SESSION['user'];
?>

<?php include 'includes/header.php'; ?>

<style>

  .weather-card {
    background-color: white;
    border-radius: 0.75rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
  }
  .weather-icon {
    width: 80px;
    height: 80px;
  }

  .weather-detail {
    @apply flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0;
  }
  .loading-skeleton {
    @apply animate-pulse bg-gray-200 rounded;
  }
</style>

<?php include 'includes/navbar.php'; ?>

<!-- Hero Section -->
<header class="relative h-96 flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1504608524841-42fe6f032b4b'); background-size: cover; background-position: center;">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="relative text-center text-white px-4">
    <h1 class="text-4xl md:text-6xl font-bold mb-6">Weather Information</h1>
    <p class="text-xl mb-8">Check weather conditions for your travel destinations</p>
  </div>
</header>

<!-- Search Section -->
<section class="container mx-auto px-4 py-8">
  <div class="max-w-2xl mx-auto">
    <div class="flex flex-col md:flex-row gap-4">
      <div class="flex-1 relative">
        <input 
          type="text" 
          id="cityInput" 
          placeholder="Enter city name (e.g., Mumbai, Delhi, Bangalore)"
          class="w-full px-6 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-gray-800"
        />
        <div id="citySearchResults" class="absolute left-0 right-0 mt-1 bg-white rounded-lg shadow-lg overflow-hidden hidden z-10"></div>
      </div>
      <button 
        onclick="searchWeather()" 
        class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-full flex items-center justify-center gap-2"
        id="searchBtn"
      >
        <i class="bi bi-search"></i>
        Search Weather
      </button>

    </div>
  </div>
</section>

<!-- Current Weather Section -->
<section id="currentWeatherSection" class="container mx-auto px-4 py-8 hidden">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold mb-8 text-center">Current Weather</h2>
    
    <!-- Main Weather Card -->
    <div id="currentWeatherCard" class="weather-card mb-8">
      <!-- Content will be populated by JavaScript -->
    </div>

    <!-- Weather Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="weather-card text-center">
        <i class="bi bi-thermometer-half text-3xl text-orange-500 mb-2"></i>
        <h3 class="font-semibold text-gray-700">Feels Like</h3>
        <p id="feelsLike" class="text-2xl font-bold text-gray-800">--°C</p>
      </div>
      <div class="weather-card text-center">
        <i class="bi bi-droplet text-3xl text-blue-500 mb-2"></i>
        <h3 class="font-semibold text-gray-700">Humidity</h3>
        <p id="humidity" class="text-2xl font-bold text-gray-800">--%</p>
      </div>
      <div class="weather-card text-center">
        <i class="bi bi-wind text-3xl text-green-500 mb-2"></i>
        <h3 class="font-semibold text-gray-700">Wind Speed</h3>
        <p id="windSpeed" class="text-2xl font-bold text-gray-800">-- km/h</p>
      </div>
      <div class="weather-card text-center">
        <i class="bi bi-eye text-3xl text-purple-500 mb-2"></i>
        <h3 class="font-semibold text-gray-700">Visibility</h3>
        <p id="visibility" class="text-2xl font-bold text-gray-800">-- km</p>
      </div>
    </div>
  </div>
</section>





<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg p-8 text-center">
    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500 mx-auto mb-4"></div>
    <p class="text-gray-600">Loading weather data...</p>
  </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg p-8 max-w-md mx-4">
    <div class="text-center">
      <i class="bi bi-exclamation-triangle text-4xl text-red-500 mb-4"></i>
      <h3 class="text-xl font-bold mb-2">Error</h3>
      <p id="errorMessage" class="text-gray-600 mb-4">Something went wrong. Please try again.</p>
      <button onclick="closeErrorModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg transition">
        Close
      </button>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>