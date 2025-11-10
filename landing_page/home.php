<?php
// home.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CNO NutriMap | Home</title>
  <link rel="icon" type="image/png" href="./img/CNO_Logo.png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
</head>
<body class="font-sans text-gray-800">

  <!-- HEADER -->
  <header class="header flex justify-between items-center px-6 md:px-10 py-4 bg-white shadow relative">
  <!-- Logo -->
  <div class="flex items-center font-bold text-2xl text-gray-700">
    <img src="img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2">
    <span class="cno-color">CNO</span><span class="ml-2">NutriMap</span>
  </div>

  <!-- Desktop nav -->
  <nav class="hidden md:flex items-center space-x-6 font-semibold">
    <a href="./index.php" class="text-teal-600">Home</a>
    <a href="landing_page/map.php">Map</a>
    <div class="dropdown relative">
      <a href="landing_page/pages/about_us/about.php" class="nav-link dropdown-link flex items-center gap-1">
        About CNO
        <svg class="dropdown-arrow w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
      </a>
      <div class="dropdown-content absolute hidden bg-gray-100 min-w-[160px] shadow rounded overflow-hidden left-0 z-10">
        <a href="landing_page/pages/about_us/profile.php" class="flex justify-between px-4 py-2 hover:bg-gray-200">Profile</a>
        <a href="landing_page/pages/about_us/history.php" class="flex justify-between px-4 py-2 hover:bg-gray-200">History</a>
        <a href="landing_page/pages/about_us/vision.php" class="flex justify-between px-4 py-2 hover:bg-gray-200">Vision</a>
        <a href="landing_page/pages/about_us/mission.php" class="flex justify-between px-4 py-2 hover:bg-gray-200">Mission</a>
      </div>
    </div>
    <a href="landing_page/pages/contact_us/contact.php" class="nav-link">Contact Us</a>
    <a href="./login.php" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Login</a>
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
    <a href="./index.php" class="px-6 py-3 border-b hover:bg-gray-100">Home</a>
    <a href="landing_page/map.php" class="px-6 py-3 border-b hover:bg-gray-100">Map</a>
    <a href="pages/about_us/about.php" class="px-6 py-3 border-b hover:bg-gray-100">About CNO</a>
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
});
</script>

  <!-- MOBILE MENU -->
  <div id="mobile-menu" class="hidden md:hidden flex-col bg-white shadow-md border-t">
    <a href="index.php" class="px-6 py-3 text-teal-600 font-semibold border-b">Home</a>
    <a href="landing_page/map.php" class="px-6 py-3 border-b">Map</a>

    <!-- Mobile dropdown -->
    <div class="border-b">
      <button id="mobile-dropdown-toggle" class="flex justify-between items-center w-full px-6 py-3 font-semibold text-gray-700 focus:outline-none">
        <span>About CNO</span>
        <i class="fas fa-chevron-down"></i>
      </button>
      <div id="mobile-dropdown" class="hidden flex-col bg-gray-50">
        <a href="landing_page/pages/about_us/profile.php" class="px-8 py-2 text-sm hover:bg-gray-100">Profile</a>
        <a href="landing_page/pages/about_us/history.php" class="px-8 py-2 text-sm hover:bg-gray-100">History</a>
        <a href="landing_page/pages/about_us/vision.php" class="px-8 py-2 text-sm hover:bg-gray-100">Vision</a>
        <a href="landing_page/pages/about_us/mission.php" class="px-8 py-2 text-sm hover:bg-gray-100">Mission</a>
      </div>
    </div>

    <a href="landing_page/pages/contact_us/contact.php" class="px-6 py-3 border-b">Contact Us</a>
    <a href="../login.php" class="px-6 py-3 bg-teal-600 text-white text-center font-semibold">Login</a>
  </div>

  <!-- MAIN -->
  <main class="relative flex items-center justify-center text-white min-h-[80vh] bg-cover bg-center" style="background-image: url('img/bg_img.jpg');">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 px-6 md:px-12 text-center md:text-left max-w-3xl">
      <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4">
        Welcome to <br><span class="text-teal-400">City Nutrition Office</span>
      </h1>
      <p class="text-lg md:text-xl mb-6">El Salvador, Misamis Oriental</p>
      <a href="landing_page/pages/kmau.php" class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-semibold px-6 py-3 rounded-lg">Know More About Us!</a>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-gray-300 py-10 mt-10">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-5 gap-8">
      <!-- Logo -->
      <div class="md:col-span-2">
        <div class="flex items-center mb-4">
          <img src="./img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg" />
          <span class="text-teal-500 text-xl font-bold">CNO</span>
          <span class="text-white text-xl font-bold ml-1">NutriMap</span>
        </div>
        <p class="text-sm">A tool to visualize health and nutrition data for children in El Salvador City.</p>
      </div>

      <!-- About -->
      <div>
        <h3 class="text-white font-semibold text-lg mb-3">About Us</h3>
        <ul class="space-y-2">
          <li><a href="landing_page/pages/about_us/mission.php" class="hover:text-teal-400">Our Mission</a></li>
          <li><a href="landing_page/pages/about_us/vision.php" class="hover:text-teal-400">Our Vision</a></li>
          <li><a href="landing_page/pages/about_us/history.php" class="hover:text-teal-400">History</a></li>
        </ul>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 class="text-white font-semibold text-lg mb-3">Quick Links</h3>
        <ul class="space-y-2">
          <li><a href="landing_page/map.php" class="hover:text-teal-400">Map</a></li>
          <li><a href="landing_page/pages/contact_us/contact.php" class="hover:text-teal-400">Contact Us</a></li>
        </ul>
      </div>

      <!-- Legal -->
      <div>
        <h3 class="text-white font-semibold text-lg mb-3">Legal & Support</h3>
        <ul class="space-y-2">
          <li><a href="landing_page/pages/legal_and_support/terms.php" class="hover:text-teal-400">Terms of Use</a></li>
          <li><a href="landing_page/pages/legal_and_support/privacy.php" class="hover:text-teal-400">Privacy Policy</a></li>
          <li><a href="landing_page/pages/legal_and_support/cookies.php" class="hover:text-teal-400">Cookies</a></li>
          <li><a href="landing_page/pages/help_and_support/help.php" class="hover:text-teal-400">Help</a></li>
          <li><a href="landing_page/pages/help_and_support/faqs.php" class="hover:text-teal-400">FAQs</a></li>
        </ul>
      </div>
    </div>

    <div class="border-t border-gray-700 mt-10 pt-6 text-center text-gray-400 text-sm">
      <p>Copyright &copy; 2025 CNO NutriMap. All Rights Reserved.<br>Developed By NBSC ICS 4th Year Student.</p>
    </div>
  </footer>

  <!-- JS for dropdown + mobile menu -->
  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const dropdownToggle = document.getElementById('mobile-dropdown-toggle');
    const dropdownMenu = document.getElementById('mobile-dropdown');

    // Toggle mobile menu
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Toggle mobile dropdown
    dropdownToggle.addEventListener('click', () => {
      dropdownMenu.classList.toggle('hidden');
      dropdownToggle.querySelector('i').classList.toggle('fa-chevron-down');
      dropdownToggle.querySelector('i').classList.toggle('fa-chevron-up');
    });
  </script>

</body>
</html>
