# TravelTales - Travel Blog Platform

A comprehensive travel blog platform built with PHP, MySQL, and modern web technologies. Share your travel experiences, discover new destinations, and plan your next adventure.

## Features

- **User Authentication**: Secure login/signup system
- **Blog Management**: Create, read, and manage travel blogs
- **Trip Planning**: Plan and organize your trips
- **Destination Explorer**: Discover popular destinations across India
- **Profile Management**: Customize your traveler profile
- **Interactive Maps**: Explore destinations with Leaflet maps
- **Responsive Design**: Mobile-friendly interface with Tailwind CSS

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (optional, for dependencies)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd traveltales
   ```

2. **Database Setup**
   - Create a MySQL database named `traveltales`
   - Import the database schema:
   ```bash
   mysql -u root -p traveltales < config/database_schema.sql
   ```
   - **Option 1: Manual Setup (Most Reliable)**
     - Visit `http://your-domain/setup_manual.php` in your browser
     - Step-by-step table creation with detailed feedback
     - Handles database creation and data population
   
   - **Option 2: Debug First (If Issues)**
     - Visit `http://your-domain/debug_database.php` to check current state
     - Then run the appropriate setup method
   
   - **Option 3: Complete Setup**
     - Visit `http://your-domain/setup_complete.php` in your browser
     - Automated setup (may need debugging if it fails)
   
   - **Option 4: Command Line Setup**
   ```bash
   mysql -u root -p traveltales < config/database_schema.sql
   mysql -u root -p traveltales < config/sample_data.sql
   ```

3. **Configure Database Connection**
   - Update `db.php` with your database credentials:
   ```php
   $host = "localhost";
   $dbname = "traveltales";
   $user = "your_username";
   $pass = "your_password";
   ```

4. **Set Permissions**
   ```bash
   chmod 755 uploads/
   chmod 755 logs/
   ```

5. **Web Server Configuration**
   - Point your web server document root to the project directory
   - Ensure PHP is enabled
   - Enable URL rewriting if needed

## File Structure

```
traveltales/
├── index.php              # Homepage
├── login.php              # Login handler
├── signup.php             # Registration handler
├── logout.php             # Logout handler
├── blogs.php              # Blog listing
├── add-blog.php           # Create new blog
├── view-blog.php          # View individual blog
├── profile.php            # User profile
├── edit-profile.php       # Edit profile
├── explore.php            # Destination explorer
├── trip-planner.php       # Trip planning
├── contact.php            # Contact form
├── about.php              # About page
├── error.php              # Error page
├── config/
│   ├── db.php             # Database connection
│   ├── error_handler.php  # Error handling
│   └── database_schema.sql # Database structure
├── includes/
│   ├── header.php         # Common HTML head
│   ├── navbar.php         # Navigation component
│   └── footer.php         # Footer component
├── templates/
│   ├── login.html         # Login form
│   ├── signup.html        # Registration form
│   └── *.html             # Other HTML templates
├── public/
│   ├── css/
│   │   └── styles.css     # Custom styles
│   ├── js/
│   │   ├── navbar.js      # Navigation functionality
│   │   ├── trip-planner.js # Trip planning features
│   │   ├── contact.js     # Contact form handling
│   │   └── forms.js       # Form validation
│   └── images/            # Static images
├── api/
│   └── fetchtrips.php     # API endpoints
├── data/
│   ├── stories.json       # Sample stories data
│   └── blogs.json         # Sample blogs data
├── uploads/               # File uploads
├── logs/                  # Error logs
└── README.md              # Documentation
```

## Security Features

- **CSRF Protection**: Forms protected against cross-site request forgery
- **File Upload Validation**: Secure file upload with type and size validation
- **Input Sanitization**: All user inputs are sanitized
- **Password Hashing**: Secure password storage with bcrypt
- **Error Handling**: Comprehensive error logging and user-friendly error pages

## Sample Data Included

The database comes pre-populated with authentic Indian travel content:

### 🧑‍🤝‍🧑 Sample Users (5 Indian Travelers)
- **Arjun Sharma** - Mountain explorer and photographer
- **Priya Patel** - Food blogger and cultural enthusiast  
- **Rajesh Kumar** - Heritage and architecture lover
- **Meera Nair** - Backwater explorer from Kerala
- **Vikram Singh** - Desert safari guide from Rajasthan

### 📝 Travel Blogs (6 Detailed Articles)
- Golden Triangle journey (Delhi-Agra-Jaipur)
- Kerala backwaters experience
- Himachal trekking adventures
- Rajasthan desert safari
- Goa cultural exploration
- Spiritual journey (Varanasi-Rishikesh)

### 🏛️ Destinations (25+ Indian Cities)
- **North India**: Delhi, Agra, Jaipur, Shimla, Manali, Dharamshala, Varanasi, Lucknow
- **South India**: Bangalore, Mysore, Hampi, Chennai, Madurai, Ooty, Kochi, Alleppey, Munnar
- **West India**: Mumbai, Goa, Ahmedabad, Udaipur, Jaisalmer, Jodhpur
- **East India**: Kolkata, Darjeeling, Bhubaneswar, Puri
- **Special Regions**: Leh-Ladakh, Amritsar, Khajuraho

### 🎯 Attractions (80+ Tourist Spots)
Each destination includes popular attractions with:
- Accurate pricing information
- High-quality images
- Cultural and historical significance

## Usage

1. **Quick Start**: Run `setup_database.php` to populate sample data
2. **Login**: Use any sample user email with password: `password`
3. **Explore**: Browse 25+ Indian destinations and 80+ attractions
4. **Blog**: Read authentic travel stories or create your own
5. **Plan**: Use the trip planner with real Indian destinations
6. **Profile**: Customize your traveler profile with badges

## API Endpoints

- `fetchtrips.php?city=<city_name>` - Get attractions and city information

## Technologies Used

- **Backend**: PHP 7.4+, MySQL
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Styling**: Tailwind CSS, Bootstrap Icons
- **Maps**: Leaflet.js with OpenStreetMap
- **Security**: CSRF tokens, input validation, file upload security

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support or questions, please contact through the contact form on the website.

## Changelog

### Version 1.0.0
- Initial release
- User authentication system
- Blog management
- Trip planning
- Destination explorer
- Profile management
- Security enhancements
- Error handling
- Mobile responsive design