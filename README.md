# Biz-Fusion - Startup & Corporate Connection Platform with Gamification

Biz-Fusion is a web platform that connects innovative startups with established corporations for mutual growth and success. The platform includes a points-based gamification system to enhance user engagement.

## Project Structure

```
biz-fusion/
│
├── index.php                # Homepage
├── about.php                # About page
├── services.php             # Services page
├── success-stories.php      # Success stories page
├── contact.php              # Contact page
│
├── lib/                     # Core functionality
│   ├── db/                  # Database related files
│   │   ├── config.php       # Database connection and constants
│   │   └── db_setup.php     # Database tables setup
│   │
│   ├── auth/                # Authentication related files
│   │   ├── login.php        # Login page
│   │   ├── login-process.php # Login processing
│   │   ├── register-process.php # Registration processing
│   │   ├── update-profile.php # Profile updates
│   │   ├── startup-register.php # Startup registration
│   │   └── corporate-register.php # Corporate registration
│   │
│   ├── points/              # Points system
│   │   ├── PointsSystem.php # Points system class
│   │   └── clear-message.php # Clear points notification
│   │
│   ├── rewards/             # Rewards system
│   │   ├── index.php        # Rewards center
│   │   ├── RewardsSystem.php # Rewards system class
│   │   └── redeem-reward.php # Reward redemption
│   │
│   └── includes/            # Reusable components
│       ├── header.php       # Site header
│       ├── footer.php       # Site footer
│       └── points_display.php # Points notification display
│
├── dashboard/               # User dashboards
│   ├── startup.php          # Startup dashboard
│   └── corporate.php        # Corporate dashboard
│
└── public/                  # Public assets
    ├── css/                 # CSS files
    ├── js/                  # JavaScript files
    └── images/              # Image files
```

## Features

- **User Authentication**: Secure login and registration system with separate flows for startups and corporates.
- **Points System**: Gamification through a points-based reward system.
- **Rewards Center**: Users can redeem points for various rewards.
- **Dashboards**: Tailored dashboards for startups and corporates.
- **Responsive Design**: Modern UI built with Tailwind CSS for all device sizes.

## Points System

Users can earn points through various activities:

- Daily login
- Registration
- Profile completion
- Connecting with matches
- Posting innovation needs (corporates)
- Submitting solutions (startups)
- Forming successful partnerships

## Rewards System

Users can redeem their earned points for rewards like:

- Premium profile badges
- Featured listings
- Priority matching
- Consultations
- VIP event access

## Installation

1. Clone the repository:
```
git clone https://github.com/yourusername/biz-fusion.git
```

2. Configure your web server (Apache/Nginx) to serve the project directory.

3. Import the database:
   - Create a MySQL database
   - Configure the database connection in `lib/db/config.php`
   - Run the database setup script by visiting `example.com/lib/db/db_setup.php`

4. Make sure the following directories are writable:
   - public/uploads/

## Dependencies

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Tailwind CSS (loaded via CDN)

## Credits

- Developed by [Your Name]
- Logo and branding assets by [Designer Name]
- Icons from [Heroicons](https://heroicons.com/)
