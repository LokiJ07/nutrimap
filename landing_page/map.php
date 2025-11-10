<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CNO NutriMap</title>
  <link rel="icon" type="image/png" href="../img/CNO_Logo.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
  <style>
    body { margin:0; }
    #map { height: 640px; }
    #chart-tooltip {
      position: absolute;
      z-index: 1000;
      background: rgba(255,255,255,0.95);
      padding: 8px;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.25);
      max-width: 320px;
      pointer-events: none;
    }
    /* Make tooltip canvas responsive */
#chart-tooltip {
  max-width: 320px;
}

#chart-tooltip canvas {
  width: 100% !important;
  height: 150px !important; /* default for desktop */
}

/* Mobile adjustments */
@media (max-width: 768px) {
  #chart-tooltip {
    max-width: 90vw; /* tooltip almost full screen */
  }
  #chart-tooltip canvas {
    height: 120px !important; /* smaller chart for mobile */
  }
}
    .gradient-cell {
      height: 20px;
      width: 20px;
      display:inline-block;
      margin-right:4px;
      margin-bottom:4px;
      cursor:pointer;
    }
    .active-gradient-cell { outline: 2px solid #000; }
  </style>
<body class="flex flex-col min-h-screen">

  <!-- HEADER -->
<header class="header flex justify-between items-center px-6 md:px-10 py-4 bg-white shadow relative">
  <!-- Logo -->
  <div class="flex items-center font-bold text-2xl text-gray-700">
    <img src="../img/CNO_Logo.png" alt="CNO NutriMap Logo" class="h-10 mr-2">
    <span class="cno-color">CNO</span><span class="ml-2">NutriMap</span>
  </div>

  <!-- Desktop nav -->
  <nav class="hidden md:flex items-center space-x-6 font-semibold">
    <a href="../index.php" class="nav-link">Home</a>
    <a href="map.php" class="text-teal-600">Map</a>
    <div class="dropdown relative">
      <a href="pages/about_us/about.php" class="nav-link dropdown-link flex items-center gap-1">
        About CNO
        <svg class="dropdown-arrow w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
      </a>
      <div class="dropdown-content absolute hidden bg-gray-100 min-w-[160px] shadow rounded overflow-hidden left-0 z-10">
        <a href="pages/about_us/profile.php" class="flex justify-between px-4 py-2 hover:bg-gray-200">Profile</a>
        <a href="pages/about_us/history.php" class="flex justify-between px-4 py-2 hover:bg-gray-200">History</a>
        <a href="pages/about_us/vision.php" class="flex justify-between px-4 py-2 hover:bg-gray-200">Vision</a>
        <a href="pages/about_us/mission.php" class="flex justify-between px-4 py-2 hover:bg-gray-200">Mission</a>
      </div>
    </div>
    <a href="pages/contact_us/contact.php" class="nav-link">Contact Us</a>
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
    <a href="pages/about_us/about.php" class="px-6 py-3 border-b hover:bg-gray-100">About CNO</a>
    <a href="pages/contact_us/contact.php" class="px-6 py-3 border-b hover:bg-gray-100">Contact Us</a>
    <a href="../login.php" class="px-6 py-3 hover:bg-gray-100">Login</a>
  </div>
</header>

<script>
const burgerBtn = document.getElementById('burgerBtn');
const mobileMenu = document.getElementById('mobileMenu');

burgerBtn.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden');
});
</script>


  <!-- MAIN CONTENT -->
  <main class="flex-1 max-w-7xl mx-auto px-6 py-6 mt-4 mb-28 bg-white shadow rounded">
    <div class="bg-gray-200 py-2 px-4 mb-4">
      <span class="uppercase tracking-wide text-cyan-600 font-semibold">Data</span>
    </div>
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
      <h1 class="text-lg md:text-xl font-semibold">
        El Salvador Health and Nutrition Map: Share of children who are stunted
      </h1>
      <div class="flex flex-wrap gap-4 mt-2 md:mt-0 items-center">
        <div id="chart-tooltip" class="absolute bottom-5 left-5 max-w-[340px]"></div>
        <div>
          <label class="block text-sm font-medium text-gray-600">Select Year</label>
          <select id="yearFilter" class="mt-1 block w-32 rounded border border-gray-300 shadow-sm"></select>
        </div>
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
      </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
      <div class="flex-1">
        <div id="map" class="rounded border border-gray-300"></div>
      </div>
      <div id="legend-buttons" class="w-full lg:w-60 bg-gray-50 border border-gray-300 rounded p-4">
        <h2 class="text-md font-semibold mb-3">Legend</h2>
        <ul class="space-y-2 text-sm">
          <li data-field="all" data-label="All Indicators" data-color="#888" class="cursor-pointer"> <span class="w-4 h-4 mr-2 bg-gray-400 inline-block"></span>All</li>
          <li data-field="ind9b1_pct" data-label="Severly Underweight" data-color="#8b0202" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-red-600 inline-block"></span>Severly Underweight</li>
          <li data-field="ind9b2_pct" data-label="Underweight" data-color="#ce6402" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-orange-500 inline-block"></span>Underweight</li>
          <li data-field="ind9b3_pct" data-label="Normal" data-color="#338b09" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-green-500 inline-block"></span>Normal</li>
          <li data-field="ind9b4_pct" data-label="Severly Wasted" data-color="#05f5f5" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-cyan-400 inline-block"></span>Severly Wasted</li>
          <li data-field="ind9b5_pct" data-label="Wasted" data-color="#ffef0e" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-yellow-400 inline-block"></span>Wasted</li>
          <li data-field="ind9b6_pct" data-label="Overweight" data-color="#694c0d" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-yellow-800 inline-block"></span>Overweight</li>
          <li data-field="ind9b7_pct" data-label="Obese" data-color="#fc3c9c" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-pink-600 inline-block"></span>Obese</li>
          <li data-field="ind9b8_pct" data-label="Severly Stunted" data-color="#a00686" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-purple-600 inline-block"></span>Severly Stunted</li>
          <li data-field="ind9b9_pct" data-label="Stunted" data-color="#032c74" class="cursor-pointer"><span class="w-4 h-4 mr-2 bg-blue-500 inline-block"></span>Stunted</li>
        </ul>
      </div>
    </div>

    <div class="gradient-wrapper mt-6" id="gradient-wrapper">
      <div class="gradient-grid" id="gradient-grid"></div>
    </div>
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
            <li><a href="landing_page/pages/about_us/mission.php" class="hover:text-cyan-600">Our Mission</a></li>
            <li><a href="landing_page/pages/about_us/vision.php" class="hover:text-cyan-600">Our Vision</a></li>
            <li><a href="landing_page/pages/about_us/history.php" class="hover:text-cyan-600">History</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-title text-white font-semibold mb-4">Quick Links</h3>
          <ul class="footer-links space-y-2">
            <li><a href="landing_page/map.php" class="hover:text-cyan-600">Map</a></li>
            <li><a href="landing_page/pages/contact_us/contact.php" class="hover:text-cyan-600">Contact Us</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-title text-white font-semibold mb-4">Legal & Support</h3>
          <ul class="footer-links space-y-2">
            <li><a href="landing_page/pages/legal_and_support/terms.php" class="hover:text-cyan-600">Terms of Use</a></li>
            <li><a href="landing_page/pages/legal_and_support/privacy.php" class="hover:text-cyan-600">Privacy Policy</a></li>
            <li><a href="landing_page/pages/legal_and_support/cookies.php" class="hover:text-cyan-600">Cookies</a></li>
            <li><a href="landing_page/pages/help_and_support/help.php" class="hover:text-cyan-600">Help</a></li>
            <li><a href="landing_page/pages/help_and_support/faqs.php" class="hover:text-cyan-600">FAQs</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom mt-8 border-t border-gray-700 pt-8 text-center text-gray-400 text-sm">
        <p>Copyright&copy; 2025 CNO NutriMap All Rights Reserved. Developed By NBSC ICS 4th Year Student.</p>
      </div>
    </div>
  </footer>

  <!-- SCRIPTS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script>

