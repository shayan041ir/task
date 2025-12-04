# CI3 User Management System

A complete user management system built with CodeIgniter 3 framework that includes authentication, authorization, and user administration features with DataTables integration.

## 🚀 Features

- ✅ User registration and authentication system
- ✅ Role-based access control (Admin/User)
- ✅ Admin panel for user management
- ✅ DataTables with search, sort, and pagination
- ✅ Full CRUD operations for users
- ✅ Password security with BCRYPT hashing
- ✅ Client and server-side validation
- ✅ RTL support (Persian/Arabic interface ready)
- ✅ Responsive design with Bootstrap 5

## 📋 Table of Contents

- [Installation](#installation)
- [Database Setup](#database-setup)
- [Configuration](#configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Security Features](#security-features)
- [API Endpoints](#api-endpoints)
- [Contributing](#contributing)
- [License](#license)

## Installation

### Prerequisites
- PHP 5.6 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Composer (optional for dependency management)

### Steps
1. Clone or download the repository to your web server directory
```bash
git clone https://github.com/your-username/ci3-user-management.git
```

2. Navigate to the project directory
```bash
cd ci3-user-management
```

3. Install dependencies (if using Composer)
```bash
composer install
```

## Database Setup

### Create the database
```sql
CREATE DATABASE task CHARACTER SET utf8 COLLATE utf8_general_ci;
```

### Create the users table
```sql
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

### Create an initial admin user
```sql
INSERT INTO users (name, email, password, role)
VALUES ('Admin User', 'admin@example.com', '$2y$10$...', 'admin');
```
Note: Use BCRYPT to hash the password before inserting.

## Configuration

### Database Configuration
Edit `application/config/database.php` with your database credentials:

```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'task',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

### URL Configuration
Edit `application/config/config.php` to set your base URL:

```php
$config['base_url'] = 'http://localhost/task/';
```

## Usage

### Accessing the System
1. Open your browser and go to: `http://localhost/task`
2. Use the default admin credentials to log in
3. Access the user management panel under "Admin" section

### Default Routes
- `/` - Login page (default controller)
- `/register` - User registration
- `/login` - Login page
- `/logout` - Logout
- `/profile` - User profile
- `/admin/users` - User management panel

### Admin Panel Features
- View all users in a DataTable
- Add new users
- Edit existing users
- Delete users (with safety checks)
- Search and filter users
- Sort by different columns

## Project Structure

```
task/
├── application/                 # Main application directory
│   ├── config/                 # Configuration files
│   │   ├── database.php        # Database settings
│   │   ├── routes.php          # URL routing
│   │   └── ...                 # Other config files
│   ├── controllers/            # Controller classes
│   │   ├── Auth.php           # Authentication controller
│   │   └── admin/
│   │       └── Users.php      # User management controller
│   ├── models/                # Model classes
│   │   └── User_model.php     # User model
│   ├── libraries/             # Custom libraries
│   │   └── UserService.php    # User service
│   ├── views/                 # View templates
│   │   ├── admin/             # Admin panel views
│   │   ├── auth/              # Authentication views
│   │   └── templates/         # Shared templates
│   └── ...
├── assets/                    # CSS, JS, images
├── system/                    # CodeIgniter core
├── index.php                  # Main entry point
└── .htaccess                  # URL rewriting rules
```

## Security Features

### Authentication
- Secure password hashing with BCRYPT
- Session-based authentication
- Role-based access control
- Secure password verification

### Access Control
- Admin-only access to user management
- Prevention of self-deletion by admin
- AJAX request validation
- CSRF protection (if enabled)

### Input Validation
- Server-side validation with Form Validation library
- Email uniqueness check
- Password strength validation
- XSS protection with input filtering

## API Endpoints

### DataTables API
- `GET /admin/users/list` - Retrieve users in JSON format for DataTables

### User Management API
- `POST /admin/users/create` - Create new user
- `POST /admin/users/edit/{id}` - Update user by ID
- `GET /admin/users/edit/{id}` - Get user data for editing
- `POST /admin/users/delete/{id}` - Delete user by ID

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and development questions:
- CodeIgniter Forum: http://forum.codeigniter.com/
- GitHub Wiki: https://github.com/bcit-ci/CodeIgniter/wiki
- Slack: https://codeigniterchat.slack.com

---

**Project Version:** 1.0  
**Framework:** CodeIgniter 3  
**Created:** 2025