<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNO NutriMap - About CNO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

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

        /* --- Main Content Styling --- */
        .hero-section {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7));
            background-size: cover;
            padding: 50px 0;
        }

        .main-content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: justify;
            width: 70%;
            max-width: 800px;
            margin-left: -15%;
        }

        .main-content h1 {
            font-size: 2.8rem;
            font-weight: bold;
            color: #333;
            margin: 0 0 10px 0;
        }

        .main-content .highlight {
            color: #00a0a0;
        }

        .main-content .location {
            font-size: 1.3rem;
            color: #666;
            margin: 0 0 20px 0;
        }

        .main-content .mission-statement {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
            text-align: justify;
        }

        .main-content .cta-button {
            display: inline-block;
            padding: 15px 40px;
            background-color: #00a0a0;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
            font-size: 1.1rem;
        }

        .main-content .cta-button:hover {
            background-color: #007f7f;
        }

        /* --- Contact Us Section Styling --- */
        .contact-section {
            background-color: #f8f8f8;
            padding: 60px 40px;
            text-align: center;
        }

        .contact-section h2 {
            font-size: 2.5rem;
            color: #00a0a0;
            margin-bottom: 40px;
        }

        .contact-details {
            display: flex;
            justify-content: center;
            gap: 50px;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }

        .contact-item {
            text-align: center;
            width: 250px;
        }

        .contact-item i {
            font-size: 3rem;
            color: #00a0a0;
            margin-bottom: 20px;
            display: block;
        }

        .contact-item strong {
            display: block;
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: #333;
        }

        .contact-item p {
            font-size: 1rem;
            color: #666;
            margin: 0;
        }

        .contact-item a {
            color: #00a0a0;
            text-decoration: none;
            font-weight: bold;
        }

        .contact-item a:hover {
            text-decoration: underline;
        }

        .social-media {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .social-media a {
            color: #00a0a0;
            font-size: 2.5rem;
            transition: color 0.3s;
        }

        .social-media a:hover {
            color: #007f7f;
        }

        /* --- Footer and Related Styling --- */
        .footer-links {
            width: 100%;
            padding: 20px 0;
            background-color: #333;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 25px;
        }

        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #fff;
        }

        footer {
            width: 100%;
            padding: 20px 0;
            margin-top: auto;
            background-color: #222;
            color: gray;
            font-size: 14px;
            text-align: center;
        }

        .footer-copyright {
            line-height: 1.5;
        }

        .footer-copyright span {
            display: block;
        }

        /* --- KMau.php Specific Styling --- */
        .about-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .about-content {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: justify;
            max-width: 900px;
            width: 100%;
        }

        .about-content h1 {
            font-size: 2.5rem;
            color: #00a0a0;
            margin-bottom: 20px;
            text-align: center;
        }

        .about-content p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
            margin-bottom: 30px;
            text-align: justify; /* Justified text */
        }

        .highlight-title {
            color: #00a0a0;
            text-align: center;
        }

        .about-card {
            background-color: #f8f8f8;
            border: 1px solid #eee;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .about-card h2 {
            font-size: 1.8rem;
            color: #333;
            margin-top: 0;
            border-bottom: 2px solid #00a0a0;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .about-card p {
            text-align: justify; /* Justified text within cards */
        }

        .about-card ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .about-card li {
            font-size: 1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 10px;
        }

        .about-card li::before {
            content: "•";
            color: #00a0a0;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        /* --- New active link styling --- */
        .active-page-btn {
            background-color: #00a0a0;
            color: #fff !important;
        }

        .active-page-btn:hover {
            background-color: #007f7f;
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="logo">
            <img src="../../img/CNO_Logo.jpg" alt="CNO NutriMap Logo">
            <span class="cno-color">CNO</span><span class="logo-space"></span><span>NutriMap</span>
        </div>
        <nav class="nav">
            <a href="../index.php" class="nav-link">Home</a>
            <a href="../pages/map_us/map.php" class="nav-link">Map</a>
            <div class="dropdown">
                <a href="../pages/about_us/about.php" class="nav-link dropdown-link active-page-btn">About CNO <svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg></a>
                <div class="dropdown-content">
                    <a href="../pages/about_us/about.php#profile">Profile <i class="fas fa-caret-right"></i></a>
                    <a href="../pages/about_us/about.php#history">History <i class="fas fa-caret-right"></i></a>
                    <a href="../pages/about_us/about.php#vision">Vision <i class="fas fa-caret-right"></i></a>
                    <a href="../pages/about_us/about.php#mission">Mission <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
            <a href="../pages/contact_us/contact.php" class="nav-link">Contact Us</a>
            <a href="../Frontend/login.php" class="nav-link login-btn">Login</a>
        </nav>
    </header>

    <div class="about-container">
        <div class="about-content">
            <h1 class="highlight-title">Our Journey and Commitment</h1>
            <p>
                The City Nutrition Office of El Salvador, Misamis Oriental, is dedicated to building a healthier and stronger community. Our journey began with the goal of addressing malnutrition and promoting sustainable health practices across all barangays. We believe that proper nutrition is the foundation of a productive and prosperous community.
            </p>
            <div class="about-card">
                <h2>Our Mission</h2>
                <p>
                    To serve as the primary advocate for a well-nourished community by implementing evidence-based nutritional programs, and by empowering families to take charge of their health through education, resources, and continuous support.
                </p>
            </div>
            <div class="about-card">
                <h2>Our Vision</h2>
                <p>
                    A malnutrition-free El Salvador City where every citizen, regardless of age or background, has access to adequate and nutritious food, enabling them to reach their full potential and contribute to the city's progress.
                </p>
            </div>
            <div class="about-card">
                <h2>Our Objectives</h2>
                <ul>
                    <li>Reduce the prevalence of malnutrition, stunting, and wasting among children.</li>
                    <li>Promote healthy eating habits and lifestyles through public awareness campaigns.</li>
                    <li>Collaborate with local government units and non-profit organizations to expand our reach.</li>
                    <li>Provide nutritional counseling and support to vulnerable households.</li>
                    <li>Establish community gardens and food security projects to ensure access to fresh produce.</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="footer-links">
        <a href="../privacy_act/terms.php">Terms</a>
        <a href="../privacy_act/privacy.php">Privacy Policy</a>
        <a href="../privacy_act/cookies.php">Cookies</a>
        <a href="../privacy_act/help.php">Help</a>
        <a href="../privacy_act/faqs.php">FAQs</a>
    </div>

    <footer>
        <div class="footer-copyright">
            <span>Copyright © 2025 CNO NutriMap Website, All Rights Reserved.</span>
            <span>Developed By NBSC ICS 4th Year Student</span>
        </div>
    </footer>

</body>
</html>
