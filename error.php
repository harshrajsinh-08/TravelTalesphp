<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error - TravelTales</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    body { font-family: "Poppins", sans-serif; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

<div class="text-center max-w-md mx-auto p-8">
  <?php
  $error_type = $_GET['type'] ?? '404';
  
  switch($error_type) {
    case '500':
      $title = "Server Error";
      $message = "Something went wrong on our end. Please try again later.";
      $icon = "⚠️";
      break;
    case 'database':
      $title = "Database Error";
      $message = "We're having trouble connecting to our database. Please try again later.";
      $icon = "🔧";
      break;
    case '403':
      $title = "Access Denied";
      $message = "You don't have permission to access this resource.";
      $icon = "🚫";
      break;
    default:
      $title = "Page Not Found";
      $message = "The page you're looking for doesn't exist.";
      $icon = "🔍";
  }
  ?>
  
  <div class="text-6xl mb-6"><?= $icon ?></div>
  <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= $title ?></h1>
  <p class="text-gray-600 mb-8"><?= $message ?></p>
  
  <div class="space-y-4">
    <a href="index.php" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg transition">
      Go Home
    </a>
    <br>
    <button onclick="history.back()" class="text-gray-500 hover:text-gray-700 underline">
      Go Back
    </button>
  </div>
</div>

</body>
</html>