// ===================== MAP INITIAL SETUP =====================
const map = L.map('map', {
  center: [8.4760268, 124.4809540],
  zoom: 12,
  zoomControl: false,
  dragging: false,
  scrollWheelZoom: false,
  doubleClickZoom: false,
  boxZoom: false,
  touchZoom: false
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data © OpenStreetMap contributors'
}).addTo(map);

// ===================== VARIABLES =====================
let geoLayer, geoData;
let activeField = null, activeColor = null, activeLabel = null;
let activeYear = 'All';
let miniChart = null;
let activeGradientRange = null;
const legendItems = Array.from(document.querySelectorAll('#legend-buttons li'));

// ===================== LOAD GEOJSON DATA =====================
fetch('../landing_page/get_map_data.php')
  .then(r => r.json())
  .then(data => {
    geoData = data;

    // Year dropdown
    const years = [...new Set(geoData.features.map(f => f.properties.YEAR).filter(y => y && y !== ''))].sort((a,b)=>b-a);
    const yearSelect = document.getElementById('yearFilter');
    yearSelect.innerHTML='';
    const allOpt = document.createElement('option');
    allOpt.value='All';
    allOpt.textContent='All Years';
    yearSelect.appendChild(allOpt);
    years.forEach(y => {
      const opt = document.createElement('option');
      opt.value = y;
      opt.textContent = y;
      yearSelect.appendChild(opt);
    });

    activeYear = 'All';
    yearSelect.value = 'All';
    drawLayer(activeYear);

    yearSelect.addEventListener('change', e => {
      activeYear = e.target.value;
      drawLayer(activeYear);
    });
  })
  .catch(err => console.error('Error loading map data:', err));

