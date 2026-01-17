# Hotel Shayogi - Hotel Reservation System

A comprehensive hotel reservation management system built for Hotel Shayogi Nepal. This system allows guests to browse rooms, make reservations, and enables administrators to manage the hotel operations efficiently.

## Project Information

- **Project Type:** College Project
- **Developers:** Shree Krishna Karki, Nikesh Tamang
- **Location:** Bhaktapur, Nepal

## Technology Stack

| Layer | Technology |
|-------|------------|
| Frontend | HTML5, CSS3, JavaScript, jQuery |
| Backend | PHP |
| Database | MySQL |
| Server | XAMPP (Apache) |
| UI Framework | Bootstrap 5, Font Awesome Icons |

## Project Structure

```
Shayogi_Hotel_Reservation_System/
|
|-- admin/                    # Admin Panel
|   |-- Login/                # Admin authentication
|   |-- dashboard/            # Dashboard modules
|   |   |-- bedphp/           # Bed management
|   |   |-- calendarphp/      # Calendar/availability
|   |   |-- datephp/          # Date operations
|   |   |-- roomphp/          # Room management
|   |   |-- staffphp/         # Staff management
|   |   |-- userphp/          # User management
|   |   |-- css/              # Dashboard styles
|   |   +-- javascript/       # Dashboard scripts
|   |-- css/                  # Admin styles
|   |-- img/                  # Admin images
|   +-- js/                   # Admin scripts
|
|-- config/                   # Configuration files
|   +-- database.php          # Central database connection
|
|-- css/                      # Public stylesheets
|   |-- common/               # Shared CSS components
|   |   |-- base.css          # Base styles
|   |   |-- nav.css           # Navigation
|   |   |-- footer.css        # Footer
|   |   +-- booking.css       # Booking styles
|   +-- style.css             # Main stylesheet
|
|-- images/                   # Image assets
|   |-- gallery/              # Gallery photos
|   +-- hotel/                # Hotel branding
|       |-- guests/           # Guest profile images
|       +-- rooms/            # Room photos
|
|-- includes/                 # PHP includes
|   |-- header.php            # Site header
|   +-- footer.php            # Site footer
|
|-- javascript/               # Frontend scripts
|   |-- home.js               # Homepage functionality
|   |-- book.js               # Booking functionality
|   +-- modern-book.js        # Modern booking UI
|
|-- php/                      # Backend logic
|   |-- db.php                # Database wrapper
|   |-- user_auth.php         # User authentication
|   |-- book_room.php         # Room booking handler
|   |-- guest_crud.php        # Guest CRUD operations
|   +-- Showreview.php        # Reviews display
|
|-- index.php                 # Homepage
|-- rooms.php                 # Rooms listing
|-- bookroom.php              # Room booking page
|-- profile.php               # User profile
+-- Sahyogi.sql               # Database schema
```

## Features

### Guest Features
- Browse available rooms with images and details
- Search rooms by date, guests, and availability
- User registration and authentication
- Online room booking
- View booking history
- Write reviews

### Admin Features
- Secure admin login
- Dashboard with overview statistics
- Room management (Add, Edit, Delete rooms)
- Bed management
- Staff management
- Booking calendar management
- User management

## Installation

### Prerequisites
- XAMPP (or similar LAMP/WAMP stack)
- PHP 7.4 or higher
- MySQL 5.7 or higher

### Setup Steps

1. **Clone/Copy the project** to your XAMPP htdocs folder:
   ```
   C:\xampp\htdocs\Shayogi_Hotel_Reservation_System
   ```

2. **Start XAMPP** and ensure Apache and MySQL are running

3. **Create the database:**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `Sahyogi`
   - Import `Sahyogi.sql` file

4. **Configure database** (if needed):
   - Edit `config/database.php`
   - Update credentials if different from default XAMPP settings

5. **Access the application:**
   - Frontend: http://localhost/Shayogi_Hotel_Reservation_System/
   - Admin: http://localhost/Shayogi_Hotel_Reservation_System/admin/

## Database Configuration

The central database configuration is located at `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'Sahyogi');
```

## Screenshots

### Homepage
- Hero slider with hotel images
- Room search functionality
- About section
- Image gallery
- Guest reviews

### Admin Dashboard
- Windows-style desktop interface
- Room management
- Staff management
- Booking calendar

## License

This project is developed for educational purposes as a college project.

## Contact

For any queries regarding this project:
- Phone: +977 9861171281
- Location: Bhaktapur, Nepal
