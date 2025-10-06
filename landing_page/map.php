<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNO NutriMap</title>
    <!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<style>
  body { margin:0;}
  #map { height: 640px; }

  #legend-buttons li {
    padding: 6px 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    font-family: sans-serif;
  }
  #legend-buttons li:last-child { border-bottom: none; }
  #legend-buttons li:hover { background: #f0f0f0; }

  .gradient-wrapper {
    
    bottom: 0;
    left: 50%;
    width: 90%;
    max-width: 970px;
    background: white;
    border: 1px solid #aaa;
    border-radius: 6px;
    padding: 9px;
    text-align: left;
    font-family: sans-serif;
   
  }
  .gradient-grid {
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    border: 1px solid #aaa;
    border-radius: 4px;
    overflow: hidden;
    height: 20px;
    margin-bottom: 6px;
  }
  .gradient-cell { height: 40px; border-right: 1px solid #aaa; }
  .gradient-cell:last-child { border-right: none; }
  .gradient-labels {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
  }

  /* Header */
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
    /* Footer Styles */
    .footer {
  background-color: #1f2937; /* gray-800 */
  color: #d1d5db; /* gray-300 */
  padding: 2.5rem 0;
  margin-top: auto;
  position: relative;
  z-index: 10;
}

.footer-container {
  max-width: 72rem;
  margin: 0 auto;
  padding: 0 1rem;
}

.footer-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 2rem;
}

@media (min-width: 768px) {
  .footer-grid {
    grid-template-columns: repeat(5, 1fr);
  }
  .footer-logo {
    grid-column: span 2 / span 2;
  }
}

.footer-logo {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.logo-text {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.logo-primary {
  font-size: 1.5rem;
  font-weight: bold;
  color: #00a0a0;
}

.logo-secondary {
  font-size: 1.5rem;
  font-weight: bold;
  margin-left: 0.25rem;
  color: #fff;
}

.footer-desc {
  font-size: 0.875rem;
}

.footer-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #fff;
  margin-bottom: 1rem;
}

.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 0.5rem;
}

.footer-links a {
  color: #d1d5db;
  text-decoration: none;
  transition: color 0.2s;
}

.footer-links a:hover {
  color: #00a0a0;
}

.footer-bottom {
  margin-top: 2rem;
  border-top: 1px solid #374151; /* gray-700 */
  padding-top: 2rem;
  text-align: center;
}

.footer-bottom p {
  color: #9ca3af; /* gray-400 */
  font-size: 0.875rem;
}
</style>
<body >

  <!-- HEADER -->
    <header class="header">
        <div class="logo">
            <span class="cno-color">CNO</span><span class="logo-space"></span><span>NutriMap</span>
        </div>
        <nav class="nav">
            <a href="../index.php" class="nav-link home-btn">Home</a>
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
            <a href="../login.php" class="nav-link login-btn">Login</a>
        </nav>
    </header>


    <!-- Main Content Section -->
  <main class="max-w-7xl mx-auto p-6 bg-white shadow mt-4 mb-28">
     <div class="bg-gray-200 py-3 px-4">
    <span class="uppercase tracking-wide text-[#00a0a0] font-semibold">Data</span>
  </div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
      <h1 class="text-lg md:text-xl font-semibold">
        El Salvador Health and Nutrition Map: Share of children who are stunted
      </h1>
      <div class="flex flex-wrap gap-4 mt-4 md:mt-0">
        <div>
          <label class="block text-sm font-medium text-gray-600">Select Year</label>
       <select id="yearFilter" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
            <option value="All">All</option>
            <option value="2025">2025</option>
            <option value="2024">2024</option>
       </select>

        </div>
        <div>
          <!-- Full Barangay list -->
          <label class="block text-sm font-medium text-gray-600">Select Barangay</label>
          <select id="barangayFilter" class="mt-1 block w-48 rounded border-gray-300 shadow-sm">
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
    <li data-field="ind7b1_pct" data-label="Severly Underweight" data-color="#8b0202"><span class="w-4 h-4 mr-2 bg-red-600 inline-block"></span>Severly Underweight</li>
    <li data-field="ind7b2_pct" data-label="Underweight" data-color="#ce6402"><span class="w-4 h-4 mr-2 bg-orange-500 inline-block"></span>Underweight</li>
    <li data-field="ind7b3_pct" data-label="Normal" data-color="#338b09"><span class="w-4 h-4 mr-2 bg-green-500 inline-block"></span>Normal</li>
    <li data-field="ind7b4_pct" data-label="Severly Wasted" data-color="#05f5f5"><span class="w-4 h-4 mr-2 bg-cyan-400 inline-block"></span>Severly Wasted</li>
    <li data-field="ind7b5_pct" data-label="Wasted" data-color="#ffef0e"><span class="w-4 h-4 mr-2 bg-yellow-400 inline-block"></span>Wasted</li>
    <li data-field="ind7b6_pct" data-label="Overweight" data-color="#694c0d"><span class="w-4 h-4 mr-2 bg-yellow-800 inline-block"></span>Overweight</li>
    <li data-field="ind7b7_pct" data-label="Obese" data-color="#fc3c9c"><span class="w-4 h-4 mr-2 bg-pink-600 inline-block"></span>Obese</li>
    <li data-field="ind7b8_pct" data-label="Severly Stunted" data-color="#a00686"><span class="w-4 h-4 mr-2 bg-purple-600 inline-block"></span>Severly Stunted</li>
    <li data-field="ind7b9_pct" data-label="Stunted" data-color="#032c74"><span class="w-4 h-4 mr-2 bg-blue-500 inline-block"></span>Stunted</li>
  </ul>
