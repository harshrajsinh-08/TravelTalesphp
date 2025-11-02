<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: templates/login.html");
  exit();
}
$userEmail = $_SESSION['user'];
?>
<?php
$page_title = "Travel Story - TravelTales";
include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Story Content -->
<main class="pt-32 container mx-auto px-4 lg:px-20">
  <article id="story-article" class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <!-- Story Image -->
    <img id="story-image" class="w-full h-80 object-cover"/>

    <div class="p-8 lg:p-12">
      <!-- Back Button -->
      <button onclick="window.history.back()" 
              class="inline-flex items-center text-orange-500 hover:text-orange-600 font-semibold mb-6">
        ← Back
      </button>

      <!-- Title & Date -->
      <h1 id="story-title" class="text-4xl font-bold text-gray-900 mb-4"></h1>
      <p class="text-gray-500 text-sm mb-8">Published on <span id="story-date"></span></p>

      <!-- Story Content -->
      <div id="story-content" class="prose max-w-none text-gray-700 text-lg leading-relaxed"></div>

      <!-- Travel Tips Section -->
      <div class="mt-10 p-6 bg-gray-50 rounded-xl">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Travel Tips</h2>
        <ul id="travel-tips" class="list-disc ml-6 text-gray-700 space-y-2"></ul>
      </div>
    </div>
  </article>
</main>

<?php include 'includes/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const params = new URLSearchParams(window.location.search);
      const storyId = params.get('id');

      if (!storyId) {
        document.getElementById('story-title').textContent = 'Story Not Found';
        document.getElementById('story-content').innerHTML = '<p>No story ID provided.</p>';
        document.getElementById('story-image').style.display = 'none';
        return;
      }

      // Show loading state
      document.getElementById('story-title').textContent = 'Loading...';
      document.getElementById('story-content').innerHTML = '<p>Loading story content...</p>';

      fetch('data/stories.json')
        .then(res => {
          if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
          }
          return res.json();
        })
        .then(data => {
          const story = data.find(s => s.id == storyId);
          
          if (!story) {
            document.getElementById('story-title').textContent = 'Story Not Found';
            document.getElementById('story-content').innerHTML = '<p>The requested story could not be found.</p>';
            document.getElementById('story-image').style.display = 'none';
            return;
          }

          // Populate story content
          document.getElementById('story-title').textContent = story.title;
          document.getElementById('story-image').src = story.image;
          document.getElementById('story-image').alt = story.title;
          document.getElementById('story-image').style.display = 'block';
          
          // Format date
          const date = new Date(story.date);
          document.getElementById('story-date').textContent = date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
          });
          
          document.getElementById('story-content').innerHTML = story.content;

          // Add travel tips
          const tipsList = document.getElementById('travel-tips');
          tipsList.innerHTML = ''; // Clear existing content
          
          if (story.tips && story.tips.length > 0) {
            story.tips.forEach(tip => {
              const li = document.createElement('li');
              li.textContent = tip;
              tipsList.appendChild(li);
            });
          } else {
            tipsList.innerHTML = '<li>No specific tips available for this story.</li>';
          }
        })
        .catch(error => {
          console.error('Error loading story:', error);
          document.getElementById('story-title').textContent = 'Error Loading Story';
          document.getElementById('story-content').innerHTML = `<p>Unable to load the story at the moment. Error: ${error.message}</p>`;
          document.getElementById('story-image').style.display = 'none';
        });
    });
  </script>