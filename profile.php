<?php
session_start();
require 'config/db.php';

$page_title = "My Profile - TravelTales";

if (!isset($_SESSION['user'])) {
    header("Location: templates/login.html");
    exit();
}

$userEmail = $_SESSION['user'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$userEmail]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch user trips
$stmt = $pdo->prepare("SELECT * FROM trips WHERE user_email = ? ORDER BY start_date ASC");
$stmt->execute([$userEmail]);
$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<style>
.badge {
    background-color: #f97316;
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    display: inline-block;
}
</style>

<?php include 'includes/navbar.php'; ?>



    <!-- Profile Section -->
    <section id="profile-section" class="container mx-auto px-4 py-32">
        <h2 class="text-3xl font-bold mb-8">My Profile</h2>
        <div class="bg-white rounded-xl shadow-md p-6 flex flex-col md:flex-row gap-6">

            <!-- Profile Picture -->
            <div class="flex-shrink-0">
                <img src="<?= htmlspecialchars($user['profile_pic'] ?? 'https://via.placeholder.com/150') ?>"
                    alt="Profile Picture" class="h-32 w-32 rounded-full object-cover border-4 border-orange-500" />
            </div>

            <!-- Profile Details -->
            <div>
                <h3 class="text-2xl font-bold">
                    <?= htmlspecialchars($user['name'] ?? $userEmail) ?>
                </h3>
                <p class="text-gray-600">
                    <?= htmlspecialchars($user['bio'] ?? "Traveler exploring India!") ?>
                </p>

                <!-- Badges -->
                <div class="mt-4">
                    <?php
                    $badges = explode(',', $user['badges'] ?? 'Explorer,Photographer,Foodie');
                    foreach ($badges as $badge): ?>
                        <span class="badge"><?= htmlspecialchars(trim($badge)) ?></span>
                    <?php endforeach; ?>
                </div>

                <!-- Upcoming Trips -->
                <div class="mt-6">
                    <h4 class="text-xl font-bold mb-2">Upcoming Trips</h4>
                    <ul class="list-disc ml-6 text-gray-600">
                        <?php if ($trips && count($trips) > 0): ?>
                            <?php foreach ($trips as $trip): ?>
                                <li>
                                    <?= htmlspecialchars($trip['destination']) ?>
                                    (<?= date('F j, Y', strtotime($trip['start_date'])) ?>)
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No trips added yet.</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Edit Profile Button -->
                <div class="mt-6 flex gap-4">
                    <a href="index.php"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition">
                        ← Back to Home
                    </a>
                    <a href="edit-profile.php"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition">
                        ✏ Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>