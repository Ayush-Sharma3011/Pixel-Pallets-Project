# BizFusion Website Setup Guide

This guide will help you set up the BizFusion website on your local XAMPP server.

## Prerequisites

1. XAMPP installed (with Apache and MySQL)
2. Basic knowledge of PHP and MySQL

## Installation Steps

### 1. Clone/Download the Project

Place all project files in your XAMPP's htdocs directory:
```
C:\xampp\htdocs\bizfusion\
```

### 2. Start Apache and MySQL Services

Open XAMPP Control Panel and start both Apache and MySQL services.

### 3. Set Up the Database

There are two ways to set up the database:

#### Option 1: Using phpMyAdmin
1. Open your browser and navigate to: http://localhost/phpmyadmin
2. Create a new database named `bizfusion`
3. Select the newly created database
4. Go to the "Import" tab
5. Click "Choose File" and select the `backend/config/database.sql` file from the project
6. Click "Go" to import the database structure

#### Option 2: Using MySQL Console
1. Open XAMPP Control Panel
2. Click "Shell" to open the command line
3. Navigate to the project directory
4. Run the following command:
```
mysql -u root -p < backend/config/database.sql
```

### 4. Configure the Website

1. Open the file `backend/config/config.php`
2. Update the configuration settings if needed (default settings should work for a standard XAMPP installation)

### 5. Test the Installation

1. Open your browser and navigate to: http://localhost/bizfusion/test.php
2. This page will test your PHP environment and database connection
3. If everything is green/successful, your setup is complete

### 6. Access the Website

- Main Website: http://localhost/bizfusion/
- Login Page: http://localhost/bizfusion/login.php
- Register: http://localhost/bizfusion/backend/auth/register.php

## Default Admin Account

The first account you register will automatically be granted admin privileges. You can use it to access the admin dashboard.

## File Structure

```
bizfusion/
├── assets/
│   └── css/
│       └── style.css
├── backend/
│   ├── auth/
│   │   ├── login.php
│   │   ├── logout.php
│   │   └── register.php
│   ├── config/
│   │   ├── config.php
│   │   ├── database.php
│   │   └── database.sql
│   ├── dashboard/
│   │   ├── admin.php
│   │   ├── index.php
│   │   ├── profile.php
│   │   └── users.php
│   ├── includes/
│   │   └── Session.php
│   └── models/
│       ├── Contact.php
│       └── User.php
├── index.html
├── login.php
├── about.html
├── contact.html
├── services.html
├── success-stories.html
└── test.php
```

## Troubleshooting

1. **Database Connection Error**
   - Verify MySQL is running
   - Check database credentials in `backend/config/config.php`
   - Make sure the `bizfusion` database exists

2. **Page Not Found Errors**
   - Ensure Apache is running
   - Check that all files are in the correct directories
   - Verify URL paths in your browser

3. **PHP Errors**
   - Check XAMPP's PHP version (7.0+ required)
   - Verify required PHP extensions are enabled (mysqli, pdo, session)

4. **Session Issues**
   - Clear browser cookies
   - Restart Apache service

## Need Help?

If you encounter any issues during setup, please check the error messages in:
- XAMPP Error Logs
- PHP Error Logs
- MySQL Error Logs

These logs can be accessed from the XAMPP Control Panel. 