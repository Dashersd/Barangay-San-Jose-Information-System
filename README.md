# Barangay San Jose Web-Based Information System

![Barangay San Jose Logo](assets/images/San%20Jose%20Logo%202.png)

A modern, responsive, and interactive web-based platform designed for **Barangay San Jose** (Lapuyan, Zamboanga del Sur). This system serves as a centralized hub for community engagement, public information dissemination, and accessible barangay services.

---

## 🌟 Key Features

* **Modern & Dynamic UI/UX**: Built with a clean aesthetic, vibrant typography, and seamless scroll animations for a premium user experience.
* **Comprehensive Information Pages**:
  * **About Us**: History, Mission, and Vision.
  * **Barangay Officials**: Directories for both regular Barangay Officials and Sangguniang Kabataan (SK) leaders.
* **Interactive Spot Map**: Explore the geographical layout of the barangay with interactive toggles to view the 4 Puroks and an overview map.
* **Services Directory**: Information on document issuance (Clearance, Indigency), health center services, peace & order, and community programs.
* **Announcements & Gallery**: Stay updated with the latest community events, general assemblies, medical missions, and view a visual history in the gallery.
* **Contact Integration**: Easy-to-use forms and directories for residents to reach out to the barangay office.
* **Admin Dashboard**: A secure backend portal for authorized personnel to manage content, services, and resident data.

---

## 🛠️ Technology Stack

* **Frontend Structure**: HTML5, PHP (for routing and dynamic data inclusion)
* **Styling**: Custom CSS3 utilizing CSS variables for a consistent design system (colors, spacing, shadows, and border radii).
* **Interactivity**: Vanilla JavaScript (ES6)
* **Animations**: [AOS (Animate On Scroll)](https://michalsnik.github.io/aos/) library for staggered entrance animations.
* **Typography**: Google Fonts (Inter)
* **Icons**: Inline SVG / Feather Icons

---

## 📂 Project Structure

```text
Barangay San Jose Web Based Information System/
├── index.php             # Main Landing Page
├── about.php             # Barangay History & Overview
├── vision.php            # Vision Statement
├── mission.php           # Mission Statement
├── officials.php         # Barangay Officials Directory
├── skofficials.php       # SK Officials Directory
├── spotmap.php           # Interactive Barangay Spot Map
├── services.php          # Public Services Information
├── announcement.php      # Latest News and Notices
├── gallery.php           # Event Photo Gallery
├── contact.php           # Contact Information & Inquiry Form
│
├── Admin/                # Secure Backend Panel
│   ├── login.php         # Admin Authentication
│   ├── dashboard.php     # Admin Dashboard Interface
│   └── service.php       # Service Management
│
└── assets/               # Static Resources
    ├── css/              # Stylesheets (style.css, gallery.css, spotmap.css, etc.)
    ├── js/               # JavaScript (main.js, spotmap.js)
    └── images/           # Logos, Maps, Official Portraits, and Gallery Images
```

---

## 🚀 Getting Started

1. **Prerequisites**: Since this project utilizes PHP, you will need a local server environment such as [XAMPP](https://www.apachefriends.org/index.html), WAMP, or MAMP.
2. **Installation**:
   * Clone or place this project folder into your server's root directory (e.g., `C:\xampp\htdocs\`).
3. **Running the Application**:
   * Start Apache and MySQL from your XAMPP Control Panel.
   * Open your web browser and navigate to: `http://localhost/Barangay San Jose Web Based Information System/index.php`

---

## 🎨 Design Philosophy

This project strictly adheres to modern web design principles:
* **Consistency**: Unified footers, headers, buttons, and color schemes across all pages.
* **Responsiveness**: Fully fluid layouts that adapt gracefully to mobile devices, tablets, and large desktop screens.
* **Performance**: Optimized asset loading with lightweight SVG icons and conditional script execution.

---

*Bayanihan &bull; Serbisyong Totoo*
