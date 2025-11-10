<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNO NutriMap Mission</title>
    <link rel="icon" type="image/png" href="../../../img/CNO_Logo.png">
    <!-- Use Tailwind CSS for modern styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="../../css/image/CNO_Logo.png">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
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
            background-color: #f0f2f5;
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
            top: 100%;
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
        .dropdown-link.active,
        .dropdown-content a.active {
            background-color: #e0f0f0;
            color: #008c8c;
            font-weight: 700;
        }
        .main-content {
            padding: 40px;
        }
        .content-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: center;
            max-width: 800px;
            margin: 20px auto;
        }
        .content-card h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #00a0a0;
            margin-bottom: 20px;
        }
        .content-card p {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.8;
            text-align: justify;
        }
        .footer-links {
            width: 100%;
            padding: 10px 0;
            background-color: #ffffff;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 30px;
            font-weight: bold;
        }
        .footer-links a {
            color: #000;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: #00a0a0;
        }
        footer {
            width: 100%;
            padding: 10px 0;
            margin-top: auto;
            background-color: #00a0a0;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
        .footer-copyright {
            line-height: 1.5;
        }
        .footer-copyright span {
            display: block;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Header -->
  <!-- Header -->
  <header class="header flex justify-between items-center px-6 md:px-10 py-4 bg-white shadow relative">
  <!-- Logo -->
  <div class="flex items-center font-bold text-2xl text-gray-700">
    <img src="../../../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2">
    <span class="cno-color">CNO</span><span class="ml-2">NutriMap</span>
  </div>

  <!-- Desktop nav -->
  <nav class="hidden md:flex items-center space-x-6 font-semibold">
    <a href="../../../index.php" class="hover:text-teal-600">Home</a>
    <a href="../../map.php" class="hover:text-teal-600">Map</a>
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
    <a href="../about_us/about.php" class="block px-4 py-2 hover:bg-gray-200">About</a>
    <a href="../about_us/profile.php" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
    <a href="../about_us/history.php" class="block px-4 py-2 hover:bg-gray-200">History</a>
    <a href="../about_us/vision.php" class="block px-4 py-2 hover:bg-gray-200">Vision</a>
    <a href="../about_us/mission.php" class="block px-4 py-2 hover:bg-gray-200">Mission</a>
  </div>
</div>

    <a href="contact.php" class="text-teal-600">Contact Us</a>
    <a href="../../../login.php" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Login</a>
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
  <a href="../../../index.php" class="px-6 py-3 border-b hover:bg-gray-100">Home</a>
  <a href="../../map.php" class="px-6 py-3 border-b hover:bg-gray-100">Map</a>

  <!-- Mobile About CNO Dropdown -->
  <div class="flex flex-col">
    <button id="mobileAboutBtn" class="flex justify-between items-center px-6 py-3 border-b hover:bg-gray-100 focus:outline-none">
      About CNO
      <svg id="mobileAboutArrow" class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
      </svg>
    </button>
    <div id="mobileAboutDropdown" class="hidden flex flex-col bg-gray-50">
      <a href="../about_us/about.php" class="px-8 py-2 hover:bg-gray-200">About</a>
      <a href="../about_us/profile.php" class="px-8 py-2 hover:bg-gray-200">Profile</a>
      <a href="../about_us/history.php" class="px-8 py-2 hover:bg-gray-200">History</a>
      <a href="../about_us/vision.php" class="px-8 py-2 hover:bg-gray-200">Vision</a>
      <a href="../about_us/mission.php" class="px-8 py-2 hover:bg-gray-200">Mission</a>
    </div>
  </div>

  <a href="contact.php" class="px-6 py-3 border-b hover:bg-gray-100">Contact Us</a>
  <a href="../../../login.php" class="px-6 py-3 hover:bg-gray-100">Login</a>
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

    <!-- Main Content -->
    <main class="main-content flex-grow flex flex-col items-center p-5 lg:p-10 text-justify">
        <h1 class="text-3xl lg:text-4xl font-bold mb-8 text-gray-800 text-center">Our Mission</h1>
        <div class="content-card">
            <p>
                Our mission is to proactively implement sustainable nutrition programs and policies that empower individuals and families to achieve optimal health. We are committed to collaborating with communities, stakeholders, and government agencies to ensure food security, promote healthy eating habits, and reduce the prevalence of malnutrition across all sectors of the city.
            </p>
        </div>
    </main>

    <!-- Footer -->
    <div class="bg-gray-100 text-center p-4">
        <div class="flex justify-center space-x-6 text-sm font-semibold mb-2">
            <a href="privacy_act/terms.php" class="hover:underline text-gray-600">Terms</a>
            <a href="privacy_act/privacy.php" class="hover:underline text-gray-600">Privacy Policy</a>
            <a href="privacy_act/cookies.php" class="hover:underline text-gray-600">Cookies</a>
            <a href="privacy_act/help.php" class="hover:underline text-gray-600">Help</a>
            <a href="privacy_act/faqs.php" class="hover:underline text-gray-600">FAQs</a>
        </div>
        <p class="text-gray-500 text-xs">
            <span>Copyright © 2025 CNO NutriMap Website, All Rights Reserved.</span>
            <br>
            <span>Developed By NBSC ICS 4th Year Student</span>
        </p>
    </div>

</body>
</html>