// ===================== DRAW LAYER =====================
function drawLayer(selectedYear) {
  if(!geoData) return;
  if(!selectedYear) selectedYear = activeYear;
  if(geoLayer) map.removeLayer(geoLayer);

  let mergedFeatures = [];

  if(selectedYear === 'All') {
    // Use latest year per barangay
    const barangayMap = new Map();
    geoData.features.forEach(f => {
      const b = f.properties.BARANGAY?.toUpperCase();
      const year = parseInt(f.properties.YEAR || 0);
      if(!barangayMap.has(b) || year > (barangayMap.get(b).properties.YEAR || 0)) {
        barangayMap.set(b, f);
      }
    });
    mergedFeatures = Array.from(barangayMap.values());
  } else {
    mergedFeatures = geoData.features.filter(f => f.properties.YEAR == selectedYear);
  }

  // Add missing barangays (no data)
  const barangayWithData = new Set(mergedFeatures.map(f => f.properties.BARANGAY?.toUpperCase()));
  const allBarangays = geoData.features.map(f => f.properties.BARANGAY?.toUpperCase());
  [...new Set(allBarangays)].forEach(b => {
    if(!barangayWithData.has(b)) {
      const base = geoData.features.find(f => f.properties.BARANGAY?.toUpperCase() === b);
      if(base){
        const clone = JSON.parse(JSON.stringify(base));
        clone.properties.NO_DATA = true;
        mergedFeatures.push(clone);
      }
    }
  });

  const finalData = { type: "FeatureCollection", features: mergedFeatures };
  geoLayer = L.geoJSON(finalData, { style: styleFeature, onEachFeature: featureHandler }).addTo(map);
}

