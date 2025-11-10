<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CNO NutriMap - Organizational Chart</title>
  <link rel="icon" type="image/png" href="../../img/CNO_Logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {font-family: 'Arial', sans-serif; margin:0; padding:0; background:#f0f2f5; color:#333; display:flex; flex-direction:column; min-height:100vh;}
    .org-chart-page-container {flex-grow:1; display:flex; justify-content:center; align-items:flex-start; padding:30px; overflow-x:auto; background:#f7f7f7;}
    .org-chart {background:linear-gradient(to bottom,#e0ffe0,#c0ffc0); border-radius:10px; padding:40px; box-shadow:0 5px 15px rgba(0,0,0,0.1); display:flex; flex-direction:column; align-items:center; min-width:900px; max-width:1200px;}
    .chart-header-logos {display:flex; justify-content:space-between; width:100%; margin-bottom:20px; padding:0 50px;}
    .chart-header-logos img {height:60px; object-fit:contain;}
    .chart-title-text {text-align:center; margin-bottom:25px;}
    .chart-title-text h2 {font-size:2.2rem; font-weight:bold; color:#333; margin:0; line-height:1.2;}
    .chart-title-text h3 {font-size:1.3rem; font-weight:normal; color:#555; margin:5px 0 0;}
    .node {background:#fff; border:1px solid #00a0a0; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.1); padding:10px 15px; margin:10px; text-align:center; position:relative; min-width:150px;}
    .node-img {width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #00a0a0; margin-bottom:8px;}
    .node-name {font-weight:bold; font-size:1rem; color:#333; margin-bottom:2px;}
    .node-position {font-size:0.85rem; color:#666; line-height:1.2;}
    .top-node .node-position {background:#fffacd; border:1px solid #e0c240; border-radius:5px; padding:5px 10px; font-weight:bold; color:#333; margin-top:5px;}
    .vertical-line {width:2px; height:30px; margin:0 auto; background:#666;}
    .division-line-container {display:flex; justify-content:center; width:100%; position:relative; margin-top:10px;}
    .division-line-container::before {content:''; position:absolute; top:0; left:50%; transform:translateX(-50%); width:70%; height:2px; background:#666;}
    .division-box {background:#fff; border:1px solid #666; border-top:none; border-radius:0 0 8px 8px; padding:8px 30px; margin:0 30px; font-weight:bold; color:#333; position:relative; z-index:1; top:-1px;}
    .division-group {display:flex; justify-content:center; margin-top:20px; width:100%;}
    .technical-division,.administrative-division {display:flex; flex-direction:column; align-items:center; flex:1; padding:0 10px;}
    .technical-members,.administrative-members {display:flex; justify-content:center; gap:20px; margin-top:20px; position:relative;}
    .technical-members::before,.administrative-members::before {content:''; position:absolute; top:-10px; left:0; right:0; height:2px; background:#666;}
    .member-container {display:flex; flex-direction:column; align-items:center; position:relative; padding-top:15px;}
    .member-container::before {content:''; position:absolute; top:0; left:50%; transform:translateX(-50%); width:2px; height:15px; background:#666;}
    .footer {background:#1f2937; color:#d1d5db; padding:2.5rem 0; margin-top:auto; position:relative; z-index:10;}
    .footer-container {max-width:72rem; margin:0 auto; padding:0 1rem;}
    .footer-grid {display:grid; grid-template-columns:1fr; gap:2rem;}
    @media(min-width:768px){.footer-grid{grid-template-columns:repeat(5,1fr);} .footer-logo-col{grid-column:span 2/span 2;}}
    .footer-logo-container {display:flex; flex-direction:column; align-items:flex-start;}
    .footer-logo-content {display:flex; align-items:center; margin-bottom:1rem;}
    .footer-logo-img {height:2.5rem; width:2.5rem; margin-right:0.5rem; border-radius:0.5rem;}
    .logo-text-footer {display:flex; align-items:center; font-size:1.5rem; font-weight:bold;}
    .logo-primary-footer {color:#00a0a0;}
    .logo-secondary-footer {color:#fff; margin-left:0.25rem;}
    .footer-desc {font-size:0.875rem;}
    .footer-title {font-size:1.125rem; font-weight:600; color:#fff; margin-bottom:1rem;}
    .footer-links {list-style:none; padding:0; margin:0;}
    .footer-links li {margin-bottom:0.5rem;}
    .footer-links a {color:#d1d5db; text-decoration:none; transition:color 0.2s;}
    .footer-links a:hover {color:#00a0a0;}
    .footer-bottom {margin-top:2rem; border-top:1px solid #374151; padding-top:2rem; text-align:center;}
    .footer-bottom p {color:#9ca3af; font-size:0.875rem;}
  </style>
</head>
<body>
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

    <div class="org-chart-page-container">
      <div class="org-chart">
        <div class="chart-header-logos">
          <img src="../../../img/Ellipse_04.png" alt="Bagong Pilipinas Logo">
          <img src="../../../img/Ellipse_02.png" alt="El Salvador City Logo">
        </div>
        <div class="chart-title-text">
          <h2>ORGANIZATIONAL CHART</h2>
          <h2>CITY NUTRITION OFFICE</h2>
          <h3>El Salvador City, Misamis Oriental</h3>
        </div>
        <div class="node top-node">
          <img src="../../../img/CNAO.png" alt="Elma M. Clapano, RN" class="node-img">
          <div class="node-name">Elma M. Clapano, RN</div>
          <div class="node-position">City Nutrition Action Officer</div>
        </div>
        <div class="vertical-line"></div>
        <div class="division-line-container">
          <div class="division-box">Technical Division</div>
          <div class="division-box">Administrative Division</div>
        </div>
        <div class="division-group">
          <div class="technical-division">
            <div class="technical-members">
              <div class="member-container"><div class="node"><img src="../../../img/CNPC.png" alt="Edgar B. Napiñas" class="node-img"><div class="node-position">City Nutrition Program Coordinator</div><div class="node-name">Edgar B. Napiñas</div></div></div>
              <div class="member-container"><div class="node"><img src="../../../img/CND.png" alt="Arlie Joy O. Damiles, RND" class="node-img"><div class="node-position">Nutritionist-Dietitian</div><div class="node-name">Arlie Joy O. Damiles, RND</div></div></div>
              <div class="member-container"><div class="node"><img src="../../../img/ND.png" alt="Karen Jay B. Langala, RND" class="node-img"><div class="node-position">Nutritionist-Dietitian</div><div class="node-name">Karen Jay B. Langala, RND</div></div></div>
              <div class="member-container"><div class="node"><img src="../../../img/PC.png" alt="Jay S. Boctot, LPT" class="node-img"><div class="node-position">City Nutrition Program Coordinator</div><div class="node-name">Jay S. Boctot, LPT</div></div></div>
            </div>
          </div>
          <div class="administrative-division">
            <div class="administrative-members">
              <div class="member-container"><div class="node"><img src="../../../img/OC.png" alt="Honey Grace S. Magriña" class="node-img"><div class="node-position">Office Clerk</div><div class="node-name">Honey Grace S. Magriña</div></div></div>
              <div class="member-container"><div class="node"><img src="../../../img/AA.png" alt="Antonette E. Villbar" class="node-img"><div class="node-position">Administrative Aide III</div><div class="node-name">Antonette E. Villbar</div></div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <footer class="footer">
    <div class="footer-container">
      <div class="footer-grid">
        <div class="footer-logo-col footer-logo-container">
          <div class="footer-logo-content">
            <img src="../../../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="footer-logo-img">
            <div class="logo-text-footer"><span class="logo-primary-footer">CNO</span><span class="logo-secondary-footer">NutriMap</span></div>
          </div>
          <p class="footer-desc">A tool to visualize health and nutrition data for children in El Salvador City.</p>
        </div>
        <div>
          <h3 class="footer-title">About Us</h3>
          <ul class="footer-links">
            <li><a href="pages/about_us/mission.php">Our Mission</a></li>
            <li><a href="pages/about_us/vision.php">Our Vision</a></li>
            <li><a href="pages/about_us/history.php">History</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-title">Quick Links</h3>
          <ul class="footer-links">
            <li><a href="pages/map_us/map.php">Map</a></li>
            <li><a href="pages/contact_us/get_in_touch.php">Contact Us</a></li>
            <li><a href="pages/contact_us/downloadable_form.php">Downloadable Forms</a></li>
          </ul>
        </div>
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
