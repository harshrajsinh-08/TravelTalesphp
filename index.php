<?php
session_start();
require 'config/db.php';

$page_title = "TravelTales - Discover India";
$additional_scripts = ['public/js/trip-planner.js'];

// Agar user login nahi hai toh login page pe bhej do
if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html");
    exit();
}

$userEmail = $_SESSION['user'];

// Latest 3 blogs fetch karte hain homepage ke liye
$query = "SELECT * FROM blogs ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($query);
$latestBlogs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $latestBlogs[] = $row;
    }
}

// Login kiye hue user ka profile data fetch karte hain
$userEmail = $conn->real_escape_string($userEmail);
$query = "SELECT * FROM users WHERE email = '$userEmail'";
$result = $conn->query($query);
$user = $result ? $result->fetch_assoc() : null;

$profilePic = $user['profile_pic'] ?? 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=1024&auto=format&fit=crop';
$userName = $user['name'] ?? 'Traveler';
$userBio = $user['bio'] ?? 'Passionate about discovering India.';
$userBadges = $user['badges'] ?? [];

if (is_string($userBadges)) {
    // Remove curly braces and split by comma
    $userBadges = array_map('trim', explode(',', trim($userBadges, '{}')));
}
?>

<?php include 'includes/header.php'; ?>

<style>
  .parallax-header { height: 70vh; background-image: url("https://images.unsplash.com/photo-1506197603052-3cc9c3a201bd"); background-size: cover; background-position: center; }
  #map { height: 400px; width: 100%; border-radius: 1rem; }

  .badge { background-color: #f97316; color: white; font-size: 12px; font-weight: bold; padding: 0.2rem 0.6rem; border-radius: 12px; display: inline-block; }
</style>

<?php include 'includes/navbar.php'; ?>

  <!-- Hero Section -->
  <header class="parallax-header relative flex items-center justify-center">
    <div class="absolute inset-0 bg-black/40"></div>
    <div class="relative text-center text-white px-4">
      <h1 class="text-4xl md:text-6xl font-bold mb-6">Discover Incredible India</h1>
      <div class="max-w-3xl mx-auto">
        <div class="flex flex-col md:flex-row gap-2 relative">
          <div class="flex-1 relative">
            <input type="text" id="searchInput" placeholder="Where do you want to go in India?" class="w-full px-6 py-3 rounded-full text-gray-800"/>
            <div id="searchResults" class="absolute left-0 right-0 mt-1 bg-white rounded-lg shadow-lg overflow-hidden hidden z-10"></div>
          </div>
          <button onclick="handleSearch()" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-full">
            Search
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Featured Travel Stories Section -->
  <section id="featured-stories" class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold mb-8">Featured Travel Stories</h2>
    <div id="stories-container" class="grid grid-cols-1 md:grid-cols-3 gap-8"></div>
  </section>

  <script>
  fetch('data/stories.json')
    .then(res => {
      if (!res.ok) {
        throw new Error('Failed to fetch stories');
      }
      return res.json();
    })
    .then(stories => {
      const container = document.getElementById('stories-container');
      container.innerHTML = ''; // Clear any existing content
      
      if (stories && stories.length > 0) {
        stories.forEach(story => {
          const card = document.createElement('div');
          card.className = "story-card bg-white rounded-xl shadow-md overflow-hidden transition";
          card.innerHTML = `
            <img src="${story.image}" alt="${story.title}" class="h-48 w-full object-cover"/>
            <div class="p-6">
              <h3 class="font-bold text-xl mb-2">${story.title}</h3>
              <p class="text-gray-600">${story.summary}</p>
              <a href="story.php?id=${story.id}" class="text-orange-500 font-semibold hover:underline mt-3 inline-block">Read More→</a>
            </div>
          `;
          container.appendChild(card);
        });
      } else {
        container.innerHTML = '<p class="text-gray-600 text-center col-span-3">No travel stories available yet.</p>';
      }
    })
    .catch(error => {
      console.error('Error loading travel stories:', error);
      const container = document.getElementById('stories-container');
      container.innerHTML = '<p class="text-gray-600 text-center col-span-3">Unable to load travel stories at the moment.</p>';
    });
  </script>

  <!-- Blog Section -->
  <section id="blog-section" class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold mb-8">Travel Blogs</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php if ($latestBlogs): ?>
          <?php foreach ($latestBlogs as $blog): ?>
            <div class="blog-card bg-white rounded-xl shadow-md overflow-hidden transition hover:shadow-lg">
              <?php if ($blog['image']): ?>
                <img src="<?= htmlspecialchars($blog['image']) ?>" 
                     alt="<?= htmlspecialchars($blog['title']) ?>" 
                     class="h-48 w-full object-cover"/>
              <?php endif; ?>
              <div class="p-6">
                <h3 class="font-bold text-xl mb-2"><?= htmlspecialchars($blog['title']) ?></h3>
                <p class="text-gray-600 text-sm mb-4">
                  By <?= htmlspecialchars($blog['author']) ?> • <?= date('j F, Y', strtotime($blog['created_at'])) ?>
                </p>
                <p class="text-gray-600 mb-4 line-clamp-3">
                  <?= htmlspecialchars(substr($blog['content'], 0, 100)) ?>...
                </p>
                <a href="view-blog.php?id=<?= $blog['id'] ?>" 
                   class="text-orange-500 font-semibold hover:underline mt-3 inline-block">
                   Read More →
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-gray-600 text-center col-span-3">No blogs yet. <a href="add-blog.php" class="text-orange-500 underline">Add one?</a></p>
        <?php endif; ?>
      </div>
      <div class="text-center mt-10">
        <a href="blogs.php" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg">
          View All Blogs →
        </a>
      </div>
    </div>
  </section>

  <!-- Dynamic Profile Section -->
  <section id="profile-section" class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold mb-8">My Profile</h2>
    <div class="bg-white rounded-xl shadow-md p-6 flex flex-col md:flex-row gap-6">
      <div class="flex-shrink-0">
        <img src="<?= htmlspecialchars($profilePic) ?>" 
             alt="Profile Picture" 
             class="h-32 w-32 rounded-full object-cover border-4 border-orange-500"/>
      </div>
      <div class="flex-1">
        <h3 class="text-2xl font-bold"><?= htmlspecialchars($userName) ?></h3>
        <p class="text-gray-600"><?= htmlspecialchars($userBio) ?></p>
        <div class="mt-4">
          <?php if (!empty($userBadges)): ?>
            <?php foreach ($userBadges as $badge): ?>
              <span class="badge"><?= htmlspecialchars($badge) ?></span>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        <div class="mt-4">
          <a href="profile.php" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition">
            View Full Profile →
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Plan Your Trip Section -->
  <section id="plan-trip" class="bg-gray-100 pt-12 pb-12">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold mb-6">Plan Your Next Trip</h2>
      <div class="flex flex-col md:flex-row gap-4 mb-6">
        <input type="text" id="destinationInput" placeholder="Enter a city in India"
               class="flex-1 px-6 py-3 rounded-full border border-gray-300 text-gray-800"/>
        <button onclick="fetchTripData()" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-full">
          Show Attractions
        </button>
      </div>
      <div id="map" class="h-80 rounded-lg shadow hidden mb-8"></div>
      <div id="location-card" class="hidden opacity-0 bg-white rounded-xl shadow-md overflow-hidden transition-all duration-500 mb-6"></div>
    </div>
  </section>

  
<script>
// Handle destination parameter from explore page
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const destination = urlParams.get('destination');
  
  if (destination) {
    document.getElementById('destinationInput').value = destination;
    fetchTripData(destination);
  }
});
</script>

<?php include 'includes/footer.php'; ?>