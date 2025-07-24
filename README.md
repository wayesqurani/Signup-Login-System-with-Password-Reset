# 🔐 Project Title: Signup & Login System with Password Reset

## 🧩 PHP-Based Secure User Authentication System

A robust user authentication system built using **PHP**, **MySQL**, and **Tailwind CSS**, featuring user registration, login, session management, and password reset functionality via **PHPMailer**.

---

## ✨ Features

### 👤 User Registration
- Register with name, email, and password
- Passwords securely hashed using `password_hash()`
- User data stored in MySQL database

### 🔑 Secure Login
- Validates credentials from database
- If valid, starts session and redirects to dashboard
- If invalid, shows appropriate error messages

### 📬 Forgot Password (via Email)
- User enters email to reset password
- Sends a secure reset link to the registered email
- Link is **valid for 1 hour** using token expiry logic
- Uses **PHPMailer**(package/library) for sending email

### 🔁 Reset Password
- Reset form is accessed via emailed link
- Token and expiry are validated before allowing reset
- New password is hashed and stored securely

### 🧠 Session Management
- Users stay logged in using PHP sessions
- Includes session timeout and logout handling

---

## 🗂️ Folder Structure
```
signup-login-system/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       ├── checkEmail.js
│       └── script.js
├── auth/
│   ├── forget\_password.php
│   ├── email\_check.php
│   ├── login\_process.php
│   ├── logout.php
│   ├── register.php
│   └── reset\_password.php
├── includes/
│   ├── config.php           // 🔧 Database connection
│   ├── mailer.php           // 📧 PHPMailer setup
│   └── session.php          // 🔐 Session checker
├── pages/
│   └── dashboard.php        // 👤 User dashboard
├── login.php                // 🔓 Login form
├── signup.php               // 📝 Registration form
```
---

## ⚙️ Configuration

Update your database and email credentials in the following files:

### 🔧 Database Configuration  
Location: `includes/config.php`

```php
$host     = "your_host";
$db_user  = "your-database-user";
$db_pass  = "your-database-password";
$db_name  = "your-database-name";
````

### 📧 PHPMailer SMTP Setup

Location: `includes/mailer.php`

```php
$mail->isSMTP();
$mail->Host       = 'smtp.example.com';      // SMTP server
$mail->SMTPAuth   = true;
$mail->Username   = 'your-email@example.com';
$mail->Password   = 'your-email-password';
$mail->SMTPSecure = 'tls';                   // Or 'ssl'
$mail->Port       = 587;                     // Or 465
```

---

## 💻 Tech Stack

| Layer    | Technology         |
| -------- | ------------------ |
| Backend  | PHP                |
| Database | MySQL              |
| Frontend | HTML, Tailwind CSS |
| Email    | PHPMailer (SMTP)   |
| Sessions | PHP Sessions       |

---

## 🧪 Usage Instructions
1. 🛠️ Configure database and SMTP settings.
2. 📦 Import `users` table in MySQL (sample schema below).
3. ✅ Open `signup.php` to register a new user.
4. 🔓 Use `login.php` to log in.
5. 🧠 Session-protected `dashboard.php` will be accessible upon login.
6. 🔁 Forgot password link sends reset email with 1-hour token.

---

## 🧾 Database Schema (Example)

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    reset_token VARCHAR(100) DEFAULT NULL,
    token_expiry DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🛡️ Security Notes

* Passwords are hashed using `password_hash()` and verified with `password_verify()`.
* Tokens for reset are time-bound and stored in the database.
* Reset links expire after 1 hour and cannot be reused.

---

## 🤝 Credits

* PHPMailer – [https://github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer)
* Tailwind CSS – [https://tailwindcss.com](https://tailwindcss.com)

---

## 🧑‍💻 Author

Developed by: **Oyes Qurani**
Location: `signup-login-system/`


