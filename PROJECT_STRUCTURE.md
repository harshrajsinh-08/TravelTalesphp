# TravelTales - Project Structure

## 📁 Directory Organization

```
traveltales/
├── 📄 index.php                    # Main homepage
├── 📄 login.php                    # Authentication handler
├── 📄 signup.php                   # User registration handler
├── 📄 logout.php                   # Logout handler
├── 📄 blogs.php                    # Blog listing page
├── 📄 add-blog.php                 # Create new blog
├── 📄 view-blog.php                # View individual blog
├── 📄 profile.php                  # User profile page
├── 📄 edit-profile.php             # Edit profile page
├── 📄 explore.php                  # Destination explorer
├── 📄 trip-planner.php             # Trip planning interface
├── 📄 contact.php                  # Contact form page
├── 📄 about.php                    # About page
├── 📄 error.php                    # Error handling page
├── 📄 .htaccess                    # Apache configuration
├── 📄 README.md                    # Main documentation
├── 📄 PROJECT_STRUCTURE.md         # This file
│
├── 📁 config/                      # Configuration files
│   ├── 📄 config.php               # Main configuration constants
│   ├── 📄 db.php                   # Database connection
│   ├── 📄 error_handler.php        # Error handling functions
│   └── 📄 database_schema.sql      # Database structure
│
├── 📁 includes/                    # Reusable PHP components
│   ├── 📄 header.php               # Common HTML head section
│   ├── 📄 navbar.php               # Navigation component
│   └── 📄 footer.php               # Footer component
│
├── 📁 templates/                   # HTML templates
│   ├── 📄 login.html               # Login form template
│   ├── 📄 signup.html              # Registration form template
│   ├── 📄 featured-stories.html    # Featured stories template
│   └── 📄 story.html               # Story template
│
├── 📁 public/                      # Public assets
│   ├── 📁 css/
│   │   └── 📄 styles.css           # Custom CSS styles
│   ├── 📁 js/
│   │   ├── 📄 navbar.js            # Navigation functionality
│   │   ├── 📄 trip-planner.js      # Trip planning features
│   │   ├── 📄 contact.js           # Contact form handling
│   │   ├── 📄 forms.js             # Form validation
│   │   └── 📄 navigation.js        # Additional navigation
│   └── 📁 images/                  # Static images (empty)
│
├── 📁 api/                         # API endpoints
│   └── 📄 fetchtrips.php           # Trip data API
│
├── 📁 data/                        # JSON data files
│   ├── 📄 stories.json             # Sample stories data
│   └── 📄 blogs.json               # Sample blogs data
│
├── 📁 uploads/                     # User uploaded files
│   └── (user uploaded images)
│
└── 📁 logs/                        # Application logs
    └── (error logs)
```

## 🎯 Key Benefits of This Structure

### 1. **Separation of Concerns**
- **Config**: All configuration in one place
- **Includes**: Reusable components
- **Templates**: Static HTML templates
- **Public**: Client-side assets
- **API**: Backend endpoints

### 2. **Security**
- Sensitive files in protected directories
- .htaccess rules for file protection
- Proper file permissions structure

### 3. **Maintainability**
- Clear file organization
- Easy to locate specific functionality
- Modular component structure

### 4. **Scalability**
- Easy to add new features
- Clean separation allows team development
- Standardized file locations

## 📋 File Descriptions

### Core Application Files
- **index.php**: Main landing page with hero section, featured stories, and trip planner
- **login.php/signup.php**: User authentication handlers
- **blogs.php**: Blog listing with pagination and search
- **profile.php**: User profile management
- **explore.php**: Destination discovery interface

### Configuration
- **config/config.php**: Environment variables, database settings, constants
- **config/db.php**: PDO database connection with error handling
- **config/error_handler.php**: Centralized error management

### Components
- **includes/header.php**: Common HTML head, meta tags, CSS/JS includes
- **includes/navbar.php**: Dynamic navigation with user state
- **includes/footer.php**: Footer with scripts and closing tags

### Assets
- **public/css/styles.css**: Custom Tailwind CSS extensions
- **public/js/**: Interactive JavaScript functionality
- **templates/**: Static HTML forms and pages

### Data & API
- **api/fetchtrips.php**: RESTful endpoint for trip data
- **data/**: JSON files for sample content

## 🔧 Development Workflow

1. **Configuration**: Update `config/config.php` for environment
2. **Database**: Run `config/database_schema.sql` to set up DB
3. **Components**: Modify `includes/` for layout changes
4. **Styling**: Update `public/css/styles.css` for design
5. **Functionality**: Add features in main PHP files
6. **Assets**: Place images in `public/images/`

## 🚀 Deployment Notes

- Ensure `uploads/` and `logs/` are writable
- Update database credentials in `config/config.php`
- Set `ENVIRONMENT` to 'production' in config
- Configure `.htaccess` for your server
- Test all file paths after deployment

## 📱 Mobile-First Design

The structure supports responsive design with:
- Tailwind CSS for mobile-first approach
- Separate JS files for progressive enhancement
- Optimized asset loading
- Touch-friendly navigation components

This organized structure makes TravelTales easy to maintain, secure, and scalable for future enhancements.