<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CNO | NutriMap</title>
  <link rel="icon" type="image/png" href="../img/CNO_Logo.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css">
  <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
  <style>
    body { margin: 0; }

    /* MAP */
    #map {
      height: 400px;
    }

    /* MAP & CHART CONTAINER FLIP */
    #mapContainer, #chartContainer {
      transition: transform 0.6s;
      backface-visibility: hidden;
    }

    #mapContainer.flipped {
      transform: rotateY(180deg);
      display: none;
    }

    #chartContainer.flipped {
      transform: rotateY(0deg);
      display: block;
    }

    /* FULL CHART */
    #chartContainer {
      display: none;
      width: 100%;
      max-width: 100%;
      height: auto;
      min-height: 450px;
      margin: auto;
      background: white;
      border-radius: 8px;
      padding: 15px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    @media (max-width: 768px) {
      #chartContainer {
        width: 100%;
        min-height: 350px;
        padding: 10px;
      }
    }

    /* Chart Wrapper */
    .chart-wrapper {
      position: relative;
      width: 100%;
      height: 400px;
    }

    #fullChartCanvas {
      width: 100% !important;
      height: 100% !important;
    }

    /* TOOLTIP + MINI CHART */
    #chart-tooltip {
      display: none;
      position: absolute;
      top: 200px;
      left: 80px;
      z-index: 1000;
      background: rgba(255,255,255,0.95);
      padding: 8px;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.25);
      max-width: 250px;
      max-height: 300px;
      overflow-y: auto;
      pointer-events: none;
      flex-direction: column;
      align-items: stretch;
    }

    #chart-tooltip canvas {
      width: 100% !important;
      height: 100% !important;
    }

    @media (max-width: 768px) {
      #chart-tooltip {
        position: fixed;
        bottom: 30px;
        left: 10px;
        right: 10px;
        max-width: calc(60vw - 20px);
        max-height: 250px;
      }
    }

    /* GRADIENT SCALE */
    .gradient-wrapper {
      margin-top: 1rem;
    }

    .gradient-grid {
      display: grid;
      grid-template-columns: repeat(11, 1fr);
      gap: 2px;
      max-width: 720px;
    }

    .gradient-cell {
      height: 20px;
      width: 100%;
      cursor: pointer;
      border-radius: 1px;
      transition: transform 0.1s, outline 0.1s;
    }

    .gradient-cell:hover {
      transform: scale(1.1);
    }

    .active-gradient-cell {
      outline: 2px solid #000;
    }

    #legend-buttons li.active {
      font-weight: bold;
      transform: scale(1.05);
    }

    /* ATTACHED SLIDER */
    .map-slider-wrapper {
      position: relative;
      margin-top: -30px;
      margin-bottom: 15px;
      z-index: 10;
      background: rgba(255,255,255,0.95);
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.15);
      padding: 8px 15px;
      border: 1px solid #e2e8f0;
    }

    .map-slider-container {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    .slider-period-label {
      font-size: 0.7rem;
      font-weight: 600;
      color: #334155;
      background: #f1f5f9;
      padding: 2px 8px;
      border-radius: 20px;
      white-space: nowrap;
    }

    .slider-period-label i {
      margin-right: 4px;
    }

    .compact-slider {
      flex: 1;
      min-width: 150px;
    }

    #compactPeriodSlider {
      height: 4px;
      margin: 8px 0;
    }

    #compactPeriodSlider .noUi-connect {
      background: #3b82f6;
    }

    #compactPeriodSlider .noUi-handle {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background: #3b82f6;
      border: 2px solid white;
      box-shadow: 0 1px 3px rgba(0,0,0,0.2);
      cursor: pointer;
      top: -5px;
    }

    #compactPeriodSlider .noUi-handle:before,
    #compactPeriodSlider .noUi-handle:after {
      display: none;
    }

    #compactPeriodSlider .noUi-handle:hover {
      background: #2563eb;
      transform: scale(1.2);
    }

    .slider-range-text {
      font-size: 0.7rem;
      color: #475569;
      background: #f8fafc;
      padding: 2px 8px;
      border-radius: 20px;
      white-space: nowrap;
    }

    .slider-range-text span {
      font-weight: 600;
      color: #3b82f6;
    }

    /* Chart Range Info Card */
    .chart-range-card {
      background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
      border-left: 4px solid #3b82f6;
      padding: 12px 16px;
      margin-bottom: 20px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
    }

    .chart-range-info {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 0.85rem;
      color: #1e40af;
      flex-wrap: wrap;
    }

    .chart-range-info i {
      font-size: 1.1rem;
      color: #3b82f6;
    }

    .range-badge {
      background: #3b82f6;
      color: white;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
    }

    .range-dates {
      font-weight: 600;
      color: #1e3a8a;
      background: white;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
    }

    .period-count {
      background: #dbeafe;
      color: #1e40af;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.75rem;
    }

    /* Chart Controls */
    .chart-controls {
      display: flex;
      gap: 10px;
      margin-bottom: 15px;
    }

    .chart-control-btn {
      padding: 6px 14px;
      font-size: 0.75rem;
      border-radius: 6px;
      border: 1px solid #e2e8f0;
      background: white;
      cursor: pointer;
      transition: all 0.2s;
    }

    .chart-control-btn.active {
      background: #3b82f6;
      color: white;
      border-color: #3b82f6;
    }

    .chart-control-btn:hover:not(.active) {
      background: #f1f5f9;
    }

    /* Hide the old slider */
    .period-slider-container {
      display: none;
    }
  </style>
