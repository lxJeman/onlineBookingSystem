# Online Booking System

A simple web-based booking system built with PHP and SQLite that allows users to manage events and appointments through an interactive calendar interface.

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
git clone https://github.com/yourusername/onlineBookingSystem.git
```

2. Configure your web server (Apache/Nginx) to serve the project directory

3. Ensure PHP and SQLite are installed:
```bash
sudo apt-get install php php-sqlite3
```

4. Set appropriate permissions for the SQLite database:
```bash
chmod 755 local.db
```

## File Structure

```
onlineBookingSystem/
├── database.php      # Database configuration and queries
├── login.php         # User login interface
├── registration.php  # New user registration
├── dashboard.php     # Main calendar and event management
├── fetchEvents.php   # API endpoint for event data
└── local.db         # SQLite database
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
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    password TEXT NOT NULL
);
```

### Events Table
```sql
CREATE TABLE events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    person TEXT NOT NULL,
    contact TEXT NOT NULL,
    date TEXT NOT NULL,
    time TEXT NOT NULL,
    extra TEXT NOT NULL
);
```

## Security Features

- Password hashing
- SQL injection prevention using prepared statements
- XSS protection with input sanitization
- Session-based authentication
- License key requirement for registration

## Requirements

- PHP 7.4 or higher
- SQLite3
- Modern web browser with JavaScript enabled

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request