-- TravelTales Sample Data - Indian Travel Content
-- Run this after creating the database schema

USE traveltales;

-- Sample Users
INSERT INTO users (name, email, password, bio, profile_pic, badges) VALUES
('Arjun Sharma', 'arjun.sharma@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Adventure seeker exploring the Himalayas and hidden gems of North India. Love trekking and photography.', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400', 'Mountain Explorer,Photographer,Trekker'),
('Priya Patel', 'priya.patel@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Food blogger and cultural enthusiast from Gujarat. Passionate about discovering authentic Indian cuisines and festivals.', 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=400', 'Foodie,Cultural Explorer,Festival Lover'),
('Rajesh Kumar', 'rajesh.kumar@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Heritage enthusiast documenting historical monuments across India. Special interest in Mughal and Rajput architecture.', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400', 'Heritage Explorer,History Buff,Architecture Lover'),
('Meera Nair', 'meera.nair@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Backwater explorer from Kerala. Love sharing stories about South Indian culture, temples, and natural beauty.', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400', 'Backwater Explorer,Temple Hopper,Nature Lover'),
('Vikram Singh', 'vikram.singh@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Desert safari guide from Rajasthan. Expert in camel treks and desert camping experiences.', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400', 'Desert Guide,Camel Trekker,Stargazer');

-- Sample Blogs
INSERT INTO blogs (title, content, author, image, created_at) VALUES
('Incredible Journey Through Golden Triangle', 
'The Golden Triangle of India - Delhi, Agra, and Jaipur - offers an unforgettable introduction to India''s rich history and culture. Starting from the bustling streets of Delhi with its perfect blend of old and new, I was mesmerized by the Red Fort and India Gate.

The highlight was definitely the Taj Mahal in Agra. No photograph can capture the ethereal beauty of this marble masterpiece at sunrise. The intricate inlay work and the changing colors throughout the day left me speechless.

Jaipur, the Pink City, welcomed me with its royal palaces and vibrant bazaars. The Hawa Mahal and Amber Fort are architectural marvels that showcase Rajput grandeur. Don''t miss the local Rajasthani thali - it''s a feast for your taste buds!

Tips for travelers:
- Book Taj Mahal tickets online in advance
- Hire a good guide for historical context
- Try street food but choose busy stalls
- Bargain in local markets
- Carry cash for small vendors

This 7-day journey gave me a perfect glimpse into India''s incredible heritage. Each city has its own character and charm that will leave you wanting more.',
'arjun.sharma@email.com',
'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900',
'2024-01-15 10:30:00'),

('Backwaters of Kerala: A Serene Escape',
'Kerala''s backwaters are truly God''s Own Country. My 3-day houseboat journey through Alleppey and Kumarakom was nothing short of magical. Floating through narrow canals lined with coconut palms, watching local life unfold along the banks - it''s pure tranquility.

The houseboat experience is unique to Kerala. Our traditional kettuvallam had all modern amenities while maintaining its rustic charm. The crew prepared authentic Kerala meals - fish curry, appam, and coconut-based dishes that were absolutely delicious.

Highlights of my trip:
- Sunrise over Vembanad Lake
- Village walks through spice gardens
- Ayurvedic massage at a local center
- Bird watching at Kumarakom Bird Sanctuary
- Sunset cruise through narrow canals

The best time to visit is October to March when the weather is pleasant. Book houseboats in advance, especially during peak season. Don''t forget to try the local toddy (palm wine) and fresh seafood.

Kerala''s backwaters offer a perfect digital detox. The slow pace of life, gentle lapping of water, and lush greenery create an atmosphere of complete relaxation. It''s a must-visit destination for anyone seeking peace and natural beauty.',
'meera.nair@email.com',
'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900',
'2024-01-20 14:45:00'),

('Trekking in Himachal: Valley of Flowers',
'The Valley of Flowers trek in Himachal Pradesh is a paradise for nature lovers and adventure enthusiasts. This UNESCO World Heritage site blooms with over 300 species of alpine flowers from July to September.

Starting from Govindghat, the trek takes you through diverse landscapes - from dense forests to alpine meadows. The first day involves reaching Ghangaria base camp, which serves as the gateway to both Valley of Flowers and Hemkund Sahib.

The valley itself is breathtaking. Carpets of blue poppies, brahmakamal, and countless other flowers create a natural wonderland. The backdrop of snow-capped peaks adds to the surreal beauty. I was lucky to spot some rare Himalayan wildlife including the elusive snow leopard tracks.

Essential tips for the trek:
- Best time: July to September
- Carry rain gear and warm clothes
- Book accommodation in advance
- Hire local guides for safety
- Respect the fragile ecosystem
- Carry enough water and snacks

The trek is moderately difficult and suitable for beginners with basic fitness. The spiritual experience at Hemkund Sahib Gurudwara adds another dimension to this journey.

This trek reminded me why the Himalayas are called the abode of gods. The pristine beauty and spiritual energy of this place will stay with me forever.',
'arjun.sharma@email.com',
'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900',
'2024-02-01 09:15:00'),

('Rajasthan Desert Safari: Jaisalmer Experience',
'Jaisalmer, the Golden City, offers one of India''s most authentic desert experiences. My 2-day desert safari in the Thar Desert was filled with adventure, culture, and unforgettable memories.

The camel safari began at sunset from Sam Sand Dunes. Riding through golden sand dunes as the sun painted the sky in brilliant oranges and reds was magical. Our camel guide shared fascinating stories about desert life and navigation techniques used by ancient traders.

The overnight desert camp was incredible. Traditional Rajasthani folk music and dance performances around the bonfire created an authentic cultural experience. The clear desert sky offered spectacular stargazing opportunities - the Milky Way was clearly visible.

Desert safari highlights:
- Camel ride through sand dunes
- Sunset and sunrise views
- Traditional Rajasthani dinner
- Folk music and dance performances
- Stargazing in clear desert skies
- Visit to local desert villages

Jaisalmer Fort, a living fort with people still residing inside, is another must-visit. The intricate stone carvings and havelis showcase exquisite Rajasthani architecture.

Best time to visit is October to March when temperatures are pleasant. Carry sunscreen, hat, and plenty of water. The desert can get quite cold at night, so pack warm clothes.

This desert adventure gave me a deep appreciation for Rajasthani culture and the resilience of desert communities.',
'vikram.singh@email.com',
'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900',
'2024-02-10 16:20:00'),

('Goa Beyond Beaches: Hidden Cultural Gems',
'While Goa is famous for its beaches, my recent trip revealed the state''s rich cultural heritage and hidden gems beyond the coastline. From Portuguese colonial architecture to spice plantations, Goa offers diverse experiences.

Old Goa, the former Portuguese capital, houses magnificent churches and cathedrals. The Basilica of Bom Jesus, containing St. Francis Xavier''s remains, and Se Cathedral are architectural marvels showcasing Indo-Portuguese style.

The spice plantation tour in Ponda was enlightening. Walking through organic farms growing cardamom, pepper, cinnamon, and nutmeg while learning about traditional farming methods was fascinating. The traditional Goan lunch served on banana leaves was delicious.

Hidden gems I discovered:
- Divar Island - peaceful and untouched
- Fontainhas - Latin Quarter with colorful houses
- Dudhsagar Falls - spectacular during monsoon
- Chorao Island - bird watching paradise
- Local fish markets - authentic Goan experience

Goan cuisine goes beyond seafood. Try bebinca (traditional dessert), feni (local liquor), and various coconut-based curries. The Portuguese influence is evident in dishes like vindaloo and sorpotel.

The best time to explore cultural Goa is during the cooler months from November to February. Rent a scooter for easy transportation and flexibility to explore off-beaten paths.

Goa''s cultural richness surprised me. It''s not just a beach destination but a place where Indian and Portuguese cultures have beautifully merged over centuries.',
'priya.patel@email.com',
'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=900',
'2024-02-15 11:30:00'),

('Spiritual Journey: Varanasi and Rishikesh',
'My spiritual journey through India''s holiest cities - Varanasi and Rishikesh - was transformative. These ancient cities offer profound spiritual experiences that touch your soul.

Varanasi, one of the world''s oldest continuously inhabited cities, pulsates with spiritual energy. The evening Ganga Aarti at Dashashwamedh Ghat is mesmerizing. Thousands of devotees gather as priests perform elaborate rituals with fire, creating a divine atmosphere.

The early morning boat ride on the Ganges revealed the city''s spiritual rhythm. Pilgrims taking holy dips, sadhus in meditation, and the ancient ghats bathed in golden sunlight create an otherworldly experience.

Rishikesh, the Yoga Capital of the World, offers a different spiritual dimension. Nestled in the Himalayan foothills along the Ganges, it''s perfect for meditation and self-reflection. I attended yoga sessions at various ashrams and found inner peace.

Spiritual highlights:
- Ganga Aarti ceremony in Varanasi
- Sunrise boat ride on the Ganges
- Meditation sessions in Rishikesh ashrams
- Visit to Beatles Ashram
- River rafting on the Ganges
- Satsang (spiritual gatherings) with gurus

Both cities offer vegetarian food that''s not just delicious but spiritually nourishing. The simple dal, rice, and vegetables prepared with love taste divine.

This journey taught me that spirituality isn''t about rituals but about connecting with your inner self. India''s ancient wisdom and spiritual traditions offer guidance for modern life''s challenges.',
'rajesh.kumar@email.com',
'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900',
'2024-02-20 08:45:00');

-- Sample Trips
INSERT INTO trips (user_email, destination, start_date, end_date, notes, created_at) VALUES
('arjun.sharma@email.com', 'Ladakh', '2024-06-15', '2024-06-25', 'High altitude adventure - Leh, Nubra Valley, Pangong Lake. Need to acclimatize properly and carry warm clothes.', '2024-03-01 10:00:00'),
('priya.patel@email.com', 'Hampi', '2024-04-10', '2024-04-15', 'Exploring Vijayanagara Empire ruins. Planning to stay in heritage hotels and try local Karnataka cuisine.', '2024-03-05 14:30:00'),
('meera.nair@email.com', 'Munnar', '2024-05-20', '2024-05-25', 'Tea plantation tour and hill station retreat. Perfect for summer escape from Kerala heat.', '2024-03-10 09:15:00'),
('rajesh.kumar@email.com', 'Khajuraho', '2024-03-25', '2024-03-28', 'UNESCO World Heritage site visit. Studying temple architecture and sculptures of Chandela dynasty.', '2024-03-12 16:45:00'),
('vikram.singh@email.com', 'Rann of Kutch', '2024-12-15', '2024-12-20', 'Rann Utsav festival experience. White desert, cultural performances, and full moon night camping.', '2024-03-15 11:20:00'),
('arjun.sharma@email.com', 'Spiti Valley', '2024-07-10', '2024-07-20', 'Cold desert adventure in Himachal. Visiting Key Monastery, Chandratal Lake, and ancient villages.', '2024-03-18 13:00:00'),
('priya.patel@email.com', 'Mysore', '2024-10-02', '2024-10-06', 'Dasara festival celebration. Palace illumination, cultural programs, and South Indian heritage tour.', '2024-03-20 15:30:00');

-- Expanded Attractions Data
INSERT INTO attractions (city, name, price_range, city_image) VALUES
-- Delhi
('Delhi', 'Red Fort (Lal Qila)', '₹35 - ₹500', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'),
('Delhi', 'India Gate', 'Free', 'https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=900'),
('Delhi', 'Qutub Minar', '₹30 - ₹500', 'https://images.unsplash.com/photo-1597149960419-0d90ac2e3db4?w=900'),
('Delhi', 'Lotus Temple', 'Free', 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=900'),
('Delhi', 'Humayun''s Tomb', '₹40 - ₹600', 'https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=900'),
('Delhi', 'Chandni Chowk', 'Free', 'https://images.unsplash.com/photo-1605649487212-47bdab064df7?w=900'),

-- Mumbai
('Mumbai', 'Gateway of India', 'Free', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'),
('Mumbai', 'Marine Drive', 'Free', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),
('Mumbai', 'Elephanta Caves', '₹40 - ₹600', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'),
('Mumbai', 'Chhatrapati Shivaji Terminus', 'Free', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),
('Mumbai', 'Dhobi Ghat', 'Free', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'),
('Mumbai', 'Juhu Beach', 'Free', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),

-- Jaipur
('Jaipur', 'Hawa Mahal', '₹50 - ₹200', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'),
('Jaipur', 'Amber Fort', '₹100 - ₹500', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Jaipur', 'City Palace', '₹130 - ₹700', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'),
('Jaipur', 'Jantar Mantar', '₹50 - ₹200', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Jaipur', 'Nahargarh Fort', '₹25 - ₹200', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'),
('Jaipur', 'Jal Mahal', 'Free (exterior view)', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),

-- Goa
('Goa', 'Baga Beach', 'Free', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'),
('Goa', 'Basilica of Bom Jesus', '₹5', 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=900'),
('Goa', 'Dudhsagar Falls', '₹30 - ₹1000', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'),
('Goa', 'Fort Aguada', 'Free', 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=900'),
('Goa', 'Anjuna Beach', 'Free', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'),
('Goa', 'Spice Plantation Tour', '₹400 - ₹800', 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=900'),

-- Agra
('Agra', 'Taj Mahal', '₹50 - ₹1300', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900'),
('Agra', 'Agra Fort', '₹40 - ₹650', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900'),
('Agra', 'Mehtab Bagh', '₹25 - ₹300', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900'),
('Agra', 'Itimad-ud-Daulah', '₹25 - ₹300', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?w=900'),

-- Kerala
('Kochi', 'Chinese Fishing Nets', 'Free', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'),
('Kochi', 'Mattancherry Palace', '₹5', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'),
('Kochi', 'St. Francis Church', 'Free', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'),
('Alleppey', 'Backwater Houseboat', '₹3000 - ₹15000', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'),
('Alleppey', 'Alappuzha Beach', 'Free', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'),
('Munnar', 'Tea Gardens', '₹50 - ₹200', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'),
('Munnar', 'Eravikulam National Park', '₹90 - ₹300', 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=900'),

-- Rajasthan
('Udaipur', 'City Palace', '₹300 - ₹700', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Udaipur', 'Lake Pichola', '₹400 - ₹1000', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Udaipur', 'Jag Mandir', '₹700 - ₹1500', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Jaisalmer', 'Jaisalmer Fort', '₹30 - ₹250', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Jaisalmer', 'Sam Sand Dunes', '₹500 - ₹3000', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Jaisalmer', 'Patwon Ki Haveli', '₹20 - ₹150', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Jodhpur', 'Mehrangarh Fort', '₹60 - ₹600', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),
('Jodhpur', 'Jaswant Thada', '₹30 - ₹100', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=900'),

-- Himachal Pradesh
('Shimla', 'The Ridge', 'Free', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900'),
('Shimla', 'Jakhoo Temple', 'Free', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900'),
('Manali', 'Rohtang Pass', '₹50 - ₹500', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900'),
('Manali', 'Solang Valley', '₹100 - ₹2000', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900'),
('Dharamshala', 'Dalai Lama Temple', 'Free', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900'),
('Dharamshala', 'Bhagsu Waterfall', 'Free', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900'),

-- Uttar Pradesh
('Varanasi', 'Kashi Vishwanath Temple', 'Free', 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900'),
('Varanasi', 'Ganga Aarti', 'Free', 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900'),
('Varanasi', 'Sarnath', '₹25 - ₹300', 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900'),
('Lucknow', 'Bara Imambara', '₹25 - ₹500', 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=900'),

-- Karnataka
('Bangalore', 'Lalbagh Botanical Garden', '₹10', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),
('Bangalore', 'Bangalore Palace', '₹230 - ₹460', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),
('Mysore', 'Mysore Palace', '₹70 - ₹200', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),
('Mysore', 'Chamundi Hills', 'Free', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),
('Hampi', 'Virupaksha Temple', '₹30', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),
('Hampi', 'Vittala Temple', '₹40 - ₹600', 'https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=900'),

-- Tamil Nadu
('Chennai', 'Marina Beach', 'Free', 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=900'),
('Chennai', 'Kapaleeshwarar Temple', 'Free', 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=900'),
('Madurai', 'Meenakshi Temple', 'Free', 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=900'),
('Ooty', 'Botanical Gardens', '₹30', 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=900'),

-- West Bengal
('Kolkata', 'Victoria Memorial', '₹30 - ₹500', 'https://images.unsplash.com/photo-1558431382-27e303142255?w=900'),
('Kolkata', 'Howrah Bridge', 'Free', 'https://images.unsplash.com/photo-1558431382-27e303142255?w=900'),
('Darjeeling', 'Tiger Hill', '₹10', 'https://images.unsplash.com/photo-1558431382-27e303142255?w=900'),
('Darjeeling', 'Toy Train', '₹15 - ₹1500', 'https://images.unsplash.com/photo-1558431382-27e303142255?w=900');

-- Comprehensive City Information
INSERT INTO city_info (city, how_to_reach, nearest_station, nearest_airport) VALUES
('Delhi', 'Well connected by air, rail, and road from all major cities. Metro connectivity within the city.', 'New Delhi Railway Station', 'Indira Gandhi International Airport'),
('Mumbai', 'Major hub with excellent connectivity by air, rail, and road. Local trains connect the entire city.', 'Chhatrapati Shivaji Terminus', 'Chhatrapati Shivaji International Airport'),
('Jaipur', 'Connected by air, rail, and road. Regular flights and trains from Delhi and Mumbai. Good bus connectivity.', 'Jaipur Junction', 'Jaipur International Airport'),
('Goa', 'Accessible by air, rail, and road. Regular flights from major cities. Konkan Railway connects to Mumbai.', 'Madgaon Railway Station', 'Goa International Airport'),
('Agra', 'Well connected by rail and road. Gatimaan Express from Delhi. Regular bus services from nearby cities.', 'Agra Cantt Railway Station', 'Agra Airport (limited flights)'),
('Kochi', 'Major port city with air, rail, road, and sea connectivity. Gateway to Kerala backwaters.', 'Ernakulam Junction', 'Cochin International Airport'),
('Alleppey', 'Connected by road and rail from Kochi. Famous for backwater houseboats and canoe rides.', 'Alappuzha Railway Station', 'Cochin International Airport (85 km)'),
('Munnar', 'Accessible by road from Kochi and Madurai. Scenic drive through Western Ghats.', 'Aluva Railway Station (110 km)', 'Cochin International Airport (110 km)'),
('Udaipur', 'Connected by air, rail, and road. Palace on Wheels luxury train available. Good highway connectivity.', 'Udaipur City Railway Station', 'Maharana Pratap Airport'),
('Jaisalmer', 'Connected by rail and road. Desert triangle circuit with Jodhpur and Bikaner.', 'Jaisalmer Railway Station', 'Jodhpur Airport (285 km)'),
('Jodhpur', 'Well connected by air, rail, and road. Gateway to Thar Desert region.', 'Jodhpur Junction', 'Jodhpur Airport'),
('Shimla', 'Connected by road and toy train from Kalka. Scenic mountain railway journey.', 'Kalka Railway Station (96 km)', 'Chandigarh Airport (117 km)'),
('Manali', 'Accessible by road from Delhi and Chandigarh. Popular for adventure sports and trekking.', 'Joginder Nagar (165 km)', 'Bhuntar Airport (50 km)'),
('Dharamshala', 'Connected by road and air. Home to Dalai Lama and Tibetan government in exile.', 'Pathankot Railway Station (85 km)', 'Gaggal Airport (15 km)'),
('Varanasi', 'Ancient city connected by air, rail, and road. Spiritual capital of India.', 'Varanasi Junction', 'Lal Bahadur Shastri Airport'),
('Lucknow', 'Capital of UP, well connected by air, rail, and road. Rich Nawabi culture and cuisine.', 'Lucknow Junction', 'Chaudhary Charan Singh Airport'),
('Bangalore', 'IT capital of India, excellent connectivity by air, rail, and road. Pleasant weather year-round.', 'Bangalore City Railway Station', 'Kempegowda International Airport'),
('Mysore', 'Connected by road and rail from Bangalore. Famous for Dasara festival and silk sarees.', 'Mysore Junction', 'Bangalore Airport (170 km)'),
('Hampi', 'UNESCO World Heritage site, accessible by road and rail. Ancient Vijayanagara Empire ruins.', 'Hospet Junction (13 km)', 'Hubli Airport (143 km)'),
('Chennai', 'Major South Indian hub with excellent air, rail, road, and sea connectivity.', 'Chennai Central', 'Chennai International Airport'),
('Madurai', 'Temple city connected by air, rail, and road. Famous for Meenakshi Temple.', 'Madurai Junction', 'Madurai Airport'),
('Ooty', 'Hill station accessible by road and toy train from Mettupalayam. Queen of hill stations.', 'Mettupalayam (46 km)', 'Coimbatore Airport (88 km)'),
('Kolkata', 'Cultural capital of India, connected by air, rail, road, and river. Rich literary and artistic heritage.', 'Howrah Junction', 'Netaji Subhas Chandra Bose Airport'),
('Darjeeling', 'Famous hill station accessible by road and toy train from New Jalpaiguri. Tea gardens and Himalayan views.', 'New Jalpaiguri (65 km)', 'Bagdogra Airport (68 km)');

-- Sample Messages (Contact Form)
INSERT INTO messages (name, email, message, created_at) VALUES
('Ankit Gupta', 'ankit.gupta@email.com', 'Hi! I loved reading about the Kerala backwaters experience. Could you share more details about houseboat booking and the best time to visit? Planning a trip with family next month.', '2024-03-01 09:30:00'),
('Sneha Reddy', 'sneha.reddy@email.com', 'Your Rajasthan desert safari blog was amazing! I''m planning a solo trip to Jaisalmer. Is it safe for solo female travelers? Any specific recommendations for desert camps?', '2024-03-02 14:15:00'),
('Rohit Sharma', 'rohit.sharma@email.com', 'Great content on your website! I''m a travel photographer and would love to contribute some articles about Northeast India. How can I get in touch with your editorial team?', '2024-03-03 11:45:00'),
('Kavya Nair', 'kavya.nair@email.com', 'The Himachal trekking guide was very helpful. I''m planning the Valley of Flowers trek. Could you share the contact details of the local guides you mentioned?', '2024-03-04 16:20:00'),
('Deepak Kumar', 'deepak.kumar@email.com', 'I noticed some attractions are missing for Goa in your database. I can help add more places like Arambol Beach, Chapora Fort, and local markets. Let me know if you need help.', '2024-03-05 10:10:00');

-- Update existing sample data with more realistic content
UPDATE blogs SET 
content = 'The Golden Triangle of India - Delhi, Agra, and Jaipur - offers an unforgettable introduction to India''s rich history and culture. This classic route covers three UNESCO World Heritage sites and showcases the best of Mughal and Rajput architecture.

**Delhi: Where History Meets Modernity**
Starting from the bustling streets of Delhi, I was amazed by the perfect blend of ancient and contemporary. The Red Fort stands majestically as a testament to Mughal grandeur, while India Gate serves as a memorial to Indian soldiers. Don''t miss the narrow lanes of Chandni Chowk for authentic street food and the serene Lotus Temple for some peaceful moments.

**Agra: The City of Love**
The highlight was definitely the Taj Mahal. No photograph can capture the ethereal beauty of this marble masterpiece at sunrise. The intricate inlay work and the changing colors throughout the day left me speechless. Shah Jahan''s love for Mumtaz Mahal is immortalized in every curve and detail of this monument.

**Jaipur: The Pink City**
Jaipur welcomed me with its royal palaces and vibrant bazaars. The Hawa Mahal''s unique architecture allowed royal ladies to observe street life while remaining unseen. Amber Fort, with its mirror work and elephant rides, showcases Rajput valor and artistry.

**Practical Tips:**
- Book Taj Mahal tickets online in advance
- Hire certified guides for historical context
- Try local cuisines: Delhi''s paranthas, Agra''s petha, Jaipur''s dal baati churma
- Bargain in local markets but be respectful
- Carry cash for small vendors and tips
- Best time to visit: October to March

This 7-day journey gave me a perfect glimpse into India''s incredible heritage. Each city has its own character and charm that will leave you planning your next Indian adventure!'
WHERE title = 'Incredible Journey Through Golden Triangle';

COMMIT;