// ===================== STYLING =====================
function styleFeature(feature){
  const props = feature.properties;

  // Transparent base but visible boundary for missing data
  if(props.NO_DATA) {
    return { color:'#444', weight:1, fillOpacity:0, fillColor:'transparent', dashArray:'2,2' };
  }

  if(activeField && activeColor){
    const val = props[activeField.toUpperCase()] ?? 0;
    return { color:'#333', weight:1, fillOpacity:0.8, fillColor:getGradientColor(activeColor, val) };
  }

  // Default mixed coloring for “All Indicators”
  let r=0,g=0,b=0,total=0;
  legendItems.forEach(li => {
      if(li.dataset.field === 'all') return; 
      const val = props[li.dataset.field.toUpperCase()] ?? 0;
      const rgb = hexToRgb(li.dataset.color);
      r += rgb.r*val;
      g += rgb.g*val;
      b += rgb.b*val;
      total += val;
  });
  if(total===0) return { color:'#444', weight:1, fillOpacity:0, fillColor:'transparent', dashArray:'2,2' };
  return { color:'#333', weight:1, fillOpacity:0.8, fillColor:`rgb(${Math.round(r/total)},${Math.round(g/total)},${Math.round(b/total)})` };
}

// ===================== TOOLTIP + CHART =====================
function featureHandler(feature, layer) {
  const tooltip = document.getElementById('chart-tooltip');

  layer.on({
    mouseover(e) {
      const isMobile = window.innerWidth < 768;
      tooltip.style.display = 'block';
      tooltip.style.opacity = 1;
      tooltip.innerHTML = '';
      tooltip.style.padding = '8px';

      const barangayName = feature.properties.BARANGAY || 'Unknown';
      let labels = [], datasets = [];

      // HEADER: always show barangay name
      const title = document.createElement('div');
      title.className = 'tooltip-title';
      title.textContent = barangayName;
      title.style.fontWeight = 'bold';
      title.style.marginBottom = '6px';
      tooltip.appendChild(title);

      const indicators = legendItems.filter(li => li.dataset.field !== 'all');

      // Prepare chart data
      if (activeField && activeField !== 'all') {
        // SINGLE INDICATOR
        labels = getYears(barangayName);
        const values = labels.map(y => getValue(barangayName, y, activeField));
        datasets.push({
          label: activeLabel || activeField,
          data: values,
          borderColor: activeColor,
          backgroundColor: activeColor,
          tension: 0.3,
          borderWidth: 2,
          fill: false,
          spanGaps: true,
          pointRadius: 3
        });
      } else {
        // ALL INDICATORS
        labels = getYears(barangayName);
        indicators.forEach(li => {
          const values = labels.map(y => getValue(barangayName, y, li.dataset.field));
          datasets.push({
            label: li.dataset.label,
            data: values,
            borderColor: li.dataset.color,
            backgroundColor: li.dataset.color,
            tension: 0.3,
            borderWidth: 2,
            fill: false,
            spanGaps: true,
            pointRadius: 3
          });
        });
      }

      // MOBILE VIEW
      if (isMobile) {
        createChart('70vw', '120px', labels, datasets);

        // Only show indicator if single indicator is selected
        if (activeField && activeField !== 'all') {
          showSingleIndicator(barangayName, activeField, activeColor, labels);
        }
        return;
      }

      // DESKTOP VIEW
      createChart('300px', '150px', labels, datasets);

      // Desktop indicators
      if (activeField && activeField !== 'all') {
        showSingleIndicator(barangayName, activeField, activeColor, labels);
      } else {
        showAllIndicators(barangayName, indicators, labels);
      }

      // ===== Helper Functions =====
      function getYears(barangay) {
        if (activeYear === 'All') {
          return [...new Set(
            geoData.features
              .filter(f => f.properties.BARANGAY === barangay)
              .map(f => f.properties.YEAR)
          )].sort((a,b) => a - b);
        } else {
          return [activeYear];
        }
      }

      function getValue(barangay, year, field) {
        const f = geoData.features.find(ff =>
          ff.properties.BARANGAY === barangay && String(ff.properties.YEAR) === String(year)
        );
        return f ? Number(f.properties[field.toUpperCase()] ?? 0) : 0;
      }

      function createChart(width, height, labels, datasets) {
        const chartWrapper = document.createElement('div');
        chartWrapper.style.width = width;
        chartWrapper.style.height = height;
        chartWrapper.style.marginTop = '4px';
        tooltip.appendChild(chartWrapper);

        const canvas = document.createElement('canvas');
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        chartWrapper.appendChild(canvas);

        if (miniChart) miniChart.destroy();
        miniChart = new Chart(canvas, {
          type: activeYear === 'All' ? 'line' : 'bar',
          data: { labels, datasets },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { enabled: false }, datalabels: { display: false } },
            scales: { x: { display: true }, y: { display: true, min: 0, max: 100 } }
          },
          plugins: [ChartDataLabels]
        });
      }

      function showAllIndicators(barangay, indicators, years) {
        const indicatorsDiv = document.createElement('div');
        indicatorsDiv.style.marginTop = '4px';
        tooltip.appendChild(indicatorsDiv);

        indicators.forEach(li => {
          const values = years.map(y => getValue(barangay, y, li.dataset.field));
          const latestVal = values.filter(v => v !== null).pop() ?? 0;

          const line = document.createElement('div');
          line.className = 'tooltip-indicator-line';
          line.style.display = 'flex';
          line.style.alignItems = 'center';
          line.style.marginBottom = '2px';
          line.innerHTML = `
            <span class="color-box" style="background:${li.dataset.color};width:12px;height:12px;display:inline-block;margin-right:4px;border:1px solid #333;"></span>
            <span>${latestVal}%</span>
          `;
          indicatorsDiv.appendChild(line);
        });
      }

      function showSingleIndicator(barangay, field, color, years) {
        const values = years.map(y => getValue(barangay, y, field));
        const latestVal = values.filter(v => v !== null).pop() ?? 0;

        const indicatorsDiv = document.createElement('div');
        indicatorsDiv.style.marginTop = '4px';
        tooltip.appendChild(indicatorsDiv);

        const line = document.createElement('div');
        line.className = 'tooltip-indicator-line';
        line.style.display = 'flex';
        line.style.alignItems = 'center';
        line.style.marginBottom = '2px';
        line.innerHTML = `
          <span class="color-box" style="background:${color};width:12px;height:12px;display:inline-block;margin-right:4px;border:1px solid #333;"></span>
          <span>${latestVal}%</span>
        `;
        indicatorsDiv.appendChild(line);
      }

    },

    mouseout(e) {
      tooltip.style.opacity = 0;
      tooltip.style.display = 'none';
      tooltip.innerHTML = '';
      if (miniChart) miniChart.destroy();
    }
  });
}

