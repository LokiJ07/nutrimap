<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNO NutriMap - About CNO</title>
    <link rel="icon" type="image/png" href="../../img/CNO_Logo.png">
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
   <!-- Header -->
  <header class="header flex justify-between items-center px-6 md:px-10 py-4 bg-white shadow relative">
  <!-- Logo -->
  <div class="flex items-center font-bold text-2xl text-gray-700">
    <img src="../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2">
    <span class="cno-color">CNO</span><span class="ml-2">NutriMap</span>
  </div>

  <!-- Desktop nav -->
  <nav class="hidden md:flex items-center space-x-6 font-semibold">
    <a href="../index.php" class="text-teal-600">Home</a>
    <a href="map.php" class="hover:text-teal-600">Map</a>
<!-- Dropdown Parent -->
<div class="relative">
  <!-- Toggle Button -->
  <button id="aboutBtn" class="flex items-center gap-1 font-semibold text-gray-700 hover:text-teal-600 cursor-pointer focus:outline-none">
    About CNO
    <svg class="w-4 h-4 transition-transform" id="aboutArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
      <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
    </svg>
  </button>

  <!-- Dropdown Menu -->
  <div id="aboutDropdown" class="absolute left-0 mt-2 w-40 bg-gray-100 shadow-lg rounded hidden z-50">
    <a href="pages/about_us/about.php" class="block px-4 py-2 hover:bg-gray-200">About</a>
    <a href="pages/about_us/profile.php" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
    <a href="pages/about_us/history.php" class="block px-4 py-2 hover:bg-gray-200">History</a>
    <a href="pages/about_us/vision.php" class="block px-4 py-2 hover:bg-gray-200">Vision</a>
    <a href="pages/about_us/mission.php" class="block px-4 py-2 hover:bg-gray-200">Mission</a>
  </div>
</div>

    <a href="pages/contact_us/contact.php" class="hover:text-teal-600">Contact Us</a>
    <a href="../login.php" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Login</a>
  </nav>

  <!-- Mobile Burger -->
  <div class="md:hidden flex items-center">
    <button id="burgerBtn" class="text-gray-700 focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>

 <!-- Mobile menu -->
<div id="mobileMenu" class="hidden absolute top-full left-0 w-full bg-white shadow-md z-20 flex flex-col">
  <a href="../index.php" class="px-6 py-3 border-b hover:bg-gray-100">Home</a>
  <a href="map.php" class="px-6 py-3 border-b hover:bg-gray-100">Map</a>

  <!-- Mobile About CNO Dropdown -->
  <div class="flex flex-col">
    <button id="mobileAboutBtn" class="flex justify-between items-center px-6 py-3 border-b hover:bg-gray-100 focus:outline-none">
      About CNO
      <svg id="mobileAboutArrow" class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
      </svg>
    </button>
    <div id="mobileAboutDropdown" class="hidden flex flex-col bg-gray-50">
      <a href="pages/about_us/about.php" class="px-8 py-2 hover:bg-gray-200">About</a>
      <a href="pages/about_us/profile.php" class="px-8 py-2 hover:bg-gray-200">Profile</a>
      <a href="pages/about_us/history.php" class="px-8 py-2 hover:bg-gray-200">History</a>
      <a href="pages/about_us/vision.php" class="px-8 py-2 hover:bg-gray-200">Vision</a>
      <a href="pages/about_us/mission.php" class="px-8 py-2 hover:bg-gray-200">Mission</a>
    </div>
  </div>

  <a href="pages/contact_us/contact.php" class="px-6 py-3 border-b hover:bg-gray-100">Contact Us</a>
  <a href="../login.php" class="px-6 py-3 hover:bg-gray-100">Login</a>
</div>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const burgerBtn = document.getElementById('burgerBtn');
  const mobileMenu = document.getElementById('mobileMenu');

  burgerBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });

  // Mobile About CNO Dropdown
  const mobileAboutBtn = document.getElementById('mobileAboutBtn');
  const mobileAboutDropdown = document.getElementById('mobileAboutDropdown');
  const mobileAboutArrow = document.getElementById('mobileAboutArrow');

  mobileAboutBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    mobileAboutDropdown.classList.toggle('hidden');
    mobileAboutArrow.classList.toggle('rotate-180');
  });

  // Optional: close dropdown if clicked outside mobile menu
  document.addEventListener('click', (e) => {
    if (!mobileMenu.contains(e.target)) {
      mobileAboutDropdown.classList.add('hidden');
      mobileAboutArrow.classList.remove('rotate-180');
    }
  });
});
// Dropdown functionality for About CNO
 const aboutBtn = document.getElementById('aboutBtn');
  const aboutDropdown = document.getElementById('aboutDropdown');
  const aboutArrow = document.getElementById('aboutArrow');

  aboutBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // prevent document click
    aboutDropdown.classList.toggle('hidden');
    aboutArrow.classList.toggle('rotate-180');
  });

  // Close dropdown if clicked outside
  document.addEventListener('click', () => {
    if(!aboutDropdown.classList.contains('hidden')) {
      aboutDropdown.classList.add('hidden');
      aboutArrow.classList.remove('rotate-180');
    }
  });
</script>

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
   <!-- FOOTER -->
  <footer class="bg-gray-800 text-gray-300 py-10 mt-10">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-5 gap-8">
      <!-- Logo -->
      <div class="md:col-span-2">
        <div class="flex items-center mb-4">
          <img src="../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg" />
          <span class="text-teal-500 text-xl font-bold">CNO</span>
          <span class="text-white text-xl font-bold ml-1">NutriMap</span>
        </div>
        <p class="text-sm">A tool to visualize health and nutrition data for children in El Salvador City.</p>
      </div>

      <!-- About -->
      <div>
        <h3 class="text-white font-semibold text-lg mb-3">About Us</h3>
        <ul class="space-y-2">
          <li><a href="pages/about_us/mission.php" class="hover:text-teal-400">Our Mission</a></li>
          <li><a href="pages/about_us/vision.php" class="hover:text-teal-400">Our Vision</a></li>
          <li><a href="pages/about_us/history.php" class="hover:text-teal-400">History</a></li>
        </ul>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 class="text-white font-semibold text-lg mb-3">Quick Links</h3>
        <ul class="space-y-2">
          <li><a href="map.php" class="hover:text-teal-400">Map</a></li>
          <li><a href="pages/contact_us/contact.php" class="hover:text-teal-400">Contact Us</a></li>
        </ul>
      </div>

      <!-- Legal -->
      <div>
        <h3 class="text-white font-semibold text-lg mb-3">Legal & Support</h3>
        <ul class="space-y-2">
          <li><a href="pages/legal_and_support/terms.php" class="hover:text-teal-400">Terms of Use</a></li>
          <li><a href="pages/legal_and_support/privacy.php" class="hover:text-teal-400">Privacy Policy</a></li>
          <li><a href="pages/legal_and_support/cookies.php" class="hover:text-teal-400">Cookies</a></li>
          <li><a href="pages/help_and_support/help.php" class="hover:text-teal-400">Help</a></li>
          <li><a href="pages/help_and_support/faqs.php" class="hover:text-teal-400">FAQs</a></li>
        </ul>
      </div>
    </div>

    <div class="border-t border-gray-700 mt-10 pt-6 text-center text-gray-400 text-sm">
      <p>Copyright &copy; 2025 CNO NutriMap. All Rights Reserved.<br>Developed By NBSC ICS 4th Year Student.</p>
    </div>
  </footer>

</body>
</html>
