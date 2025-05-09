# Online Booking System

A web-based booking system built with PHP and MySQL (PHPMyAdmin) that allows users to manage events and appointments through an interactive calendar interface.

## Features

- **User Authentication**
  - Secure login and registration system
  - License key protection for new registrations
  - Session-based user management

- **Event Management**
  - Create and manage events
  - View events in a monthly calendar format
  - Event details include:
    - Event name
    - Person name
    - Contact information
    - Date and time
    - Additional information

- **Calendar Interface**
  - Monthly view navigation
  - Event display by date
  - Interactive event details modal
  - Responsive design

## Installation

1. Clone the repository:
```bash
git clone https://github.com/lxjeman/onlineBookingSystem.git
```

2. Configure your web server (Apache/Nginx) to serve the project directory

3. Set up the MySQL Database:
   - Open PHPMyAdmin in your browser
   - Create a new database named 'booking_system'
   - Update database credentials in `database.php`:
```php
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

4. Ensure PHP and MySQL are installed:
```bash
sudo apt-get install php php-mysql
```

## File Structure

```
onlineBookingSystem/
├── database.php      # Database configuration and queries
├── login.php         # User login interface
├── registration.php  # New user registration
├── dashboard.php     # Main calendar and event management
└── fetchEvents.php   # API endpoint for event data
```

## Usage

1. Register a new account using the provided LICENSE_KEY
2. Log in to access the dashboard
3. Use the calendar interface to:
   - Navigate between months
   - View existing events
   - Add new events
   - Click events to view details

## Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Events Table
```sql
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    person VARCHAR(255) NOT NULL,
    contact VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    extra TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Security Features

- Password hashing
- SQL injection prevention using prepared statements
- XSS protection with input sanitization
- Session-based authentication
- License key requirement for registration

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- PHPMyAdmin
- Apache/Nginx web server
- Modern web browser with JavaScript enabled

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request