// ===================== LEGEND CLICK =====================
legendItems.forEach(item => {
  item.addEventListener('click', () => {
    legendItems.forEach(li => li.classList.remove('active'));
    item.classList.add('active');

    const field = item.dataset.field;
    activeField = field === 'all' ? null : field;
    activeLabel = item.dataset.label;
    activeColor = field === 'all' ? '#888' : item.dataset.color;

    if (geoLayer) geoLayer.setStyle(styleFeature);
    if (activeColor && field !== 'all') updateGradientScale(activeColor);
    else document.getElementById('gradient-grid').innerHTML = '';
  });
});

// ===================== BARANGAY FILTER =====================
document.getElementById('barangayFilter').addEventListener('change', function(){
  const selected = this.value.toLowerCase();
  geoLayer.eachLayer(layer => {
    const name = layer.feature.properties.BARANGAY?.toLowerCase();
    layer.setStyle({
      ...styleFeature(layer.feature),
      opacity: (selected==='all'||selected===name)?1:0.3,
      fillOpacity: (selected==='all'||selected===name)?0.7:0.1
    });
  });
});

// ===================== HELPERS =====================
function hexToRgb(hex){ const c=parseInt(hex.slice(1),16); return {r:(c>>16)&255,g:(c>>8)&255,b:c&255}; }
function getGradientColor(baseColor, value){
  if(value==null) return '#999';
  const ratio = Math.min(1, value/100);
  const rgb = hexToRgb(baseColor);
  const start = {r:190, g:190, b:180};
  const r = Math.round(start.r + (rgb.r - start.r) * ratio);
  const g = Math.round(start.g + (rgb.g - start.g) * ratio);
  const b = Math.round(start.b + (rgb.b - start.b) * ratio);
  return `rgb(${r},${g},${b})`;
}

