 
 <style>
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
 </style>
    <header class="header">
        <div class="logo">
            <span class="cno-color">CNO</span><span class="logo-space"></span><span>NutriMap</span>
        </div>
        <nav class="nav">
            <a href="index.php" class="nav-link home-btn">Home</a>
            <a href="map.php" class="nav-link">Map</a>
            <div class="dropdown">
                <a href="pages/about_us/about.php" class="nav-link dropdown-link">About CNO <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></a>
                <div class="dropdown-content">
                    <a href="pages/about_us/profile.php">Profile <i class="fas fa-caret-right"></i></a>
                    <a href="pages/about_us/history.php">History <i class="fas fa-caret-right"></i></a>
                    <a href="pages/about_us/vision.php">Vision <i class="fas fa-caret-right"></i></a>
                    <a href="pages/about_us/mission.php">Mission <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
            <a href="pages/contact_us/contact.php" class="nav-link">Contact Us</a>
            <a href="Frontend/login.php" class="nav-link login-btn">Login</a>
        </nav>
    </header>