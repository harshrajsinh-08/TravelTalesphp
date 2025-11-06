<?php
session_start();
require 'config/db.php';

$page_title = "Explore India - TravelTales";
$userEmail = $_SESSION['user'] ?? null;

// Popular destinations fetch karte hain database se
$query = "SELECT DISTINCT city FROM attractions ORDER BY city LIMIT 12";
$result = $conn->query($query);
$destinations = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $destinations[] = $row;
    }
}
?>

<?php include 'includes/header.php'; ?>

<?php include 'includes/navbar.php'; ?>



<!-- Hero Section -->
<section class="relative pt-32 pb-16 text-white" style="background-image: url('https://images.unsplash.com/photo-1524492412937-b28074a5d7da'); background-size: cover; background-position: center; min-height: 60vh;">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="relative container mx-auto px-4 text-center">
    <h1 class="text-4xl md:text-6xl font-bold mb-6">Explore Incredible India</h1>
    <p class="text-xl mb-8 max-w-2xl mx-auto">Discover hidden gems, popular destinations, and authentic experiences across the diverse landscapes of India.</p>
  </div>
</section>

<!-- Destinations Grid -->
<section class="container mx-auto px-4 py-16">
  <h2 class="text-3xl font-bold mb-8 text-center">Popular Destinations</h2>
  <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php if ($destinations): ?>
      <?php 
      // City --> image mapping 
      $cityImages = [
        'Mumbai' => 'https://images.unsplash.com/photo-1595658658481-d53d3f999875?w=400&h=300&fit=crop',
        'Delhi' => 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=400&h=300&fit=crop',
        'Bangalore' => 'https://images.unsplash.com/photo-1596176530529-78163a4f7af2?w=400&h=300&fit=crop',
        'Chennai' => 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=400&h=300&fit=crop',
        'Kolkata' => 'https://images.unsplash.com/photo-1558431382-27e303142255?w=400&h=300&fit=crop',
        'Jaipur' => 'https://images.unsplash.com/photo-1477587458883-47145ed94245?w=400&h=300&fit=crop',
        'Goa' => 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=400&h=300&fit=crop',
        'Agra' => 'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=400&h=300&fit=crop',
        'Kochi' => 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=400&h=300&fit=crop',
        'Alleppey' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&h=300&fit=crop',
        'Munnar' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop',
        'Udaipur' => 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=400&h=300&fit=crop',
        'Jaisalmer' => 'https://plus.unsplash.com/premium_photo-1697730399235-bcca956cc6d7?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8amFpc2FsbWVyfGVufDB8fDB8fHww&auto=format&fit=crop&q=60&w=900',
        'Jodhpur' => 'https://images.unsplash.com/photo-1569096610945-1a094be04c74?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8am9kaHB1cnxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&q=60&w=900',
        'Shimla' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400&h=300&fit=crop',
        'Manali' => 'https://images.unsplash.com/photo-1605538883669-825200433431?w=400&h=300&fit=crop',
        'Dharamshala' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop',
        'Varanasi' => 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=400&h=300&fit=crop',
        'Lucknow' => 'https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=400&h=300&fit=crop',
        'Mysore' => 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=400&h=300&fit=crop',
        'Hampi' => 'https://images.unsplash.com/photo-1620766182966-c6eb5ed2b788?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aGFtcGl8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&q=60&w=900',
        'Madurai' => 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=400&h=300&fit=crop',
        'Ooty' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop',
        'Darjeeling' => 'https://images.unsplash.com/photo-1637737118663-f1a53ee1d5a7?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8ZGFyamVlbGluZ3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&q=60&w=900'
      ];
      
      // agar koi image nahi to default image
      $defaultImage = 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=400&h=300&fit=crop';
      ?>
      
      <?php foreach ($destinations as $destination): ?>
        <?php 
        $cityName = $destination['city'];
        $cityImage = $cityImages[$cityName] ?? $defaultImage;
        ?>
        <div class="bg-white rounded-xl shadow-md overflow-hidden cursor-pointer" 
             onclick="exploreDestination('<?= htmlspecialchars($cityName) ?>')">
          <div class="relative h-48 overflow-hidden">
            <img 
              src="<?= $cityImage ?>" 
              alt="<?= htmlspecialchars($cityName) ?>"
              class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
              <h3 class="text-white text-xl font-bold text-center px-4"><?= htmlspecialchars($cityName) ?></h3>
            </div>
          </div>
          <div class="p-4">
            <p class="text-gray-600 text-sm flex items-center gap-2">
              <i class="bi bi-geo-alt text-orange-500"></i>
              Click to explore attractions
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-gray-600 text-center col-span-full">No destinations available yet.</p>
    <?php endif; ?>
  </div>
</section>

<!-- Back to Home -->
<div class="text-center pb-16">
  <a href="index.php" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg">
    ← Back to Home
  </a>
</div>

<script>
function exploreDestination(city) {
  window.location.href = `index.php?destination=${encodeURIComponent(city)}#plan-trip`;
}
</script>

<?php include 'includes/footer.php'; ?>