</head>

<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

  <!-- HEADER -->
  <header class="header flex justify-between items-center px-6 md:px-10 h-14 bg-white shadow relative">
    <div class="flex items-center font-bold text-2xl text-gray-700">
      <img src="../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2">
      <img src="../logos/fixed/Seal_of_El_Salvador__Misamis_Oriental-removebg-preview.png" alt="NutriMap Logo" class="h-8 mr-2">
      <span class="text-teal-600">CNO</span><span class="ml-2">NutriMap</span>
    </div>

    <!-- Desktop nav -->
    <nav class="hidden md:flex items-center space-x-6 font-semibold">
      <a href="../index.php" class="hover:text-teal-600">Home</a>
      <a href="map.php" class="text-teal-600">Map</a>

      <div class="relative">
        <button id="aboutBtn" class="flex items-center gap-1 font-semibold text-gray-700 hover:text-teal-600 cursor-pointer focus:outline-none">
          About CNO
          <svg class="w-4 h-4 transition-transform" id="aboutArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
          </svg>
        </button>
        <div id="aboutDropdown" class="absolute left-0 mt-2 w-40 bg-gray-100 shadow-lg rounded hidden z-50">
          <a href="pages/about_us/about.php"   class="block px-4 py-2 hover:bg-gray-200">About</a>
          <a href="pages/about_us/profile.php" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
          <a href="pages/about_us/vision.php"  class="block px-4 py-2 hover:bg-gray-200">Vision</a>
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
      <a href="map.php"      class="px-6 py-3 border-b hover:bg-gray-100">Map</a>

      <div class="flex flex-col">
        <button id="mobileAboutBtn" class="flex justify-between items-center px-6 py-3 border-b hover:bg-gray-100 focus:outline-none">
          About CNO
          <svg id="mobileAboutArrow" class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
          </svg>
        </button>
        <div id="mobileAboutDropdown" class="hidden flex flex-col bg-gray-50">
          <a href="pages/about_us/about.php"   class="px-8 py-2 hover:bg-gray-200">About</a>
          <a href="pages/about_us/profile.php" class="px-8 py-2 hover:bg-gray-200">Profile</a>
          <a href="pages/about_us/vision.php"  class="px-8 py-2 hover:bg-gray-200">Vision</a>
          <a href="pages/about_us/mission.php" class="px-8 py-2 hover:bg-gray-200">Mission</a>
        </div>
      </div>

      <a href="pages/contact_us/contact.php" class="px-6 py-3 border-b hover:bg-gray-100">Contact Us</a>
      <a href="../login.php"                  class="px-6 py-3 hover:bg-gray-100">Login</a>
    </div>
  </header>

  <!-- HEADER SCRIPTS -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const burgerBtn  = document.getElementById('burgerBtn');
      const mobileMenu = document.getElementById('mobileMenu');
      burgerBtn?.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

      const mobileAboutBtn      = document.getElementById('mobileAboutBtn');
      const mobileAboutDropdown = document.getElementById('mobileAboutDropdown');
      const mobileAboutArrow    = document.getElementById('mobileAboutArrow');
      mobileAboutBtn?.addEventListener('click', e => {
        e.stopPropagation();
        mobileAboutDropdown.classList.toggle('hidden');
        mobileAboutArrow.classList.toggle('rotate-180');
      });

      const aboutBtn      = document.getElementById('aboutBtn');
      const aboutDropdown = document.getElementById('aboutDropdown');
      const aboutArrow    = document.getElementById('aboutArrow');
      aboutBtn?.addEventListener('click', e => {
        e.stopPropagation();
        aboutDropdown.classList.toggle('hidden');
        aboutArrow.classList.toggle('rotate-180');
      });

      document.addEventListener('click', e => {
        if (!mobileMenu?.contains(e.target)) {
          mobileAboutDropdown?.classList.add('hidden');
          mobileAboutArrow?.classList.remove('rotate-180');
        }
        if (!aboutDropdown?.contains(e.target)) {
          aboutDropdown?.classList.add('hidden');
          aboutArrow?.classList.remove('rotate-180');
        }
      });
    });
  </script>

  <!-- MAIN CONTENT -->
  <main class="flex-1 max-w-7xl mx-auto px-6 pt-2 pb-6 mb-28 bg-white">
    <div class="bg-gray-200 py-2 px-4 mb-4">
      <span class="uppercase tracking-wide text-cyan-600 font-semibold">Data</span>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
      <h1 class="text-lg md:text-xl font-semibold">
        El Salvador Health and Nutrition Map: Share of children who are 0-59 months old measured during OPT Plus
      </h1>
      <div class="flex flex-wrap gap-4 mt-2 md:mt-0 items-center">
        <!-- Tooltip lives here; JS positions it absolutely over the map -->
        <div id="chart-tooltip" class="absolute bottom-5 left-5 max-w-[340px]"></div>
      </div>
    </div>

    <!-- Map and Chart Container -->
    <div class="flex flex-col lg:flex-row gap-6">
      <div class="flex-1">

        <!-- Map -->
        <div id="mapContainer" class="relative">
          <div id="map" class="rounded border border-gray-300 z-0"></div>

          <!-- Compact Period Slider — overlaid on map bottom -->
          <div class="map-slider-wrapper">
            <div class="map-slider-container">
              <div class="slider-period-label">
                <i class="fas fa-calendar-alt"></i> Period Range
              </div>
              <div class="compact-slider">
                <div id="compactPeriodSlider"></div>
              </div>
              <div class="slider-range-text">
                <span id="compactStartPeriod">-</span> → <span id="compactEndPeriod">-</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Chart (hidden until user clicks Chart button) -->
        <div id="chartContainer" class="hidden mt-4">

          <!-- Chart Range Display Card -->
          <div class="chart-range-card" id="chartRangeCard">
            <div class="chart-range-info">
              <i class="fas fa-chart-line"></i>
              <span>Chart Period Range:</span>
              <span class="range-badge"  id="rangeTypeBadge">Multiple Periods</span>
              <span class="range-dates"  id="rangeDatesDisplay">Loading...</span>
              <span class="period-count" id="periodCountDisplay">0 periods</span>
            </div>
            <div>
              <i class="fas fa-sliders-h"></i>
              <span id="sliderHint" class="text-xs">Slide the bar above to change range</span>
            </div>
          </div>

          <!-- Chart Type Controls -->
          <div class="chart-controls">
            <button id="chartViewLine" class="chart-control-btn active">📈 Line Chart</button>
            <button id="chartViewBar"  class="chart-control-btn">📊 Bar Chart</button>
          </div>

          <!-- Canvas -->
          <div class="chart-wrapper">
            <canvas id="fullChartCanvas"></canvas>
          </div>

          <div class="text-xs text-gray-400 text-center mt-3">
            <i class="fas fa-info-circle"></i> Chart automatically updates when you slide the period range
          </div>
        </div>
      </div>

      <!-- Legend Sidebar -->
      <div id="legend-buttons" class="w-full lg:w-60 bg-gray-50 border border-gray-300 rounded p-4">

        <!-- Map / Chart toggle -->
        <div class="flex gap-2 mb-3">
          <button id="btnMapView"   class="view-btn px-3 py-1 text-sm border border-gray-400 text-gray-700 rounded bg-transparent hover:bg-gray-100">Map</button>
          <button id="btnChartView" class="view-btn px-3 py-1 text-sm border border-gray-400 text-gray-700 rounded bg-transparent hover:bg-gray-100">Chart</button>
        </div>

        <!-- Barangay filter -->
        <div>
          <label class="block text-sm font-medium text-gray-600">Select Barangay</label>
          <select id="barangayFilter" class="mt-1 block w-48 rounded border border-gray-300 shadow-sm">
            <option value="All">All</option>
            <option value="Amoros">Amoros</option>
            <option value="Bolisong">Bolisong</option>
            <option value="Himaya">Himaya</option>
            <option value="Hinigdaan">Hinigdaan</option>
            <option value="Kalabaylabay">Kalabaylabay</option>
            <option value="Molugan">Molugan</option>
            <option value="Bolobolo">Bolobolo</option>
            <option value="Poblacion">Poblacion</option>
            <option value="Kibonbon">Kibonbon</option>
            <option value="Sambulawan">Sambulawan</option>
            <option value="Calongonan">Calongonan</option>
            <option value="Sinaloc">Sinaloc</option>
            <option value="Taytay">Taytay</option>
            <option value="Ulaliman">Ulaliman</option>
            <option value="Cogon">Cogon</option>
          </select>
        </div>

        <!-- Legend items -->
        <h2 class="text-md font-semibold mb-3 mt-4">Legend</h2>
        <ul class="space-y-2 text-sm">
          <li data-field="all"              data-label="All Indicators"   data-color="#888"    class="cursor-pointer">
            <span class="w-4 h-4 mr-2 bg-gray-400 inline-block"></span>All
          </li>
          <li data-field="UNDERWEIGHT"      data-label="Underweight"      data-color="#FFFF00" class="cursor-pointer">
            <span class="w-4 h-4 mr-2 bg-yellow-400 inline-block"></span>Underweight
          </li>
          <li data-field="WASTED"           data-label="Wasted"           data-color="#FFA500" class="cursor-pointer">
            <span class="w-4 h-4 mr-2 bg-orange-500 inline-block"></span>Wasted
          </li>
          <li data-field="OVERWEIGHT_OBESE" data-label="Overweight/Obese" data-color="#0000FF" class="cursor-pointer">
            <span class="w-4 h-4 mr-2 bg-blue-500 inline-block"></span>Overweight/Obese
          </li>
          <li data-field="STUNTED"          data-label="Stunted"          data-color="#FF0000" class="cursor-pointer">
            <span class="w-4 h-4 mr-2 bg-red-600 inline-block"></span>Stunted
          </li>
        </ul>
      </div>
    </div>

    <!-- Gradient Scale -->
    <div class="gradient-wrapper mt-6" id="gradient-wrapper">
      <div class="gradient-grid" id="gradient-grid"></div>
    </div>

    <h2 class="p-4">
      <span class="font-bold">Data Source:</span>
      <span>Operation Timbang Plus</span>
    </h2>
  </main>

  <!-- FOOTER -->
  <footer class="footer mt-auto bg-gray-800 text-gray-300 py-10 relative z-10">
    <div class="footer-container max-w-7xl mx-auto px-4">
      <div class="footer-grid grid gap-8 md:grid-cols-5">

        <div class="footer-logo md:col-span-2 flex flex-col items-start">
          <div class="logo-text flex items-center mb-4">
            <img src="../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2 rounded-lg">
            <span class="logo-primary text-cyan-600 text-xl font-bold">CNO</span>
            <span class="logo-secondary text-white text-xl font-bold ml-1">NutriMap</span>
          </div>
          <p class="footer-desc text-sm">A tool to visualize health and nutrition data for children in El Salvador City.</p>
        </div>

        <div>
          <h3 class="footer-title text-white font-semibold mb-4">About Us</h3>
          <ul class="footer-links space-y-2">
            <li><a href="pages/about_us/mission.php" class="hover:text-cyan-600">Our Mission</a></li>
            <li><a href="pages/about_us/vision.php"  class="hover:text-cyan-600">Our Vision</a></li>
          </ul>
        </div>

        <div>
          <h3 class="footer-title text-white font-semibold mb-4">Quick Links</h3>
          <ul class="footer-links space-y-2">
            <li><a href="map.php"                          class="hover:text-cyan-600">Map</a></li>
            <li><a href="pages/contact_us/contact.php"     class="hover:text-cyan-600">Contact Us</a></li>
          </ul>
        </div>

        <div>
          <h3 class="footer-title text-white font-semibold mb-4">Legal &amp; Support</h3>
          <ul class="footer-links space-y-2">
            <li><a href="pages/legal_and_support/terms.php"   class="hover:text-cyan-600">Terms of Use</a></li>
            <li><a href="pages/legal_and_support/privacy.php" class="hover:text-cyan-600">Privacy Policy</a></li>
            <li><a href="pages/legal_and_support/cookies.php" class="hover:text-cyan-600">Cookies</a></li>
            <li><a href="pages/help_and_support/help.php"     class="hover:text-cyan-600">Help</a></li>
            <li><a href="pages/help_and_support/faqs.php"     class="hover:text-cyan-600">FAQs</a></li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom mt-8 border-t border-gray-700 pt-8 text-center text-gray-400 text-sm">
        <p>Copyright &copy; 2025 CNO NutriMap All Rights Reserved. Developed By NBSC ICS 4th Year Student.</p>
      </div>
    </div>
  </footer>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
  <script src="js/map1.js"></script>
</body>
</html>