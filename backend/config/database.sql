-- Create the database
CREATE DATABASE IF NOT EXISTS bizfusion;
USE bizfusion;

-- Users table with extended fields
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    user_type ENUM('startup', 'corporate') NOT NULL,
    company_name VARCHAR(100),
    industry VARCHAR(100),
    total_points INT DEFAULT 0,
    profile_completion INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

-- User details for startups
CREATE TABLE IF NOT EXISTS startup_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_size VARCHAR(50),
    founding_year INT,
    funding_stage VARCHAR(100),
    logo_url VARCHAR(255),
    website_url VARCHAR(255),
    description TEXT,
    tags VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- User details for corporates
CREATE TABLE IF NOT EXISTS corporate_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_size VARCHAR(50),
    founding_year INT,
    annual_revenue VARCHAR(100),
    logo_url VARCHAR(255),
    website_url VARCHAR(255),
    description TEXT,
    industry_focus VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Points log table
CREATE TABLE IF NOT EXISTS points_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    points INT NOT NULL,
    activity VARCHAR(255) NOT NULL,
    date_earned TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Innovation needs (posted by corporates)
CREATE TABLE IF NOT EXISTS innovation_needs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    corporate_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    categories VARCHAR(255),
    status ENUM('active', 'closed', 'pending') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (corporate_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Startup solutions (responses to innovation needs)
CREATE TABLE IF NOT EXISTS startup_solutions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    startup_id INT NOT NULL,
    need_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('submitted', 'reviewed', 'accepted', 'rejected') DEFAULT 'submitted',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (startup_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (need_id) REFERENCES innovation_needs(id) ON DELETE CASCADE
);

-- Matches and partnerships
CREATE TABLE IF NOT EXISTS partnerships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    startup_id INT NOT NULL,
    corporate_id INT NOT NULL,
    status ENUM('pending', 'active', 'completed', 'canceled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (startup_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (corporate_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Services table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Success stories table
CREATE TABLE IF NOT EXISTS success_stories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 