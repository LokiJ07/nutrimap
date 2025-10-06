<?php
// home.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CNO NutriMap | Home</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    /* Header */
      .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.logo {
    display: flex;
    align-items: center;
    font-weight: bold;
    font-size: 24px;
    color: #333;
}

.logo img {
    height: 40px;
    margin-right: 10px;
}

.logo .cno-color {
    color: #00a0a0;
}

.logo-space {
    margin-right: 8px;
}

.nav {
    display: flex;
    gap: 30px;
    align-items: center;
}

.nav-link {
    text-decoration: none;
    color: #666;
    font-size: 16px;
    font-weight: 600;
    padding: 8px 20px;
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.nav-link:hover {
    color: #000;
}

.home-btn {
    background-color: #fff;
    color: #00a0a0 !important;
}

.login-btn {
    background-color: #00a0a0;
    color: #fff !important;
    border: 1px solid #00a0a0;
    padding: 10px 25px;
}

.login-btn:hover {
    background-color: #007f7f;
}

/* --- Dropdown Styling --- */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-link {
    display: flex;
    align-items: center;
    gap: 5px;
}

.dropdown-arrow {
    transition: transform 0.3s ease;
    width: 16px;
    height: 16px;
    fill: currentColor;
}

.dropdown:hover .dropdown-arrow {
    transform: rotate(180deg);
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 5px;
    overflow: hidden;
    left: 0;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-weight: normal;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

    /* Main */
    main {
      position: relative;
      background-image: url('img/bg_img.jpg');
      background-size: cover;
      background-position: center;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 120px 50px;
    }
    main .overlay {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.45);
    }
    main .content {
      position: relative;
      z-index: 1;
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1100px;
      width: 100%;
    }
    .left {
      flex: 1;
    }
    .left h1 {
      font-size: 50px;
      font-weight: bold;
      line-height: 1;
    }
    .left h1 span {
      color: #00B2B2;
    }
    .left p {
      margin-top: 10px;
      font-size: 18px;
    }
    .left a.button {
      margin-top: 20px;
      display: inline-block;
      background: #00B2B2;
      color: white;
      font-weight: bold;
      padding: 12px 24px;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.3s ease;
    }
    .left a.button:hover {
      background: #009090;
    }
    .right-panel {
      flex: 1;
      text-align: center;
    }
    .right-panel img {
      max-width: 500px;
      height: auto;
    }

        /* Footer Styles */
    .footer {
  background-color: #1f2937; /* gray-800 */
  color: #d1d5db; /* gray-300 */
  padding: 2.5rem 0;
  margin-top: auto;
  position: relative;
  z-index: 10;
}

.footer-container {
  max-width: 72rem;
  margin: 0 auto;
  padding: 0 1rem;
}

.footer-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 768px) {
  .footer-grid {
    grid-template-columns: repeat(5, 1fr);
  }
  .footer-logo {
    grid-column: span 2 / span 2;
  }
}

.footer-logo {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.logo-text {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.logo-primary {
  font-size: 1.5rem;
  font-weight: bold;
  color: #00a0a0;
}

.logo-secondary {
  font-size: 1.5rem;
  font-weight: bold;
  margin-left: 0.25rem;
  color: #fff;
}

.footer-desc {
  font-size: 0.875rem;
}

.footer-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #fff;
  margin-bottom: 1rem;
}

.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 0.5rem;
}

.footer-links a {
  color: #d1d5db;
  text-decoration: none;
  transition: color 0.2s;
}

.footer-links a:hover {
  color: #00a0a0;
}

.footer-bottom {
  margin-top: 2rem;
  border-top: 1px solid #374151; /* gray-700 */
  padding-top: 2rem;
  text-align: center;
}

.footer-bottom p {
  color: #9ca3af; /* gray-400 */
  font-size: 0.875rem;
}
  </style>
</head>
<body>

  <!-- HEADER -->
    <header class="header">
        <div class="logo">
            <span class="cno-color">CNO</span><span class="logo-space"></span><span>NutriMap</span>
        </div>
        <nav class="nav">
            <a href="../index.php" class="nav-link home-btn">Home</a>
            <a href="landing_page/map.php" class="nav-link">Map</a>
            <div class="dropdown">
                <a href="landing_page/pages/about_us/about.php" class="nav-link dropdown-link">About CNO <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></a>
                <div class="dropdown-content">
                    <a href="landing_page/pages/about_us/profile.php">Profile <i class="fas fa-caret-right"></i></a>
                    <a href="landing_page/pages/about_us/history.php">History <i class="fas fa-caret-right"></i></a>
                    <a href="landing_page/pages/about_us/vision.php">Vision <i class="fas fa-caret-right"></i></a>
                    <a href="landing_page/pages/about_us/mission.php">Mission <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
            <a href="landing_page/pages/contact_us/contact.php" class="nav-link">Contact Us</a>
            <a href="../login.php" class="nav-link login-btn">Login</a>
        </nav>
    </header>

  <!-- Main -->
  <main>
    <div class="overlay"></div>
    <div class="content">
      <div class="left">
        <h1>Welcome to <br><span>City Nutrition Office</span></h1>
        <p>El Salvador, Misamis Oriental</p>
        <a href="orgchart.php" class="button">Know More About Us!</a>
      </div>
      <div class="right-panel">
        <img src="img/nutritional.png" alt="Nutrition Illustration">
      </div>
    </div>
  </main>
  <!-- Footer -->
   <footer class="footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Logo and Description -->
            <div class="footer-logo">
                <div class="logo-text">
                    <span class="logo-primary">CNO</span>
                    <span class="logo-secondary">NutriMap</span>
                </div>
                <p class="footer-desc">
                    A tool to visualize health and nutrition data for children in El Salvador City.
                </p>
            </div>
            <!-- Links Column 1 -->
            <div>
                <h3 class="footer-title">About Us</h3>
                <ul class="footer-links">
                    <li><a href="pages/about_us/mission.php">Our Mission</a></li>
                    <li><a href="pages/about_us/vision.php">Our Vision</a></li>
                    <li><a href="pages/about_us/history.php">History</a></li>
                </ul>
            </div>
            <!-- Links Column 2 -->
            <div>
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="pages/map_us/map.php">Map</a></li>
                    <li><a href="pages/contact_us/get_in_touch.php">Contact Us</a></li>
                    <li><a href="pages/contact_us/downloadable_form.php">Downloadable Forms</a></li>
                </ul>
            </div>
            <!-- Legal & Support Column -->
            <div>
                <h3 class="footer-title">Legal & Support</h3>
                <ul class="footer-links">
                    <li><a href="pages/legal_and_support/terms_of_use.php">Terms of Use</a></li>
                    <li><a href="pages/legal_and_support/privacy_policy.php">Privacy Policy</a></li>
                    <li><a href="pages/legal_and_support/cookies.php">Cookies</a></li>
                    <li><a href="pages/help_and_support/help.php">Help</a></li>
                    <li><a href="pages/help_and_support/faqs.php">FAQs</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright&copy; 2025 CNO NutriMap All Rights Reserved. Developed By NBSC ICS 4th Year Student.</p>
        </div>
    </div>
</footer>
</body>
</html>
