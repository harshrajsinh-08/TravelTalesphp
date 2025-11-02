-- TravelTales Database Schema
-- Run this SQL to create the required database structure

CREATE DATABASE IF NOT EXISTS traveltales;
USE traveltales;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    bio TEXT,
    profile_pic VARCHAR(500) DEFAULT 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=1024&auto=format&fit=crop',
    badges TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blogs table
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(500) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(255) NOT NULL,
    image VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Trips table
CREATE TABLE IF NOT EXISTS trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(255) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_email) REFERENCES users(email) ON DELETE CASCADE
);

-- Attractions table
CREATE TABLE IF NOT EXISTS attractions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(255) NOT NULL,
    name VARCHAR(500) NOT NULL,
    price_range VARCHAR(100),
    city_image VARCHAR(500)
);

-- City info table
CREATE TABLE IF NOT EXISTS city_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(255) UNIQUE NOT NULL,
    how_to_reach TEXT,
    nearest_station VARCHAR(255),
    nearest_airport VARCHAR(255)
);

-- Messages table (for contact form)
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data for attractions
INSERT IGNORE INTO attractions (city, name, price_range, city_image) VALUES
('Delhi', 'Red Fort', '₹35 - ₹500', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'),
('Delhi', 'India Gate', 'Free', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'),
('Delhi', 'Qutub Minar', '₹30 - ₹500', 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900'),
('Mumbai', 'Gateway of India', 'Free', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'),
('Mumbai', 'Marine Drive', 'Free', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'),
('Mumbai', 'Elephanta Caves', '₹40 - ₹600', 'https://images.unsplash.com/photo-1595655406770-803d83d15ad9?w=900'),
('Jaipur', 'Hawa Mahal', '₹50 - ₹200', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'),
('Jaipur', 'Amber Fort', '₹100 - ₹500', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'),
('Jaipur', 'City Palace', '₹130 - ₹700', 'https://images.unsplash.com/photo-1599661046827-dacde6976549?w=900'),
('Goa', 'Baga Beach', 'Free', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'),
('Goa', 'Basilica of Bom Jesus', '₹5', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900'),
('Goa', 'Dudhsagar Falls', '₹30 - ₹1000', 'https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=900');

-- Insert sample city info
INSERT IGNORE INTO city_info (city, how_to_reach, nearest_station, nearest_airport) VALUES
('Delhi', 'Well connected by air, rail, and road from all major cities', 'New Delhi Railway Station', 'Indira Gandhi International Airport'),
('Mumbai', 'Major hub with excellent connectivity by air, rail, and road', 'Chhatrapati Shivaji Terminus', 'Chhatrapati Shivaji International Airport'),
('Jaipur', 'Connected by air, rail, and road. Regular flights and trains from Delhi and Mumbai', 'Jaipur Junction', 'Jaipur International Airport'),
('Goa', 'Accessible by air, rail, and road. Regular flights from major cities', 'Madgaon Railway Station', 'Goa International Airport');