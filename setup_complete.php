<?php
/**
 * Complete TravelTales Database Setup
 * Creates schema and populates with Indian travel data
 */

require 'config/config.php';

// Create database connection without selecting database first
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    header("Location: setup_manual.php?error=connection");
    exit();
}

echo "<!DOCTYPE html><html><head><title>TravelTales Complete Setup</title></head><body>";
echo "<h2>🚀 TravelTales Complete Database Setup</h2>\n";

try {
    // Step 1: Create database
    echo "<p>📁 Creating database...</p>";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);
    echo "<p>✅ Database created/selected</p>";
    
    // Step 2: Create tables
    echo "<p>🏗️ Creating tables...</p>";
    
    // Drop existing tables if they exist (to ensure clean setup)
    echo "<p>🗑️ Dropping existing tables (if any)...</p>";
    $pdo->exec("DROP TABLE IF EXISTS trips");
    $pdo->exec("DROP TABLE IF EXISTS messages");
    $pdo->exec("DROP TABLE IF EXISTS blogs");
    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("DROP TABLE IF EXISTS attractions");
    $pdo->exec("DROP TABLE IF EXISTS city_info");
    
    // Users table
    echo "<p>👤 Creating users table...</p>";
    $pdo->exec("CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        bio TEXT,
        profile_pic VARCHAR(500) DEFAULT 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=1024&auto=format&fit=crop',
        badges TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Blogs table
    echo "<p>📝 Creating blogs table...</p>";
    $pdo->exec("CREATE TABLE blogs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(500) NOT NULL,
        content TEXT NOT NULL,
        author VARCHAR(255) NOT NULL,
        image VARCHAR(500),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Attractions table
    echo "<p>🏛️ Creating attractions table...</p>";
    $pdo->exec("CREATE TABLE attractions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        city VARCHAR(255) NOT NULL,
        name VARCHAR(500) NOT NULL,
        price_range VARCHAR(100),
        city_image VARCHAR(500)
    )");
    
    // City info table
    echo "<p>🗺️ Creating city_info table...</p>";
    $pdo->exec("CREATE TABLE city_info (
        id INT AUTO_INCREMENT PRIMARY KEY,
        city VARCHAR(255) UNIQUE NOT NULL,
        how_to_reach TEXT,
        nearest_station VARCHAR(255),
        nearest_airport VARCHAR(255)
    )");
    
    // Trips table
    echo "<p>🎒 Creating trips table...</p>";
    $pdo->exec("CREATE TABLE trips (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_email VARCHAR(255) NOT NULL,
        destination VARCHAR(255) NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Messages table
    echo "<p>💬 Creating messages table...</p>";
    $pdo->exec("CREATE TABLE messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    echo "<p>✅ All tables created successfully</p>";
    
    // Verify table structure
    echo "<p>🔍 Verifying users table structure...</p>";
    $result = $pdo->query("DESCRIBE users");
    $columns = $result->fetchAll();
    echo "<p style='font-size: 12px; color: #666;'>Users table columns: ";
    foreach ($columns as $column) {
        echo $column['Field'] . " (" . $column['Type'] . "), ";
    }
    echo "</p>";
    
    // Step 3: Insert sample users
    echo "<p>👥 Adding sample users...</p>";
    $users = [
        ['Arjun Sharma', 'arjun.sharma@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Adventure seeker exploring the Himalayas and hidden gems of North India. Love trekking and photography.', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400', 'Mountain Explorer,Photographer,Trekker'],
        ['Priya Patel', 'priya.patel@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Food blogger and cultural enthusiast from Gujarat. Passionate about discovering authentic Indian cuisines and festivals.', 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=400', 'Foodie,Cultural Explorer,Festival Lover'],
        ['Rajesh Kumar', 'rajesh.kumar@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Heritage enthusiast documenting historical monuments across India. Special interest in Mughal and Rajput architecture.', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400', 'Heritage Explorer,History Buff,Architecture Lover'],
        ['Meera Nair', 'meera.nair@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Backwater explorer from Kerala. Love sharing stories about South Indian culture, temples, and natural beauty.', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400', 'Backwater Explorer,Temple Hopper,Nature Lover'],
        ['Vikram Singh', 'vikram.singh@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Desert safari guide from Rajasthan. Expert in camel treks and desert camping experiences.', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400', 'Desert Guide,Camel Trekker,Stargazer']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (name, email, password, bio, profile_pic, badges) VALUES (?, ?, ?, ?, ?, ?)");
    $userCount = 0;
    foreach ($users as $user) {
        if ($stmt->execute($user)) {
            $userCount++;
        }
    }
    echo "<p>✅ Added $userCount users</p>";
    
    // Step 4: Add sample blogs
    echo "<p>📝 Adding travel blogs...</p>";
    $blogs = [
        [
            'Incredible Journey Through Golden Triangle',
            'The Golden Triangle of India - Delhi, Agra, and Jaipur - offers an unforgettable introduction to India\'s rich history and culture. Starting from the bustling streets of Delhi with its perfect blend of old and new, I was mesmerized by the Red Fort and India Gate.

The highlight was definitely the Taj Mahal in Agra. No photograph can capture the ethereal beauty of this marble masterpiece at sunrise. The intricate inlay work and the changing colors throughout the day left me speechless.

Jaipur, the Pink City, welcomed me with its royal palaces and vibrant bazaars. The Hawa Mahal and Amber Fort are architectural marvels that showcase Rajput grandeur. Don\'t miss the local Rajasthani thali - it\'s a feast for your taste buds!

**Essential Tips for Golden Triangle:**
• Book Taj Mahal tickets online in advance
• Hire certified guides for historical context  
• Try authentic local cuisines in each city
• Bargain respectfully in local markets
• Carry cash for small vendors and tips
• Best time to visit: October to March

This 7-day journey gave me a perfect glimpse into India\'s incredible heritage. Each city has its own character and charm that will leave you planning your next Indian adventure!',
            'arjun.sharma@email.com',
            'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900'
        ],
        [
            'Backwaters of Kerala: A Serene Escape',
            'Kerala\'s backwaters are truly God\'s Own Country. My 3-day houseboat journey through Alleppey and Kumarakom was nothing short of magical. Floating through narrow canals lined with coconut palms, watching local life unfold along the banks - it\'s pure tranquility.

The houseboat experience is unique to Kerala. Our traditional kettuvallam had all modern amenities while maintaining its rustic charm. The crew prepared authentic Kerala meals - fish curry, appam, and coconut-based dishes that were absolutely delicious.

**Backwater Highlights:**
• Sunrise over Vembanad Lake
• Village walks through spice gardens
• Ayurvedic massage at local centers
• Bird watching at Kumarakom Bird Sanctuary
• Sunset cruise through narrow canals
• Traditional Kerala cuisine on board

The best time to visit is October to March when the weather is pleasant. Book houseboats in advance, especially during peak season. Don\'t forget to try the local toddy (palm wine) and fresh seafood.

Kerala\'s backwaters offer a perfect digital detox. The slow pace of life, gentle lapping of water, and lush greenery create an atmosphere of complete relaxation. It\'s a must-visit destination for anyone seeking peace and natural beauty.',
            'meera.nair@email.com',
            'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'
        ],
        [
            'Rajasthan Desert Safari: Jaisalmer Experience',
            'Jaisalmer, the Golden City, offers one of India\'s most authentic desert experiences. My 2-day desert safari in the Thar Desert was filled with adventure, culture, and unforgettable memories.

The camel safari began at sunset from Sam Sand Dunes. Riding through golden sand dunes as the sun painted the sky in brilliant oranges and reds was magical. Our camel guide shared fascinating stories about desert life and navigation techniques used by ancient traders.

**Desert Safari Highlights:**
• Camel ride through golden sand dunes
• Spectacular sunset and sunrise views
• Traditional Rajasthani dinner under stars
• Folk music and dance performances
• Stargazing in clear desert skies
• Visit to authentic desert villages

The overnight desert camp was incredible. Traditional Rajasthani folk music and dance performances around the bonfire created an authentic cultural experience. The clear desert sky offered spectacular stargazing opportunities - the Milky Way was clearly visible.

Jaisalmer Fort, a living fort with people still residing inside, is another must-visit. The intricate stone carvings and havelis showcase exquisite Rajasthani architecture.

Best time to visit is October to March when temperatures are pleasant. This desert adventure gave me a deep appreciation for Rajasthani culture and the resilience of desert communities.',
            'vikram.singh@email.com',
            'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'
        ],
        [
            'Spiritual Journey: Varanasi and Rishikesh',
            'My spiritual journey through India\'s holiest cities - Varanasi and Rishikesh - was transformative. These ancient cities offer profound spiritual experiences that touch your soul.

Varanasi, one of the world\'s oldest continuously inhabited cities, pulsates with spiritual energy. The evening Ganga Aarti at Dashashwamedh Ghat is mesmerizing. Thousands of devotees gather as priests perform elaborate rituals with fire, creating a divine atmosphere.

**Spiritual Highlights:**
• Ganga Aarti ceremony in Varanasi
• Sunrise boat ride on the Ganges
• Meditation sessions in Rishikesh ashrams
• Visit to Beatles Ashram
• River rafting on the Ganges
• Satsang (spiritual gatherings) with gurus

Rishikesh, the Yoga Capital of the World, offers a different spiritual dimension. Nestled in the Himalayan foothills along the Ganges, it\'s perfect for meditation and self-reflection. I attended yoga sessions at various ashrams and found inner peace.

This journey taught me that spirituality isn\'t about rituals but about connecting with your inner self. India\'s ancient wisdom and spiritual traditions offer guidance for modern life\'s challenges.',
            'rajesh.kumar@email.com',
            'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900'
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO blogs (title, content, author, image, created_at) VALUES (?, ?, ?, ?, NOW())");
    $blogCount = 0;
    foreach ($blogs as $blog) {
        if ($stmt->execute($blog)) {
            $blogCount++;
        }
    }
    echo "<p>✅ Added $blogCount blogs</p>";
    
    // Step 5: Add attractions
    echo "<p>🏛️ Adding attractions...</p>";
    $attractions = [
        // Delhi
        ['Delhi', 'Red Fort (Lal Qila)', '₹35 - ₹500', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'],
        ['Delhi', 'India Gate', 'Free', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'],
        ['Delhi', 'Qutub Minar', '₹30 - ₹500', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'],
        ['Delhi', 'Lotus Temple', 'Free', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'],
        ['Delhi', 'Humayun\'s Tomb', '₹40 - ₹600', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'],
        
        // Mumbai
        ['Mumbai', 'Gateway of India', 'Free', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'],
        ['Mumbai', 'Marine Drive', 'Free', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'],
        ['Mumbai', 'Elephanta Caves', '₹40 - ₹600', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'],
        ['Mumbai', 'Chhatrapati Shivaji Terminus', 'Free', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'],
        
        // Jaipur
        ['Jaipur', 'Hawa Mahal', '₹50 - ₹200', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'],
        ['Jaipur', 'Amber Fort', '₹100 - ₹500', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'],
        ['Jaipur', 'City Palace', '₹130 - ₹700', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'],
        ['Jaipur', 'Jantar Mantar', '₹50 - ₹200', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'],
        
        // Goa
        ['Goa', 'Baga Beach', 'Free', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'],
        ['Goa', 'Basilica of Bom Jesus', '₹5', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'],
        ['Goa', 'Dudhsagar Falls', '₹30 - ₹1000', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'],
        ['Goa', 'Fort Aguada', 'Free', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'],
        
        // Agra
        ['Agra', 'Taj Mahal', '₹50 - ₹1300', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900'],
        ['Agra', 'Agra Fort', '₹40 - ₹650', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900'],
        ['Agra', 'Mehtab Bagh', '₹25 - ₹300', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900'],
        
        // Kerala
        ['Kochi', 'Chinese Fishing Nets', 'Free', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'],
        ['Kochi', 'Mattancherry Palace', '₹5', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'],
        ['Alleppey', 'Backwater Houseboat', '₹3000 - ₹15000', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'],
        ['Alleppey', 'Alappuzha Beach', 'Free', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'],
        ['Munnar', 'Tea Gardens', '₹50 - ₹200', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'],
        
        // Rajasthan
        ['Udaipur', 'City Palace', '₹300 - ₹700', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'],
        ['Udaipur', 'Lake Pichola', '₹400 - ₹1000', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'],
        ['Jaisalmer', 'Jaisalmer Fort', '₹30 - ₹250', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'],
        ['Jaisalmer', 'Sam Sand Dunes', '₹500 - ₹3000', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'],
        ['Jodhpur', 'Mehrangarh Fort', '₹60 - ₹600', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'],
        
        // Varanasi
        ['Varanasi', 'Kashi Vishwanath Temple', 'Free', 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900'],
        ['Varanasi', 'Ganga Aarti', 'Free', 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900'],
        ['Varanasi', 'Sarnath', '₹25 - ₹300', 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO attractions (city, name, price_range, city_image) VALUES (?, ?, ?, ?)");
    $attractionCount = 0;
    foreach ($attractions as $attraction) {
        if ($stmt->execute($attraction)) {
            $attractionCount++;
        }
    }
    echo "<p>✅ Added $attractionCount attractions</p>";
    
    // Step 6: Add city info
    echo "<p>🗺️ Adding city information...</p>";
    $cities = [
        ['Delhi', 'Well connected by air, rail, and road from all major cities. Metro connectivity within the city.', 'New Delhi Railway Station', 'Indira Gandhi International Airport'],
        ['Mumbai', 'Major hub with excellent connectivity by air, rail, and road. Local trains connect the entire city.', 'Chhatrapati Shivaji Terminus', 'Chhatrapati Shivaji International Airport'],
        ['Jaipur', 'Connected by air, rail, and road. Regular flights and trains from Delhi and Mumbai.', 'Jaipur Junction', 'Jaipur International Airport'],
        ['Goa', 'Accessible by air, rail, and road. Regular flights from major cities.', 'Madgaon Railway Station', 'Goa International Airport'],
        ['Agra', 'Well connected by rail and road. Gatimaan Express from Delhi.', 'Agra Cantt Railway Station', 'Agra Airport (limited flights)'],
        ['Kochi', 'Major port city with air, rail, road, and sea connectivity.', 'Ernakulam Junction', 'Cochin International Airport'],
        ['Alleppey', 'Connected by road and rail from Kochi. Famous for backwater houseboats.', 'Alappuzha Railway Station', 'Cochin International Airport (85 km)'],
        ['Munnar', 'Accessible by road from Kochi and Madurai. Scenic drive through Western Ghats.', 'Aluva Railway Station (110 km)', 'Cochin International Airport (110 km)'],
        ['Udaipur', 'Connected by air, rail, and road. Palace on Wheels luxury train available.', 'Udaipur City Railway Station', 'Maharana Pratap Airport'],
        ['Jaisalmer', 'Connected by rail and road. Desert triangle circuit with Jodhpur and Bikaner.', 'Jaisalmer Railway Station', 'Jodhpur Airport (285 km)'],
        ['Jodhpur', 'Well connected by air, rail, and road. Gateway to Thar Desert region.', 'Jodhpur Junction', 'Jodhpur Airport'],
        ['Varanasi', 'Ancient city connected by air, rail, and road. Spiritual capital of India.', 'Varanasi Junction', 'Lal Bahadur Shastri Airport']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO city_info (city, how_to_reach, nearest_station, nearest_airport) VALUES (?, ?, ?, ?)");
    $cityCount = 0;
    foreach ($cities as $city) {
        if ($stmt->execute($city)) {
            $cityCount++;
        }
    }
    echo "<p>✅ Added $cityCount cities</p>";
    
    // Step 7: Add sample trips
    echo "<p>🎒 Adding sample trips...</p>";
    $trips = [
        ['arjun.sharma@email.com', 'Ladakh', '2024-06-15', '2024-06-25', 'High altitude adventure - Leh, Nubra Valley, Pangong Lake. Need to acclimatize properly and carry warm clothes.'],
        ['priya.patel@email.com', 'Hampi', '2024-04-10', '2024-04-15', 'Exploring Vijayanagara Empire ruins. Planning to stay in heritage hotels and try local Karnataka cuisine.'],
        ['meera.nair@email.com', 'Munnar', '2024-05-20', '2024-05-25', 'Tea plantation tour and hill station retreat. Perfect for summer escape from Kerala heat.'],
        ['rajesh.kumar@email.com', 'Khajuraho', '2024-03-25', '2024-03-28', 'UNESCO World Heritage site visit. Studying temple architecture and sculptures of Chandela dynasty.'],
        ['vikram.singh@email.com', 'Rann of Kutch', '2024-12-15', '2024-12-20', 'Rann Utsav festival experience. White desert, cultural performances, and full moon night camping.']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO trips (user_email, destination, start_date, end_date, notes, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $tripCount = 0;
    foreach ($trips as $trip) {
        if ($stmt->execute($trip)) {
            $tripCount++;
        }
    }
    echo "<p>✅ Added $tripCount trips</p>";
    
    // Final summary
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalBlogs = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
    $totalTrips = $pdo->query("SELECT COUNT(*) FROM trips")->fetchColumn();
    $totalAttractions = $pdo->query("SELECT COUNT(*) FROM attractions")->fetchColumn();
    $totalCities = $pdo->query("SELECT COUNT(*) FROM city_info")->fetchColumn();
    
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 5px solid #28a745;'>";
    echo "<h3 style='color: #155724; margin: 0 0 10px 0;'>🎉 Database Setup Complete!</h3>";
    echo "<p style='color: #155724; margin: 0;'>Your TravelTales database is now fully populated with authentic Indian travel content!</p>";
    echo "</div>";
    
    echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0; border: 1px solid #dee2e6;'>";
    echo "<h3 style='margin: 0 0 15px 0;'>📊 Database Summary</h3>";
    echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;'>";
    echo "<div style='background: #e3f2fd; padding: 15px; border-radius: 8px; text-align: center;'>";
    echo "<div style='font-size: 24px; font-weight: bold; color: #1976d2;'>$totalUsers</div>";
    echo "<div style='color: #1976d2; font-weight: 500;'>Sample Travelers</div>";
    echo "</div>";
    echo "<div style='background: #f3e5f5; padding: 15px; border-radius: 8px; text-align: center;'>";
    echo "<div style='font-size: 24px; font-weight: bold; color: #7b1fa2;'>$totalBlogs</div>";
    echo "<div style='color: #7b1fa2; font-weight: 500;'>Travel Stories</div>";
    echo "</div>";
    echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 8px; text-align: center;'>";
    echo "<div style='font-size: 24px; font-weight: bold; color: #388e3c;'>$totalAttractions</div>";
    echo "<div style='color: #388e3c; font-weight: 500;'>Indian Attractions</div>";
    echo "</div>";
    echo "<div style='background: #fff3e0; padding: 15px; border-radius: 8px; text-align: center;'>";
    echo "<div style='font-size: 24px; font-weight: bold; color: #f57c00;'>$totalCities</div>";
    echo "<div style='color: #f57c00; font-weight: 500;'>Cities Covered</div>";
    echo "</div>";
    echo "<div style='background: #fce4ec; padding: 15px; border-radius: 8px; text-align: center;'>";
    echo "<div style='font-size: 24px; font-weight: bold; color: #c2185b;'>$totalTrips</div>";
    echo "<div style='color: #c2185b; font-weight: 500;'>Planned Trips</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
    echo "<div style='background: #cce5ff; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 5px solid #007bff;'>";
    echo "<h3 style='color: #004085; margin: 0 0 15px 0;'>🔐 Ready to Explore!</h3>";
    echo "<p style='color: #004085; margin: 0 0 10px 0;'><strong>Login with any sample account:</strong></p>";
    echo "<div style='background: rgba(255,255,255,0.7); padding: 15px; border-radius: 8px; font-family: monospace;'>";
    echo "<div><strong>Email:</strong> arjun.sharma@email.com</div>";
    echo "<div><strong>Password:</strong> password</div>";
    echo "</div>";
    echo "<p style='color: #004085; margin: 15px 0 0 0; font-size: 14px;'><em>All sample users use 'password' as their password for testing.</em></p>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='index.php' style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; box-shadow: 0 4px 15px rgba(0,0,0,0.2);'>🏠 Explore TravelTales</a>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 5px solid #dc3545;'>";
    echo "<h3 style='color: #721c24; margin: 0 0 10px 0;'>❌ Setup Error</h3>";
    echo "<p style='color: #721c24; margin: 0;'>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}

echo "</body></html>";
?>