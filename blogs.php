<?php
session_start();
require 'config/db.php';

$page_title = "Travel Blogs - TravelTales";

// Saare blogs ko database se fetch karte hain - latest pehle
$query = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = $conn->query($query);

$blogs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

$userEmail = isset($_SESSION['user']) ? $_SESSION['user'] : null;

include 'includes/header.php';
include 'includes/navbar.php';
?>



<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Blogs Section -->
<main class="pt-32 container mx-auto px-4 lg:px-20">
  <h1 class="text-4xl font-bold text-gray-900 mb-6 text-center">🌍 Travel Blogs</h1>

  <!-- Success/Error Messages -->
  <?php if (isset($_GET['success'])): ?>
    <div class="bg-green-100 text-green-700 p-4 mb-6 rounded-lg text-center max-w-2xl mx-auto">
      <?php if ($_GET['success'] === 'blog_deleted'): ?>
        Blog deleted successfully!
      <?php elseif ($_GET['success'] === 'posted'): ?>
        Blog posted successfully!
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if (isset($_GET['error'])): ?>
    <div class="bg-red-100 text-red-700 p-4 mb-6 rounded-lg text-center max-w-2xl mx-auto">
      <?php if ($_GET['error'] === 'not_authorized'): ?>
        ❌ You can only delete your own blogs.
      <?php elseif ($_GET['error'] === 'blog_not_found'): ?>
        ❌ Blog not found.
      <?php else: ?>
        ❌ An error occurred.
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <!-- Add Blog Button for Logged-in Users -->
  <?php if ($userEmail): ?>
    <div class="text-center mb-10">
      <a href="add-blog.php" 
         class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md">
        ➕ Add New Blog
      </a>
      <a href="index.php" class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition">
        ← Back to Home
      </a>
    </div>
  <?php endif; ?>

  <!-- Blog Grid -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

    <?php if ($blogs): ?>
      <?php foreach ($blogs as $blog): ?>
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
          <?php if ($blog['image']): ?>
            <img src="<?= htmlspecialchars($blog['image']) ?>" 
                 alt="<?= htmlspecialchars($blog['title']) ?>" 
                 class="h-48 w-full object-cover"/>
          <?php endif; ?>
          <div class="p-6">
            <h3 class="font-bold text-xl mb-2"><?= htmlspecialchars($blog['title']) ?></h3>
            <p class="text-gray-600 text-sm mb-4">
              By <?= htmlspecialchars($blog['author']) ?> • <?= date('F j, Y', strtotime($blog['created_at'])) ?>
            </p>
            <p class="text-gray-600 mb-4 line-clamp-3">
              <?= htmlspecialchars(string: substr($blog['content'], 0, 120)) ?>...
            </p>
            <div class="flex justify-between items-center">
              <a href="view-blog.php?id=<?= $blog['id'] ?>" 
                 class="text-orange-500 font-semibold hover:underline">
                Read More →
              </a>
              
              <?php if ($userEmail && $blog['author'] === $userEmail): ?>
                <div class="flex gap-2">
                  <a href="edit-blog.php?id=<?= $blog['id'] ?>" 
                     class="text-blue-500 hover:text-blue-700 text-sm">
                    <i class="bi bi-pencil"></i> Edit
                  </a>
                  <form method="POST" action="delete-blog.php" class="inline" 
                        onsubmit="return confirm('Are you sure you want to delete this blog? This action cannot be undone.')">
                    <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </form>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-gray-600 text-center col-span-3">No blogs available yet.</p>
    <?php endif; ?>

  </div>
</main>

<?php include 'includes/footer.php'; ?>