</div>

    </div>
      <div class="gradient-wrapper" id="gradient-wrapper">
    <div class="gradient-grid" id="gradient-grid"></div>
    <div class="gradient-labels">
      <span>1–10</span><span>11–20</span><span>21–30</span><span>31–40</span>
      <span>41–50</span><span>51–60</span><span>61–70</span><span>71–80</span>
      <span>81–90</span><span>91–100</span>
    </div>
  </div>
  </main>

    <!-- Footer Section -->
<!-- footer.php -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Logo and Description -->
            <div class="footer-logo">
                <div class="logo-text">
                    <span class="logo-primary">CNO</span>
                    <span class="logo-secondary">NutriMap</span>
                </div>
                <p class="footer-desc">
                    A tool to visualize health and nutrition data for children in El Salvador City.
                </p>
            </div>
            <!-- Links Column 1 -->
            <div>
                <h3 class="footer-title">About Us</h3>
                <ul class="footer-links">
                    <li><a href="pages/about_us/mission.php">Our Mission</a></li>
                    <li><a href="pages/about_us/vision.php">Our Vision</a></li>
                    <li><a href="pages/about_us/history.php">History</a></li>
                </ul>
            </div>
            <!-- Links Column 2 -->
            <div>
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="pages/map_us/map.php">Map</a></li>
                    <li><a href="pages/contact_us/get_in_touch.php">Contact Us</a></li>
                    <li><a href="pages/contact_us/downloadable_form.php">Downloadable Forms</a></li>
                </ul>
            </div>
            <!-- Legal & Support Column -->
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

    <!-- Dropdown Script -->    
    <script>
        const aboutBtn = document.getElementById('about-dropdown-btn');
        const aboutMenu = document.getElementById('about-dropdown-menu');
        const aboutIcon = aboutBtn.querySelector('.fa-chevron-down');

        function toggleDropdown(button, menu, icon) {
            const isMenuVisible = menu.classList.contains('hidden');
            if (isMenuVisible) {
                menu.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Show dropdown on arrow click only
        aboutIcon.addEventListener('click', function(e) {
            e.preventDefault();
            toggleDropdown(aboutBtn, aboutMenu, aboutIcon);
        });

        // Allow About text to navigate to about.php
        aboutBtn.addEventListener('click', function(e) {
            if (e.target !== aboutIcon) {
                // Let the link work normally
            } else {
                e.preventDefault();
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!aboutBtn.contains(event.target) && !aboutMenu.contains(event.target)) {
                aboutMenu.classList.add('hidden');
                aboutIcon.classList.remove('rotate-180');
            }
        });
 </script>
    <!-- map script -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
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

let geoLayer;
let geoData;
let activeField = null;
let activeColor = null;
let activeYear  = 'All';

const legendItems = Array.from(document.querySelectorAll('#legend-buttons li'));

// -------- Fetch once --------
fetch('../landing_page/get_map_data.php')
  .then(r => r.json())
  .then(data => {
    geoData = data;
    drawLayer();   // draw all polygons once
  });

// -------- Draw entire collection --------
function drawLayer() {
  if (geoLayer) map.removeLayer(geoLayer);

  geoLayer = L.geoJSON(geoData, {
    style: feature => styleFeature(feature),
    onEachFeature: featureHandler
  }).addTo(map);
}

// Style logic
function styleFeature(feature) {
  const props = feature.properties;
  const yearOK = activeYear === 'All' || String(props.YEAR) === activeYear;

  if (activeField && activeColor) {
    const val = yearOK ? props[activeField.toUpperCase()] : null;
    return {
      color:'#333', weight:2, fillOpacity:0.7,
      fillColor: getGradientColor(activeColor, val)
    };
  }

  // default combined coloring (only if the feature’s year matches)
  if (activeYear !== 'All' && !yearOK) {
    return { color:'#333', weight:2, fillOpacity:0.2, fillColor:'#c0c0c0ff' };
  }

  let r = 0, g = 0, b = 0, total = 0;
  legendItems.forEach(li => {
    const val = props[li.dataset.field.toUpperCase()] ?? 0;
    const rgb = hexToRgb(li.dataset.color);
    r += rgb.r * val;
    g += rgb.g * val;
    b += rgb.b * val;
    total += val;
  });
  if(total === 0) return { color:'#333', weight:2, fillOpacity:0.2, fillColor:'#ccc' };
  return {
    color:'#333', weight:2, fillOpacity:0.2,
    fillColor:`rgb(${Math.round(r/total)},${Math.round(g/total)},${Math.round(b/total)})`
  };
}

function hexToRgb(hex){
  const c = parseInt(hex.slice(1),16);
  return { r:(c>>16)&255, g:(c>>8)&255, b:c&255 };
}

// Tooltip shows only if year matches (or All)
function featureHandler(feature, layer) {
  const name = feature.properties.BARANGAY || "Unknown";
  layer.on({
    mouseover(e) {
      const props = feature.properties;
      const yearOK = activeYear === 'All' || String(props.YEAR) === activeYear;
      let html = `<b>${name}</b><br>`;

      if (!yearOK) {
        html += 'No data for selected year';
      } else if (!activeField) {
        legendItems.forEach(li => {
          const val = props[li.dataset.field.toUpperCase()] ?? '0';
          html += `${li.dataset.label}: ${val}%<br>`;
        });
      } else {
        const li = document.querySelector(`#legend-buttons li[data-field="${activeField}"]`);
        const label = li ? li.dataset.label : activeField;
        const val = props[activeField.toUpperCase()] ?? 'No Data';
        html += `${label}: ${val}%`;
      }
      e.target.bindTooltip(html, { direction: 'center' }).openTooltip();
    },
    mouseout(e){ e.target.closeTooltip(); }
  });
}

// -------- Legend click --------
legendItems.forEach(li => {
  li.addEventListener('click', () => {
    activeField = li.dataset.field;
    activeColor = li.dataset.color;
    geoLayer.setStyle(styleFeature);
    updateGradientScale(activeColor);
  });
});

// -------- Filters --------
document.getElementById('barangayFilter').addEventListener('change', function () {
  const selected = this.value.toLowerCase();
  geoLayer.eachLayer(layer => {
    const name = layer.feature.properties.BARANGAY?.toLowerCase();
    layer.setStyle({
      ...styleFeature(layer.feature),
      opacity: (selected === 'all' || selected === name) ? 1 : 0.3,
      fillOpacity: (selected === 'all' || selected === name) ? 0.7 : 0.1
    });
  });
});

document.getElementById('yearFilter').addEventListener('change', function () {
  activeYear = this.value;
  geoLayer.setStyle(styleFeature);  // just restyle, no filtering
});

// -------- Helpers --------
function lighten(hex, amount){
  const num = parseInt(hex.slice(1),16);
  let r=(num>>16)&0xff, g=(num>>8)&0xff, b=num&0xff;
  r=Math.round(r+(255-r)*amount);
  g=Math.round(g+(255-g)*amount);
  b=Math.round(b+(255-b)*amount);
  return "#" + ((1<<24)+(r<<16)+(g<<8)+b).toString(16).slice(1).toUpperCase();
}

function getGradientColor(baseColor, value){
  if(value==null) return '#ccc';
  const ratio = Math.min(1,value/100);
  return lighten(baseColor,0.8*(1-ratio));
}

function updateGradientScale(baseColor){
  const grid = document.getElementById('gradient-grid');
  grid.innerHTML='';
  for(let i=0;i<10;i++){
    const val=(i+1)*11;
    const cell=document.createElement('div');
    cell.className='gradient-cell';
    cell.style.background=getGradientColor(baseColor,val);
    grid.appendChild(cell);
  }
}
</script>
</body>
</html>
