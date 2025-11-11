<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cookies Policy | CNO NutriMap</title>
  <link rel="icon" type="image/png" href="../../../img/CNO_Logo.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; }
    .arrow-icon { transition: transform 0.3s ease-in-out; }
    .arrow-down { transform: rotate(180deg); }
  </style>
</head>

<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">

  <!-- ===================== HEADER ===================== -->
  <header class="flex justify-between items-center px-6 lg:px-10 py-4 bg-white shadow relative z-50">
    <!-- Logo -->
    <div class="flex items-center font-bold text-2xl text-gray-700">
      <img src="../../../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg">
      <span class="text-[#00a0a0]">CNO</span><span class="ml-2">NutriMap</span>
    </div>

    <!-- Navigation -->
    <nav class="flex items-center space-x-6">
      <a href="../../../index.php" class="text-gray-600 hover:text-gray-900 font-semibold px-4 py-2 rounded-md transition duration-300">Home</a>
      <a href="../../map.php" class="text-gray-600 hover:text-gray-900 font-semibold px-4 py-2 rounded-md transition duration-300">Map</a>

      <!-- About Dropdown -->
      <div class="relative">
        <button id="about-button" class="flex items-center space-x-2 text-gray-800 font-semibold px-4 py-2 rounded-lg hover:bg-gray-100 transition">
          <span>About CNO</span>
          <svg id="about-arrow-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="about-dropdown-menu" class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 hidden">
          <a href="../../pages/about_us/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0]">Profile</a>
          <a href="../../pages/about_us/history.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0]">History</a>
          <a href="../../pages/about_us/mission.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0]">Mission</a>
          <a href="../../pages/about_us/vision.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0]">Vision</a>
        </div>
      </div>

      <!-- Contact Dropdown -->
      <div class="relative">
        <button id="contact-button" class="flex items-center space-x-2 bg-[#00a0a0] text-white font-semibold px-4 py-2 rounded-md shadow hover:bg-[#008c8c] transition">
          <span>Contact</span>
          <svg id="contact-arrow-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="contact-dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 hidden">
          <a href="../../pages/contact_us/get_in_touch.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0]">Get In Touch</a>
          <a href="../../pages/contact_us/downloadable_form.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0]">Downloadable Form</a>
          <a href="../../pages/contact_us/feedback.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#00a0a0]">Feedback</a>
        </div>
      </div>

      <a href="../../Frontend/login.php" class="border border-[#00a0a0] text-[#00a0a0] font-semibold px-4 py-2 rounded-md hover:bg-gray-50 transition">Login</a>
    </nav>
  </header>

  <!-- ===================== MAIN CONTENT ===================== -->
  <main class="flex-grow flex flex-col items-center px-4 py-10 lg:px-20">
    <section class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 text-left">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-4">Cookies Policy</h1>
      <p class="text-gray-600 mb-6 text-center">
        Nagpapaliwanag ang policy na ito kung paano ginagamit ang cookies sa aming website.
      </p>

      <div class="space-y-6">
        <div>
          <h2 class="text-2xl font-semibold text-gray-700 mb-2">1. Ano ang Cookies?</h2>
          <p class="text-gray-600">
            Ang cookies ay maliliit na text files na inilalagay sa inyong device kapag bumibisita kayo sa isang website. Ginagamit ito para maalala ang inyong mga kagustuhan at gawing mas maayos ang inyong karanasan.
          </p>
        </div>

        <div>
          <h2 class="text-2xl font-semibold text-gray-700 mb-2">2. Paano Namin Ginagamit ang Cookies</h2>
          <p class="text-gray-600">
            Ginagamit namin ang cookies upang mapabuti ang functionality ng site, masubaybayan ang paggamit ng website, at ma-customize ang inyong karanasan.
          </p>
        </div>

        <div>
          <h2 class="text-2xl font-semibold text-gray-700 mb-2">3. Pamamahala sa Cookies</h2>
          <p class="text-gray-600">
            May kontrol kayo sa cookies. Maaari ninyong baguhin ang inyong browser settings upang tanggihan ang cookies o makatanggap ng abiso kapag may ipinapadalang cookies. Tandaan na ang pag-block ng cookies ay maaaring makaapekto sa ilang features ng website.
          </p>
        </div>
      </div>
    </section>
  </main>

  <!-- ===================== FOOTER ===================== -->
  <footer class="bg-gray-800 text-gray-300 py-10 mt-auto">
    <div class="max-w-6xl mx-auto px-6 lg:px-8 grid grid-cols-1 md:grid-cols-5 gap-8">
      <!-- Logo & Description -->
      <div class="md:col-span-2">
        <div class="flex items-center mb-4">
          <img src="../../css/image/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg">
          <span class="text-2xl font-bold text-[#00a0a0]">CNO</span><span class="text-2xl font-bold ml-1 text-white">NutriMap</span>
        </div>
        <p class="text-sm">A tool to visualize health and nutrition data for children in El Salvador City.</p>
      </div>

      <!-- About Us -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">About Us</h3>
        <ul class="space-y-2">
          <li><a href="../../pages/about_us/mission.php" class="hover:text-[#00a0a0]">Our Mission</a></li>
          <li><a href="../../pages/about_us/vision.php" class="hover:text-[#00a0a0]">Our Vision</a></li>
          <li><a href="../../pages/about_us/history.php" class="hover:text-[#00a0a0]">History</a></li>
        </ul>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">Quick Links</h3>
        <ul class="space-y-2">
          <li><a href="../../pages/map_us/map.php" class="hover:text-[#00a0a0]">Map</a></li>
          <li><a href="../../pages/contact_us/get_in_touch.php" class="hover:text-[#00a0a0]">Contact Us</a></li>
          <li><a href="../../pages/contact_us/downloadable_form.php" class="hover:text-[#00a0a0]">Downloadable Forms</a></li>
        </ul>
      </div>

      <!-- Legal & Support -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">Legal & Support</h3>
        <ul class="space-y-2">
          <li><a href="../../pages/legal_and_support/terms_of_use.php" class="hover:text-[#00a0a0]">Terms of Use</a></li>
          <li><a href="../../pages/legal_and_support/privacy_policy.php" class="hover:text-[#00a0a0]">Privacy Policy</a></li>
          <li><a href="../../pages/legal_and_support/cookies.php" class="hover:text-[#00a0a0]">Cookies</a></li>
          <li><a href="../../pages/help_and_support/help.php" class="hover:text-[#00a0a0]">Help</a></li>
          <li><a href="../../pages/help_and_support/faqs.php" class="hover:text-[#00a0a0]">FAQs</a></li>
        </ul>
      </div>
    </div>

    <div class="mt-10 border-t border-gray-700 pt-6 text-center text-gray-400 text-sm">
      &copy; 2025 CNO NutriMap. All Rights Reserved. Developed by NBSC ICS 4th Year Student.
    </div>
  </footer>

  <!-- ===================== DROPDOWN SCRIPT ===================== -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const aboutBtn = document.getElementById('about-button');
      const aboutMenu = document.getElementById('about-dropdown-menu');
      const aboutIcon = document.getElementById('about-arrow-icon');
      const contactBtn = document.getElementById('contact-button');
      const contactMenu = document.getElementById('contact-dropdown-menu');
      const contactIcon = document.getElementById('contact-arrow-icon');

      function toggle(button, menu, icon) {
        menu.classList.toggle('hidden');
        icon.classList.toggle('arrow-down');
      }

      aboutBtn.addEventListener('click', e => {
        e.stopPropagation();
        toggle(aboutBtn, aboutMenu, aboutIcon);
        contactMenu.classList.add('hidden');
        contactIcon.classList.remove('arrow-down');
      });

      contactBtn.addEventListener('click', e => {
        e.stopPropagation();
        toggle(contactBtn, contactMenu, contactIcon);
        aboutMenu.classList.add('hidden');
        aboutIcon.classList.remove('arrow-down');
      });

      document.addEventListener('click', e => {
        if (!aboutBtn.contains(e.target)) {
          aboutMenu.classList.add('hidden');
          aboutIcon.classList.remove('arrow-down');
        }
        if (!contactBtn.contains(e.target)) {
          contactMenu.classList.add('hidden');
          contactIcon.classList.remove('arrow-down');
        }
      });
    });
  </script>

</body>
</html>