// ===================== GRADIENT SCALE =====================
function updateGradientScale(baseColor) {
  const grid = document.getElementById('gradient-grid');
  if (!grid) return;
  grid.innerHTML = '';

  let activeCellIndex = null;

  // Create 10 gradient cells (1–10, 11–20, ..., 91–100)
  for (let i = 1; i <= 10; i++) {
    const minVal = (i - 1) * 10 + 0.000001; // >0
    const maxVal = i * 10;

    const cell = document.createElement('div');
    cell.className = 'gradient-cell';
    cell.style.background = getGradientColor(baseColor, maxVal); // color based on upper range
    cell.title = `${minVal.toFixed(0)}% - ${maxVal}%`;

    cell.addEventListener('mouseover', () => {
      cell.classList.add('active-gradient-cell');
      activeGradientRange = { min: minVal, max: maxVal };
      filterMapByGradient();
    });

    cell.addEventListener('mouseout', () => {
      cell.classList.remove('active-gradient-cell');
      activeGradientRange = null;
      filterMapByGradient();
    });

    cell.addEventListener('click', () => {
      if (activeCellIndex !== null && grid.children[activeCellIndex]) {
        grid.children[activeCellIndex].classList.remove('active-gradient-cell');
      }
      activeCellIndex = i - 1;
      cell.classList.add('active-gradient-cell');
      activeGradientRange = { min: minVal, max: maxVal };
      filterMapByGradient();
    });

    grid.appendChild(cell);
  }

  // No Data cell
  const noDataCell = document.createElement('div');
  noDataCell.className = 'gradient-cell';
  noDataCell.style.background = 'transparent';
  noDataCell.style.border = '1px dashed #333';
  noDataCell.title = 'No Data';

  noDataCell.addEventListener('mouseover', () => {
    noDataCell.classList.add('active-gradient-cell');
    activeGradientRange = 'nodata';
    filterMapByGradient();
  });
  noDataCell.addEventListener('mouseout', () => {
    noDataCell.classList.remove('active-gradient-cell');
    activeGradientRange = null;
    filterMapByGradient();
  });
  noDataCell.addEventListener('click', () => {
    if (activeCellIndex !== null && grid.children[activeCellIndex]) {
      grid.children[activeCellIndex].classList.remove('active-gradient-cell');
    }
    activeCellIndex = 10; // last cell = No Data
    noDataCell.classList.add('active-gradient-cell');
    activeGradientRange = 'nodata';
    filterMapByGradient();
  });

  grid.appendChild(noDataCell);
}

// ===================== FILTER BY GRADIENT =====================
function filterMapByGradient(){
  if(!geoLayer) return;

  geoLayer.eachLayer(layer => {
    const props = layer.feature.properties;
    if(!activeField) return layer.setStyle(styleFeature(layer.feature));

    let valRaw = props[activeField.toUpperCase()];
    let val = valRaw != null ? Number(valRaw) : null;

    // Treat 0 or missing as No Data
    if(val === 0 || val === null || props.NO_DATA === true) {
      val = null; // mark as No Data
    }

    let inRange = false;

    if(activeGradientRange === 'nodata'){
      inRange = val === null; // only truly missing or zero
    } else if(activeGradientRange){
      if(val !== null) {
        inRange = val >= activeGradientRange.min && val <= activeGradientRange.max;
      }
    } else {
      inRange = true;
    }

    layer.setStyle({
      ...styleFeature(layer.feature),
      fillOpacity: inRange ? 0.8 : 0.1,
      opacity: inRange ? 1 : 0.3
    });
  });
}

</script>


</body>
</html>