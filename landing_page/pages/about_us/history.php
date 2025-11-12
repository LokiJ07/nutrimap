<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CNO NutriMap History</title>
  <link rel="icon" type="image/png" href="../../../img/CNO_Logo.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">

 <!-- Header -->
  <header class="bg-white shadow flex justify-between items-center px-6 md:px-10 py-4 relative z-50">
    <!-- Logo -->
    <div class="flex items-center font-bold text-2xl text-gray-700">
      <img src="../../../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2">
      <span class="text-teal-600">CNO</span><span class="ml-2">NutriMap</span>
    </div>

    <!-- Desktop nav -->
    <nav class="hidden md:flex items-center space-x-6 font-semibold">
      <a href="../../../index.php" class="hover:text-teal-600">Home</a>
      <a href="../../map.php" class="hover:text-teal-600">Map</a>

      <!-- Dropdown Parent -->
      <div class="relative">
        <button id="aboutBtn" class="flex items-center gap-1 text-gray-700 text-teal-600 focus:outline-none">
          About CNO
          <svg class="w-4 h-4 transition-transform" id="aboutArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
          </svg>
        </button>
        <div id="aboutDropdown" class="absolute left-0 mt-2 w-40 bg-gray-100 shadow-lg rounded hidden z-50">
          <a href="about.php" class="block px-4 py-2 hover:bg-gray-200">About</a>
          <a href="profile.php" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
          <a href="history.php" class="block px-4 py-2 hover:bg-gray-200 text-teal-600">History</a>
          <a href="vision.php" class="block px-4 py-2 hover:bg-gray-200">Vision</a>
          <a href="mission.php" class="block px-4 py-2 hover:bg-gray-200">Mission</a>
        </div>
      </div>

      <a href="../contact_us/contact.php" class="hover:text-teal-600">Contact Us</a>
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
    <div id="mobileMenu" class="hidden absolute top-full left-0 w-full bg-white shadow-md z-40 flex flex-col">
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
          <a href="about.php" class="px-8 py-2 hover:bg-gray-200">About</a>
          <a href="profile.php" class="px-8 py-2 hover:bg-gray-200">Profile</a>
          <a href="history.php" class="px-8 py-2 hover:bg-gray-200">History</a>
          <a href="vision.php" class="px-8 py-2 hover:bg-gray-200">Vision</a>
          <a href="mission.php" class="px-8 py-2 hover:bg-gray-200">Mission</a>
        </div>
      </div>

      <a href="../contact_us/contact.php" class="px-6 py-3 border-b hover:bg-gray-100">Contact Us</a>
      <a href="../../../login.php" class="px-6 py-3 hover:bg-gray-100">Login</a>
    </div>
  </header>

  <!-- Scripts for dropdowns -->
  <script>
    const burgerBtn = document.getElementById('burgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    burgerBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

    const mobileAboutBtn = document.getElementById('mobileAboutBtn');
    const mobileAboutDropdown = document.getElementById('mobileAboutDropdown');
    const mobileAboutArrow = document.getElementById('mobileAboutArrow');
    mobileAboutBtn.addEventListener('click', e => {
      e.stopPropagation();
      mobileAboutDropdown.classList.toggle('hidden');
      mobileAboutArrow.classList.toggle('rotate-180');
    });
    document.addEventListener('click', e => {
      if (!mobileMenu.contains(e.target)) {
        mobileAboutDropdown.classList.add('hidden');
        mobileAboutArrow.classList.remove('rotate-180');
      }
    });

    const aboutBtn = document.getElementById('aboutBtn');
    const aboutDropdown = document.getElementById('aboutDropdown');
    const aboutArrow = document.getElementById('aboutArrow');
    aboutBtn.addEventListener('click', e => {
      e.stopPropagation();
      aboutDropdown.classList.toggle('hidden');
      aboutArrow.classList.toggle('rotate-180');
    });
    document.addEventListener('click', () => {
      aboutDropdown.classList.add('hidden');
      aboutArrow.classList.remove('rotate-180');
    });
  </script>

  <!-- Main Content -->
  <main class="flex-grow flex flex-col items-center p-5 lg:p-10">
    <h1 class="text-3xl lg:text-4xl font-bold mb-8 text-center">Our History</h1>

    <!-- Timeline -->
    <div class="relative w-full max-w-4xl">
      <!-- Vertical line for large screens -->
      <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-1 bg-gray-300 transform -translate-x-1/2"></div>

      <!-- Timeline items -->
      <div class="flex flex-col md:grid md:grid-cols-9 md:gap-4">
        <!-- Item 1 -->
        <div class="md:col-start-1 md:col-end-5 md:mb-8 flex justify-end">
          <div class="bg-white p-5 rounded-lg shadow relative w-full md:w-80">
            <h3 class="text-teal-600 font-bold text-lg mb-2">The Humble Beginnings (2015-2020)</h3>
            <p class="text-gray-600 leading-relaxed">The City Nutrition Office (CNO) began its journey with a small, dedicated team of passionate individuals. Their primary goal was to address malnutrition and promote healthier lifestyles within the community of El Salvador. Through grassroots efforts and a commitment to serving the public, they laid the foundation for what would become a cornerstone of public health.</p>
            <span class="hidden md:block absolute left-full top-5 w-4 h-4 bg-teal-600 rounded-full border-4 border-white -translate-x-1/2"></span>
          </div>
        </div>

        <!-- Item 2 -->
        <div class="md:col-start-6 md:col-end-10 md:mb-8 flex justify-start">
          <div class="bg-white p-5 rounded-lg shadow relative w-full md:w-80">
            <h3 class="text-teal-600 font-bold text-lg mb-2">Growth and Expansion (2020-2024)</h3>
            <p class="text-gray-600 leading-relaxed">During this period, the CNO expanded its reach by implementing numerous new health programs and conducting extensive community-based research. We collaborated with various local and international partners, which significantly bolstered our capacity to combat malnutrition. Our efforts began to show measurable improvements in the community's overall nutritional status.</p>
            <span class="hidden md:block absolute -left-5 top-5 w-4 h-4 bg-teal-600 rounded-full border-4 border-white"></span>
          </div>
        </div>

        <!-- Item 3 -->
        <div class="md:col-start-1 md:col-end-5 md:mb-8 flex justify-end">
          <div class="bg-white p-5 rounded-lg shadow relative w-full md:w-80">
            <h3 class="text-teal-600 font-bold text-lg mb-2">The NutriMap Revolution (2025)</h3>
            <p class="text-gray-600 leading-relaxed">A pivotal moment in our history came with the establishment of the NutriMap program. This innovative tool revolutionized how we collect and analyze nutritional data. By providing real-time insights, NutriMap allowed us to target our interventions more effectively and monitor the long-term impact of our work with unprecedented precision.</p>
            <span class="hidden md:block absolute left-full top-5 w-4 h-4 bg-teal-600 rounded-full border-4 border-white -translate-x-1/2"></span>
          </div>
        </div>

        <!-- Item 4 -->
        <div class="md:col-start-6 md:col-end-10 md:mb-8 flex justify-start">
          <div class="bg-white p-5 rounded-lg shadow relative w-full md:w-80">
            <h3 class="text-teal-600 font-bold text-lg mb-2">Looking to the Future (2025 and Beyond)</h3>
            <p class="text-gray-600 leading-relaxed">Our commitment to continuous improvement and community engagement remains at the heart of everything we do. We are immensely proud of our past achievements and are excited for the future as we continue to work toward a healthier and more nourished El Salvador. The NutriMap program is just the beginning of our journey to empower communities with better nutritional health.</p>
            <span class="hidden md:block absolute -left-5 top-5 w-4 h-4 bg-teal-600 rounded-full border-4 border-white"></span>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer mt-auto bg-gray-800 text-gray-300 py-10 relative z-10">
    <div class="footer-container max-w-7xl mx-auto px-4">
      <div class="footer-grid grid gap-8 md:grid-cols-5">
        <div class="footer-logo md:col-span-2 flex flex-col items-start">
          <div class="logo-text flex items-center mb-4">
            <img src="../../../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg">
            <span class="logo-primary text-cyan-600 text-xl font-bold">CNO</span>
            <span class="logo-secondary text-white text-xl font-bold ml-1">NutriMap</span>
          </div>
          <p class="footer-desc text-sm">A tool to visualize health and nutrition data for children in El Salvador City.</p>
        </div>
        <div>
          <h3 class="footer-title text-white font-semibold mb-4">About Us</h3>
          <ul class="footer-links space-y-2">
            <li><a href="mission.php" class="hover:text-cyan-600">Our Mission</a></li>
            <li><a href="vision.php" class="hover:text-cyan-600">Our Vision</a></li>
            <li><a href="history.php" class="hover:text-cyan-600">History</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-title text-white font-semibold mb-4">Quick Links</h3>
          <ul class="footer-links space-y-2">
            <li><a href="../../map.php" class="hover:text-cyan-600">Map</a></li>
            <li><a href="../contact_us/contact.php" class="hover:text-cyan-600">Contact Us</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-title text-white font-semibold mb-4">Legal & Support</h3>
          <ul class="footer-links space-y-2">
            <li><a href="../legal_and_support/terms.php" class="hover:text-cyan-600">Terms of Use</a></li>
            <li><a href="../legal_and_support/privacy.php" class="hover:text-cyan-600">Privacy Policy</a></li>
            <li><a href="../legal_and_support/cookies.php" class="hover:text-cyan-600">Cookies</a></li>
            <li><a href="../help_and_support/help.php" class="hover:text-cyan-600">Help</a></li>
            <li><a href="../help_and_support/faqs.php" class="hover:text-cyan-600">FAQs</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom mt-8 border-t border-gray-700 pt-8 text-center text-gray-400 text-sm">
        <p>Copyright&copy; 2025 CNO NutriMap All Rights Reserved. Developed By NBSC ICS 4th Year Student.</p>
      </div>
    </div>
  </footer>

</body>
</html>
