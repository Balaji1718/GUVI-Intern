# Login System - Full Stack Application

A secure login system built with PHP, MySQL, MongoDB, and Redis featuring responsive design and comprehensive user management.

## 🚀 Live Demo
Deploy this application on [Render](https://render.com) with the configuration below.

## 📋 Features

- ✅ **Multi-Database Integration**: MySQL, MongoDB, Redis
- ✅ **Secure Authentication**: Password hashing, prepared statements
- ✅ **Session Management**: Redis-based tokens with expiry
- ✅ **Responsive Design**: Bootstrap 5.3 framework
- ✅ **Form Validation**: Client and server-side validation
- ✅ **Loading Animations**: Enhanced UX with loading states
- ✅ **Clean Architecture**: Separated HTML/CSS/JS/PHP files

## 🛠️ Tech Stack

- **Backend**: PHP 7.4+
- **Databases**: MySQL, MongoDB Atlas, Redis Cloud
- **Frontend**: HTML5, CSS3, JavaScript ES6
- **Framework**: Bootstrap 5.3, jQuery 3.6
- **Deployment**: Render Platform
- **Dependencies**: Composer

## 🌐 Render Deployment

### Step 1: Repository Setup
1. Push your code to GitHub
2. Connect your GitHub repository to Render

### Step 2: Render Configuration
- **Build Command**: `composer install`
- **Start Command**: `php -S 0.0.0.0:10000 -t .`
- **Environment**: `PHP`

### Step 3: Environment Variables
Add these environment variables in your Render dashboard:

| Variable | Description | Example |
|----------|-------------|---------|
| `DB_HOST` | MySQL database host | `sql.freedb.tech` |
| `DB_USER` | MySQL username | `freedb_your_user` |
| `DB_PASS` | MySQL password | `your_password` |
| `DB_NAME` | MySQL database name | `freedb_your_db` |
| `MYSQL_PORT` | MySQL port | `3306` |
| `MONGODB_URI` | MongoDB connection string | `mongodb+srv://user:pass@cluster.mongodb.net/dbname` |
| `REDIS_URL` | Redis connection URL | `redis://default:pass@host:port` |

### Step 4: Local Development Setup

#### Prerequisites
- PHP 7.4+
- Composer
- XAMPP/WAMP (for local testing)

#### Installation
```bash
# Clone the repository
git clone https://github.com/Balaji1718/GUVI-Intern.git
cd Login_page

# Install dependencies
composer install

# Start local server
php -S localhost:8000 -t .
```

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

## 🛡️ Security Features

- **Password Hashing**: PHP `password_hash()` and `password_verify()`
- **Prepared Statements**: SQL injection prevention
- **Session Tokens**: Redis-based session management (1-hour expiry)
- **Input Validation**: Server-side and client-side validation
- **Error Handling**: Comprehensive try-catch blocks

## 📝 API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/php/register.php` | POST | User registration |
| `/php/login.php` | POST | User authentication |
| `/php/profile.php` | GET | Get user profile |
| `/php/logout.php` | POST | User logout |

## 🧪 Database Setup

### MySQL (FreeSQLDatabase)
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT,
    contact VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### MongoDB Atlas
- Create a cluster and database
- Collection: `profiles` (auto-created)
- Network access: Allow all IPs (0.0.0.0/0)

### Redis Cloud
- Create Redis instance
- Note the connection URL with credentials

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 👨‍💻 Author

**Balaji1718**
- GitHub: [@Balaji1718](https://github.com/Balaji1718)
- Repository: [GUVI-Intern](https://github.com/Balaji1718/GUVI-Intern)

## 📄 License

This project is part of GUVI internship program.

---

## 🚀 Quick Deploy to Render

[![Deploy to Render](https://render.com/images/deploy-to-render-button.svg)](https://render.com/deploy)

**Built with ❤️ during GUVI Internship Program**