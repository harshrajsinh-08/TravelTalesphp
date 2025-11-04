<?php
session_start();
require 'config/db.php';

$page_title = "Contact Us - TravelTales";
$userEmail = $_SESSION['user'] ?? null;

// Contact form ka submission handle karte hain
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $message = $conn->real_escape_string($message);
        
        $query = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";
        if ($conn->query($query)) {
            $success = "Thank you for reaching out! We'll get back to you soon.";
        } else {
            $error = "There was an error sending your message. Please try again.";
        }
    } else {
        $error = "Please fill out all fields.";
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>



<!-- Contact Section -->
<section class="container mx-auto px-4 py-32">
  <h2 class="text-4xl font-bold mb-8 text-center">Contact Us</h2>
  <p class="text-center text-gray-600 max-w-2xl mx-auto mb-12">
    Have a question, feedback, or a story to share? We'd love to hear from you! Fill out the form below or email us directly.
  </p>

  <?php if ($success): ?>
    <p class="bg-green-100 text-green-700 p-4 mb-6 text-center rounded-lg"><?= $success ?></p>
  <?php elseif ($error): ?>
    <p class="bg-red-100 text-red-700 p-4 mb-6 text-center rounded-lg"><?= $error ?></p>
  <?php endif; ?>

  <form action="" method="POST" class="bg-white rounded-xl shadow-md p-6 max-w-2xl mx-auto space-y-6">
    <div>
      <label class="block font-semibold mb-2">Name</label>
      <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg" required>
    </div>

    <div>
      <label class="block font-semibold mb-2">Email</label>
      <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg" required>
    </div>

    <div>
      <label class="block font-semibold mb-2">Message</label>
      <textarea name="message" rows="4" class="w-full px-4 py-2 border rounded-lg" required></textarea>
    </div>

    <div class="text-center">
      <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg transition">
        Send Message
      </button>
    </div>
  </form>

  <div class="text-center mt-12">
    <p class="text-gray-600">Or email us directly at <span class="text-orange-500 font-semibold">support@traveltales.com</span></p>
  </div>

  <!-- Back to Home Button -->
  <div class="text-center mt-8">
    <a href="index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition">
      ← Back to Home
    </a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>