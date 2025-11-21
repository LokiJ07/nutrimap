// ===================== INITIALIZE MAP =====================
const map = L.map('map', {
  center: [8.4760268, 124.4809540], // default, will zoom later
  zoom: 12,
  zoomControl: true
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
let fullChart = null;

// ===================== LOAD GEOJSON DATA =====================
fetch('../landing_page/get_map_data.php')
  .then(r => r.json())
  .then(data => {
    geoData = data;

    // Populate Year dropdown
    const years = [...new Set(geoData.features.map(f => f.properties.YEAR).filter(y => y))].sort((a,b)=>b-a);
    const yearSelect = document.getElementById('yearFilter');
    yearSelect.innerHTML = '';
    const allOpt = document.createElement('option');
    allOpt.value = 'All';
    allOpt.textContent = 'All Years';
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
      if(!chartContainer.classList.contains('hidden')) renderFullChart();
    });

    // ===================== SHOW ONLY LOGGED-IN BARANGAY =====================
    if (typeof loggedInBarangay !== 'undefined' && loggedInBarangay) {
      highlightUserBarangay(loggedInBarangay.toUpperCase());
    }
  })
  .catch(err => console.error('Error loading map data:', err));

// ===================== DRAW LAYER =====================
function drawLayer(selectedYear) {
  if(!geoData) return;
  if(!selectedYear) selectedYear = activeYear;
  if(geoLayer) map.removeLayer(geoLayer);

  let mergedFeatures = [];

  if(selectedYear === 'All') {
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

  // Add missing barangays
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
  geoLayer = L.geoJSON(finalData, { style: styleFeature }).addTo(map);

  // ✅ Highlight the logged-in user's barangay AFTER layer is added
  if (typeof loggedInBarangay !== 'undefined' && loggedInBarangay) {
    highlightUserBarangay(loggedInBarangay.toUpperCase());
  }
}

// ===================== STYLE FEATURE =====================
function styleFeature(feature) {
  const props = feature.properties;

  if (activeField && activeColor) {
    let val = props[activeField.toUpperCase()];
    if (val === 0 || val == null || props.NO_DATA === true) {
      return { color: '#444', weight: 1, fillOpacity: 0, fillColor: 'transparent', dashArray: '2,2' };
    }
    let step = Math.floor(val / 2);
    step = Math.min(9, Math.max(0, step));
    return { color: '#000', weight: 2, fillOpacity: 0.8, fillColor: getGradientColor(activeColor, step + 1) };
  }

  const hasData = legendItems.some(li => li.dataset.field !== 'all' && (props[li.dataset.field.toUpperCase()] ?? 0) > 0);
  return hasData ? { color: '#333', weight: 1, fillOpacity: 0.8, fillColor: '#000' } : { color: '#444', weight: 1, fillOpacity: 0, fillColor: 'transparent', dashArray: '2,2' };
}

// ===================== HIGHLIGHT USER BARANGAY =====================
function highlightUserBarangay(barangayName) {
  let userBounds = null;

  geoLayer.eachLayer(layer => {
    const name = (layer.feature.properties.BARANGAY || '').toUpperCase();
    if (name === barangayName) {
      userBounds = layer.getBounds();

      map.fitBounds(userBounds, { padding: [20, 20] });
      layer.setStyle({ ...styleFeature(layer.feature), weight: 3, fillOpacity: 0.7, opacity: 1 });

      // Show chart automatically
      flipToChart();
    } else {
      layer.setStyle({ ...styleFeature(layer.feature), weight: 1, fillOpacity: 0.1, opacity: 0.3 });
    }
  });

  if (userBounds) {
    // Restrict map to user's barangay bounds
    map.setMaxBounds(userBounds);
    map.setMinZoom(map.getZoom());
    map.options.maxZoom = map.getZoom() + 5;
  }
}

// ===================== HEX TO RGB & GRADIENT =====================
function hexToRgb(hex){ const c=parseInt(hex.slice(1),16); return {r:(c>>16)&255,g:(c>>8)&255,b:c&255}; }
function getGradientColor(baseColor,value){
  if(value==null) return '#999';
  const ratio = Math.min(1,value/9);
  const rgb = hexToRgb(baseColor);
  const start = { r: 240, g: 240, b: 240 };
  const r = Math.round(start.r+(rgb.r-start.r)*ratio);
  const g = Math.round(start.g+(rgb.g-start.g)*ratio);
  const b = Math.round(start.b+(rgb.b-start.b)*ratio);
  return `rgb(${r},${g},${b})`;
}

// ===================== FLIP HELPERS =====================
const mapContainer = document.getElementById('mapContainer');
const chartContainer = document.getElementById('chartContainer');
function flipToChart() {
  mapContainer.classList.add('flipped');
  chartContainer.classList.remove('hidden');
  chartContainer.classList.add('flipped');
  renderFullChart();
}
function flipToMap() {
  mapContainer.classList.remove('flipped');
  chartContainer.classList.add('hidden');
  chartContainer.classList.remove('flipped');
}
chartContainer.addEventListener('click', flipToMap);
chartContainer.addEventListener('touchstart', e => { e.preventDefault(); flipToMap(); }, { passive: false });

// ===================== RENDER FULL CHART =====================
function renderFullChart() {
  if (!geoData) return;

  const selectedBarangay = loggedInBarangay.toLowerCase();
  const selectedYear = document.getElementById('yearFilter').value.trim();
  const indicators = activeField ? legendItems.filter(li => li.dataset.field.toUpperCase() === activeField) : legendItems.filter(li => li.dataset.field !== 'all');
  const filteredFeatures = geoData.features.filter(f => (f.properties.BARANGAY || '').trim().toLowerCase() === selectedBarangay && (selectedYear === 'All' || String(f.properties.YEAR) === selectedYear));

  let labels = selectedYear === 'All' ? [...new Set(filteredFeatures.map(f=>f.properties.YEAR))].sort((a,b)=>a-b) : [selectedYear];
  let datasets = indicators.map(li => {
    const field = li.dataset.field.toUpperCase();
    const data = labels.map(y => {
      const f = filteredFeatures.find(f => String(f.properties.YEAR) === String(y));
      return f ? Number(f.properties[field] || 0) : 0;
    });
    return { label: li.dataset.label, data, borderColor: li.dataset.color, backgroundColor: li.dataset.color, borderWidth: 2, fill: true, type: 'bar' };
  });

  const ctx = document.getElementById('fullChart').getContext('2d');
  if (fullChart) fullChart.destroy();
  fullChart = new Chart(ctx, { type: 'bar', data: { labels, datasets }, options: { responsive:true, maintainAspectRatio:false } });
}
