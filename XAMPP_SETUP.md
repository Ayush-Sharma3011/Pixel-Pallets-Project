# Biz-Fusion XAMPP Setup Guide

This guide will help you set up and run the Biz-Fusion project using XAMPP on your local machine.

## Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) installed on your computer
- A web browser (Chrome, Firefox, Edge, etc.)

## Setup Instructions

### Step 1: Copy Project Files

1. Extract or clone the project files into the XAMPP's `htdocs` directory.
   - Windows: `C:/xampp/htdocs/Biz-Fusion`
   - macOS: `/Applications/XAMPP/htdocs/Biz-Fusion`
   - Linux: `/opt/lampp/htdocs/Biz-Fusion`

### Step 2: Start XAMPP Services

1. Open the XAMPP Control Panel.
2. Start the Apache and MySQL services by clicking the "Start" buttons next to them.
3. Make sure both services are running (they should be highlighted in green).

### Step 3: Database Setup

You have two options to set up the database:

#### Option 1: Automatic Setup (Recommended)

1. Open your web browser and go to: `http://localhost/Biz-Fusion/setup.php`
2. The script will automatically create the database and all required tables.
3. Once completed, you'll be redirected to the homepage.

#### Option 2: Manual Setup

1. Open your web browser and go to: `http://localhost/phpmyadmin`
2. Click on "SQL" in the top navigation menu.
3. Copy the contents of `backend/config/database.sql` and paste it into the SQL query window.
4. Click "Go" to execute the SQL queries, which will create the database and tables.

### Step 4: Access the Website

1. Open your web browser and go to: `http://localhost/Biz-Fusion/index.php`
2. The Biz-Fusion website should now be loaded and functional.

## Test Accounts

For testing purposes, you can use these accounts after setting up the database:

1. Login to the system using:
   - Username: `admin`
   - Password: `password123`

Alternatively, you can register a new account by clicking on "Register as Startup" or "Register as Corporate" on the login page.

## Project Structure

- `index.php` - Main entry point and home page
- `login.php` - User login page
- `backend/` - Contains backend code and database operations
  - `config/` - Database configuration and setup files
  - `auth/` - Authentication related files
- `dashboard/` - User dashboards for startups and corporates
- `public/` - Public assets (images, CSS, JavaScript)
- `lib/` - Library files and components

## Troubleshooting

### Database Connection Issues

If you encounter database connection issues:

1. Check if MySQL service is running in XAMPP Control Panel.
2. Verify the database credentials in `backend/config/database.php`.
3. Make sure the database 'bizfusion' exists in phpMyAdmin.

### Apache Not Starting

If Apache fails to start:

1. Check if another service is using port 80 or 443.
2. Try changing Apache ports in XAMPP Control Panel > Apache > Config > httpd.conf.

### PHP Errors

If you see PHP errors:

1. Check if the required PHP extensions are enabled in XAMPP.
2. Look at the Apache error logs in XAMPP Control Panel > Apache > Logs.

## Support

If you need further assistance, please contact the development team or create an issue in the project repository.

Happy connecting with Biz-Fusion! 