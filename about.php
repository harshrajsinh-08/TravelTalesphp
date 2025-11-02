<?php
session_start();
require 'config/db.php';

$page_title = "About - TravelTales";
$userEmail = $_SESSION['user'] ?? null;

include 'includes/header.php';
include 'includes/navbar.php';
?>



<!-- About Section -->
<section class="container mx-auto px-4 py-32">
  <h1 class="text-4xl font-bold mb-6 text-center">About TravelTales</h1>
  <p class="text-lg text-gray-600 mb-12 max-w-3xl mx-auto text-center">
    TravelTales is a community-driven platform where travelers share their unique experiences, 
    discover hidden gems across India, and inspire others to explore new destinations. 
    Our mission is to bring authentic travel stories to life and connect passionate explorers.
  </p>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-5xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl p-6 text-center">
      <img src="https://images.unsplash.com/photo-1584599255392-3008fb46405f?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTZ8fHBob3RvcyUyMGZvciUyMGZvdW5kZXJzJTIwb2YlMjBjb21wYW55fGVufDB8fDB8fHww" 
           alt="Founder 1" class="h-32 w-32 rounded-full mx-auto mb-4 object-cover border-4 border-orange-500"/>
      <h3 class="text-xl font-bold mb-2">Harshrajsinh Zala</h3>
      <p class="text-gray-600">Founder & Lead Developer</p>
      <p class="mt-3 text-gray-500 text-sm">
        Harshrajsinh is passionate about building travel communities 
        and creating seamless platforms for explorers to share their journeys.
      </p>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6 text-center">
      <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400" 
           alt="Founder 2" class="h-32 w-32 rounded-full mx-auto mb-4 object-cover border-4 border-orange-500"/>
      <h3 class="text-xl font-bold mb-2">Co-Founder</h3>
      <p class="text-gray-600">Community & Content Head</p>
      <p class="mt-3 text-gray-500 text-sm">
        The co-founder focuses on engaging travelers, curating authentic content, 
        and growing the TravelTales community across India.
      </p>
    </div>
  </div>

  <div class="text-center mt-16">
    <a href="index.php" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition">
      ← Back to Home
    </a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>