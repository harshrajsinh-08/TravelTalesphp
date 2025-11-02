<!-- Footer -->
<footer class="bg-gray-800 text-white py-12 mt-16">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <h3 class="text-xl font-bold mb-4">TravelTales</h3>
        <p class="text-gray-400">Share your journey, inspire others.</p>
      </div>
      <div>
        <h4 class="font-bold mb-4">Quick Links</h4>
        <ul class="space-y-2">
          <li><a href="about.php" class="text-gray-400 hover:text-white">About Us</a></li>
          <li><a href="contact.php" class="text-gray-400 hover:text-white">Contact</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4">Follow Us</h4>
        <div class="flex space-x-4">
          <a href="#" class="text-2xl hover:text-orange-500"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-2xl hover:text-orange-500"><i class="bi bi-twitter"></i></a>
          <a href="#" class="text-2xl hover:text-orange-500"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
      <div>
        <h4 class="font-bold mb-4">Newsletter</h4>
        <form action="newsletter-subscribe.php" method="POST" class="flex flex-col space-y-2">
          <input 
            type="email" 
            name="email" 
            placeholder="Your email" 
            class="px-4 py-2 rounded-lg text-gray-800 focus:ring-2 focus:ring-orange-500 focus:outline-none"
            required
          />
          <button 
            type="submit" 
            class="bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg transition"
          >
            Subscribe
          </button>
        </form>
      </div>
    </div>
    <div class="text-center mt-8 pt-8 border-t border-gray-700">
      <p class="text-gray-400">© <?= date('Y') ?> TravelTales. All rights reserved.</p>
    </div>
  </div>
</footer>

<!-- Scripts -->
<script src="public/js/navbar.js"></script>
<?php if (isset($additional_scripts)): ?>
  <?php foreach ($additional_scripts as $script): ?>
    <script src="<?= $script ?>"></script>
  <?php endforeach; ?>
<?php endif; ?>

</body>
</html>