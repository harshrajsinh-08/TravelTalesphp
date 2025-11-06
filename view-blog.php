<?php
session_start();
require 'config/db.php';

// URL se blog ID fetch karte hain
$blogId = $_GET['id'] ?? null;
if (!$blogId) {
    header("Location: blogs.php");
    exit();
}

$blogId = $conn->real_escape_string($blogId);
$query = "SELECT * FROM blogs WHERE id = '$blogId'";
$result = $conn->query($query);
$blog = $result ? $result->fetch_assoc() : null;

if (!$blog) {
    header("Location: blogs.php");
    exit();
}

// Set page title for header include
$page_title = htmlspecialchars($blog['title']) . ' - TravelTales';

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Blog Content -->
<main class="pt-32 container mx-auto px-4 lg:px-20">
  <article class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <?php if ($blog['image']): ?>
      <img src="<?= htmlspecialchars($blog['image']) ?>" alt="<?= htmlspecialchars($blog['title']) ?>" class="w-full h-80 object-cover"/>
    <?php endif; ?>
    <div class="p-8 lg:p-12">
      <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($blog['title']) ?></h1>
      <p class="text-gray-500 text-sm mb-8">
        Published on <?= date('F j, Y', strtotime(datetime: $blog['created_at'])) ?> 
        by <span class="font-semibold text-gray-700"><?= htmlspecialchars($blog['author']) ?></span>
      </p>
      <div class="prose max-w-none text-gray-700 text-lg leading-relaxed">
        <?= nl2br(htmlspecialchars($blog['content'])) ?>
      </div>

      <!-- Success Message -->
      <?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
        <div class="bg-green-100 text-green-700 p-4 mt-6 rounded-lg">
          ✅ Blog updated successfully!
        </div>
      <?php endif; ?>

      <!-- Action Buttons -->
      <div class="mt-10 flex flex-wrap gap-4">
        <a href="javascript:history.back()" 
           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition">
           ← Back
        </a>
        
        <?php if ($userEmail && $blog['author'] === $userEmail): ?>
          <a href="edit-blog.php?id=<?= $blog['id'] ?>" 
             class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition">
             <i class="bi bi-pencil"></i> Edit Blog
          </a>
          
          <form method="POST" action="delete-blog.php" class="inline" 
                onsubmit="return confirm('Are you sure you want to delete this blog? This action cannot be undone.')">
            <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg transition">
              <i class="bi bi-trash"></i> Delete Blog
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </article>
</main>

<?php include 'includes/footer.php'; ?>