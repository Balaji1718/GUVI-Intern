# Login Page Project

A simple user authentication system built with PHP, MongoDB, and Redis for session management.

## Features

- User Registration
- User Login/Logout
- User Profile Management
- Session Management with Redis
- MongoDB Database Integration
- Responsive UI with Bootstrap

## Tech Stack

- **Backend**: PHP
- **Database**: MongoDB
- **Session Store**: Redis (optional)
- **Frontend**: HTML, CSS, JavaScript, Bootstrap, jQuery
- **Dependencies**: Composer

## Prerequisites

- PHP 7.4 or higher
- MongoDB
- Redis (optional)
- Composer
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:
```bash
git clone <your-repo-url>
cd Login_page
```

2. Install dependencies:
```bash
composer install
```

3. Configure your database connection in the PHP files as needed.

4. Start your web server and navigate to the project directory.

## Project Structure

```
Login_page/
├── css/
│   └── style.css          # Custom styles
├── html/
│   ├── index.html         # Landing page
│   ├── login.html         # Login form
│   ├── register.html      # Registration form
│   └── profile.html       # User profile page
├── js/
│   ├── login.js           # Login functionality
│   ├── register.js        # Registration functionality
│   └── profile.js         # Profile management
├── php/
│   ├── login.php          # Login handler
│   ├── register.php       # Registration handler
│   ├── profile.php        # Profile data handler
│   ├── logout.php         # Logout handler
│   ├── redis.php          # Redis connection
│   ├── mongo.php          # MongoDB connection
│   └── db.php             # SQL database connection
├── vendor/                # Composer dependencies
├── composer.json          # Composer configuration
└── .gitignore            # Git ignore rules
```

## Usage

1. Navigate to `html/index.html` to start
2. Register a new account or login with existing credentials
3. Access your profile after successful authentication

## API Endpoints

- `POST /php/register.php` - User registration
- `POST /php/login.php` - User login
- `GET /php/profile.php` - Get user profile
- `POST /php/logout.php` - User logout

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open source and available under the [MIT License](LICENSE).