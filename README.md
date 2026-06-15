# Lamico Group Website
## Deployment Guide for Truehost WebStarter (cPanel)

---

## FOLDER STRUCTURE
```
lamico/
├── index.php               ← Homepage
├── .htaccess               ← Security & performance rules
├── assets/
│   ├── css/style.css       ← All frontend styles
│   ├── js/main.js          ← All frontend JavaScript
│   └── images/
│       ├── logo.png        ← ⚠️ UPLOAD YOUR LOGO HERE
│       ├── about-photo.jpg ← Team / office photo
│       ├── hero-pattern.svg
│       ├── og-image.jpg    ← Social share image (1200×630)
│       ├── service-construction.jpg
│       ├── service-media.jpg
│       ├── service-ict.jpg
│       ├── service-commerce.jpg
│       └── gallery/        ← Admin uploads go here automatically
├── pages/
│   ├── about.php
│   ├── services.php
│   ├── gallery.php
│   ├── contact.php
│   └── booking.php
├── includes/
│   ├── header.php          ← Shared nav
│   ├── footer.php          ← Shared footer
│   ├── db.php              ← DB credentials ⚠️
│   ├── send-mail.php       ← Contact form handler
│   ├── booking.php         ← Booking form handler
│   └── setup.sql           ← Run this ONCE in phpMyAdmin
└── admin/
    ├── index.php           ← Admin login
    ├── dashboard.php       ← Overview
    ├── services.php        ← Manage services
    ├── gallery.php         ← Upload/manage images
    ├── testimonials.php    ← Manage testimonials
    ├── bookings.php        ← View/manage bookings
    ├── contacts.php        ← Read contact messages
    ├── auth.php            ← Password config ⚠️
    └── admin.css           ← Admin styles
```

---

## STEP-BY-STEP DEPLOYMENT

### 1. Create MySQL Database in cPanel
1. Log into cPanel → **MySQL Databases**
2. Create a new database (e.g. `lamicogrp_db`)
3. Create a new user (e.g. `lamicogrp_user`) with a strong password
4. Add the user to the database with **ALL PRIVILEGES**
5. Note down: database name, username, password

### 2. Run the Database Setup
1. Go to cPanel → **phpMyAdmin**
2. Select your new database
3. Click the **SQL** tab
4. Copy and paste the entire contents of `includes/setup.sql`
5. Click **Go** to run it

### 3. Edit Database Credentials
Open `includes/db.php` and update:
```php
define('DB_USER', 'lamicogrp_user');    // your DB username
define('DB_PASS', 'your_password');      // your DB password
define('DB_NAME', 'lamicogrp_db');      // your DB name
```

### 4. Set Admin Password
Open `admin/auth.php` and change:
```php
define('ADMIN_PASSWORD', 'your_strong_password_here');
```
Use a strong password — at least 12 characters with letters, numbers, symbols.

### 5. Update Contact Email
In `includes/send-mail.php` and `includes/booking.php`, change:
```php
$to = 'info@lamicogroup.org';  // ← your real email
```

### 6. Upload Logo
- Replace `assets/images/logo.png` with the Lamico Group logo
- Recommended: PNG with transparent background, ~200px wide

### 7. Upload All Files to cPanel
1. Go to cPanel → **File Manager** → `public_html`
2. Upload the entire `lamico/` folder contents directly into `public_html`
   (OR into a subfolder if this isn't the main domain)
3. Make sure `assets/images/gallery/` folder exists and is **writable** (chmod 755)

### 8. Set Folder Permissions
In File Manager, right-click `assets/images/gallery/` → **Permissions** → set to `755`

---

## ACCESSING YOUR SITE

| Page | URL |
|------|-----|
| Homepage | `https://lamicogroup.org/` |
| Our Business | `https://lamicogroup.org/pages/services.php` |
| Gallery | `https://lamicogroup.org/pages/gallery.php` |
| About | `https://lamicogroup.org/pages/about.php` |
| Contact | `https://lamicogroup.org/pages/contact.php` |
| Booking | `https://lamicogroup.org/pages/booking.php` |
| **Admin Login** | `https://lamicogroup.org/admin/` |

---

## ADMIN PANEL GUIDE

### Login
Go to `yourdomain.com/admin/` and enter your admin password.

### Managing Services
- **Add** a new business division with name, icon (emoji), short & full description
- **Edit** existing services (updates live on the site instantly)
- **Toggle** active/inactive to show or hide from the website
- **Order** services by changing the display order number

### Managing Gallery
- **Upload** images (JPG/PNG/WEBP up to 5MB)
- Add a **caption** and **category** for filtering on the gallery page
- **Link** images to a specific service division
- **Toggle** visibility or **delete** images

### Managing Testimonials
- **Add** client testimonials with name, role, company, star rating
- **Link** to a specific service
- **Toggle** visibility or **edit** at any time

### Managing Bookings
- View all booking requests with **status filter** (Pending/Confirmed/Cancelled)
- **Update status** with the dropdown (changes instantly)
- **Reply via email** directly from the bookings page

### Reading Contact Messages
- Messages auto-**mark as read** when you open them
- **Reply directly** via email with one click
- **Mark all read** button to clear unread count

---

## ADDING YOUR IMAGES

Add these images to `assets/images/`:
- `logo.png` — Company logo (transparent PNG)
- `about-photo.jpg` — Office or team photo (600×450px recommended)
- `og-image.jpg` — Social share preview image (1200×630px)
- `service-construction.jpg` — Construction division image
- `service-media.jpg` — Media division image
- `service-ict.jpg` — ICT division image
- `service-commerce.jpg` — Commerce division image

Gallery images are managed through the admin panel.

---

## UPDATING CONTACT INFO

To update phone number, address, or email shown on the site, edit `includes/footer.php` and `pages/contact.php` directly in File Manager or a code editor.

---

## SUPPORT

If you encounter issues:
1. Check cPanel **Error Logs** (Metrics → Errors)
2. Verify DB credentials in `includes/db.php`
3. Ensure `assets/images/gallery/` has write permissions (755)
4. Make sure PHP 7.4+ is active (cPanel → MultiPHP Manager)
