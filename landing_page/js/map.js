// ===================== INITIALIZE MAP =====================
const map = L.map('map', {
  center: [8.4760268, 124.4809540],
  zoom: 12,
  zoomControl: true,
  dragging: false,
  scrollWheelZoom: false,
  doubleClickZoom: false,
  boxZoom: false,
  touchZoom: false
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data © OpenStreetMap contributors'
}).addTo(map);

// FIX: make the map clickable/touchable for flip
map.getContainer().style.pointerEvents = 'auto';

// DESKTOP
map.on('click', flipToChart);

// MOBILE (prevents double trigger)
map.on('touchstart', (e) => {
  e.originalEvent.preventDefault();
  flipToChart();
});

// ===================== VARIABLES =====================
let geoLayer, geoData;
let activeField = null, activeColor = null, activeLabel = null;
let activeYear = 'All';
let miniChart = null;
let activeGradientRange = null;
const legendItems = Array.from(document.querySelectorAll('#legend-buttons li'));

let fullChart = null; // full chart instance
const mapContainer = document.getElementById('mapContainer');
const chartContainer = document.getElementById('chartContainer');
const realMap = document.getElementById('map'); // the actual map

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
  geoLayer = L.geoJSON(finalData, { style: styleFeature, onEachFeature: featureHandler }).addTo(map);
}

// ===================== STYLING =====================
function styleFeature(feature) {
  const props = feature.properties;

  if (activeField && activeColor) {
    const val = props[activeField.toUpperCase()];
    if (val === 0 || val == null || props.NO_DATA === true) {
      return { color: '#444', weight: 1, fillOpacity: 0, fillColor: 'transparent', dashArray: '2,2' };
    }
    return { color: '#333', weight: 1, fillOpacity: 0.8, fillColor: getGradientColor(activeColor, val) };
  }

  const hasData = legendItems.some(li => li.dataset.field !== 'all' && (props[li.dataset.field.toUpperCase()] ?? 0) > 0);

  return hasData
    ? { color: '#333', weight: 1, fillOpacity: 0.8, fillColor: '#000' }
    : { color: '#444', weight: 1, fillOpacity: 0, fillColor: 'transparent', dashArray: '2,2' };
}

// ===================== TOOLTIP + MINI CHART =====================
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
      const indicators = legendItems.filter(li => li.dataset.field !== 'all');

      const title = document.createElement('div');
      title.className = 'tooltip-title';
      title.textContent = barangayName;
      title.style.fontWeight = 'bold';
      title.style.marginBottom = '6px';
      tooltip.appendChild(title);

      // Prepare mini chart datasets
      let labels = [], datasets = [];
      labels = getYears(barangayName);
      if(activeField && activeField !== 'all'){
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

      createChart(isMobile?'70vw':'300px', isMobile?'120px':'150px', labels, datasets);

      function getYears(barangay){
        if(activeYear==='All'){
          return [...new Set(geoData.features.filter(f=>f.properties.BARANGAY===barangay).map(f=>f.properties.YEAR))].sort((a,b)=>a-b);
        } else return [activeYear];
      }

      function getValue(barangay, year, field){
        const f = geoData.features.find(ff=>ff.properties.BARANGAY===barangay && String(ff.properties.YEAR)===String(year));
        return f ? Number(f.properties[field.toUpperCase()] ?? 0) : 0;
      }

      function createChart(width, height, labels, datasets){
        const chartWrapper = document.createElement('div');
        chartWrapper.style.width = width;
        chartWrapper.style.height = height;
        chartWrapper.style.marginTop = '4px';
        tooltip.appendChild(chartWrapper);

        const canvas = document.createElement('canvas');
        canvas.style.width='100%';
        canvas.style.height='100%';
        chartWrapper.appendChild(canvas);

        if(miniChart) miniChart.destroy();
        miniChart = new Chart(canvas,{
          type: activeYear==='All'?'line':'bar',
          data:{labels,datasets},
          options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{ legend:{display:false}, tooltip:{enabled:false}, datalabels:{display:false} },
            scales:{ x:{display:true}, y:{display:true, min:0, max:100} }
          },
          plugins:[ChartDataLabels]
        });
      }
    },

    mouseout(e){
      tooltip.style.opacity=0; tooltip.style.display='none'; tooltip.innerHTML='';
      if(miniChart) miniChart.destroy();
    }
  });
}

// ===================== LEGEND + FILTERS =====================
legendItems.forEach(item => {
  item.addEventListener('click', () => {
    legendItems.forEach(li => li.classList.remove('active'));
    item.classList.add('active');

    activeField = item.dataset.field === 'all' ? null : item.dataset.field.toUpperCase();
    activeLabel = item.dataset.label;
    activeColor = item.dataset.color;

    if(geoLayer) geoLayer.setStyle(styleFeature);
    if(activeField) updateGradientScale(activeColor);
    else document.getElementById('gradient-grid').innerHTML = '';

    if(!chartContainer.classList.contains('hidden')) renderFullChart();
  });
});

document.getElementById('barangayFilter').addEventListener('change', () => {
  const selected = document.getElementById('barangayFilter').value.toLowerCase();
  geoLayer.eachLayer(layer => {
    const name = layer.feature.properties.BARANGAY?.toLowerCase();
    layer.setStyle({
      ...styleFeature(layer.feature),
      opacity: (selected === 'all' || selected === name) ? 1 : 0.3,
      fillOpacity: (selected === 'all' || selected === name) ? 0.7 : 0.1
    });
  });

  if(!chartContainer.classList.contains('hidden')) renderFullChart();
});


// ===================== FULL CHART =====================
mapContainer.classList.remove('flipped');
chartContainer.classList.add('hidden');

// ===================== FLIP HELPERS =====================
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

// ===================== RENDER FULL CHART =====================
function renderFullChart() {
  if (!geoData) return;

  const selectedBarangay = document.getElementById('barangayFilter').value.trim().toLowerCase();
  const selectedYear = document.getElementById('yearFilter').value.trim();

  const indicators = activeField 
    ? legendItems.filter(li => li.dataset.field.toUpperCase() === activeField)
    : legendItems.filter(li => li.dataset.field !== 'all');

  const filteredFeatures = geoData.features.filter(f => {
    const barangay = (f.properties.BARANGAY || '').trim().toLowerCase();
    const year = String(f.properties.YEAR || '');
    const matchesBarangay = selectedBarangay === 'all' || barangay === selectedBarangay;
    const matchesYear = selectedYear === 'All' || year === selectedYear;
    return matchesBarangay && matchesYear;
  });

  let labels = [];
  let datasets = [];
  let chartType = 'line';

  // ===================== MULTI-YEAR (LINE) =====================
  if (selectedYear === 'All') {
    chartType = 'line';
    labels = [...new Set(filteredFeatures.map(f => f.properties.YEAR))].sort((a, b) => a - b);

    indicators.forEach(li => {
      const field = li.dataset.field.toUpperCase();

      const data = labels.map(year => {
        if (selectedBarangay === 'all') {
          const vals = filteredFeatures
            .filter(f => String(f.properties.YEAR) == year)
            .map(f => Number(f.properties[field] || 0));
          return vals.length ? vals.reduce((a, b) => a + b, 0) / vals.length : 0;
        } else {
          const f = filteredFeatures.find(f => 
            (f.properties.BARANGAY || '').trim().toLowerCase() === selectedBarangay &&
            String(f.properties.YEAR) == year
          );
          return f ? Number(f.properties[field] || 0) : 0;
        }
      });

      datasets.push({
        label: li.dataset.label,
        data,
        borderColor: li.dataset.color,
        backgroundColor: li.dataset.color,
        borderWidth: 2,
        fill: false,
        tension: 0.3,
        pointRadius: 4,
        type: 'line'
      });
    });

  // ===================== SINGLE YEAR (BAR) =====================
  } else {
    chartType = 'bar';
    labels = selectedBarangay === 'all'
      ? [...new Set(filteredFeatures.map(f => f.properties.BARANGAY))].sort()
      : [selectedBarangay];

    indicators.forEach(li => {
      const field = li.dataset.field.toUpperCase();

      const data = labels.map(barangay => {
        const f = filteredFeatures.find(f =>
          (f.properties.BARANGAY || '').trim().toLowerCase() === barangay.toLowerCase()
        );
        return f ? Number(f.properties[field] || 0) : 0;
      });

      datasets.push({
        label: li.dataset.label,
        data,
        borderColor: li.dataset.color,
        backgroundColor: li.dataset.color,
        borderWidth: 2,
        fill: true,
        type: 'bar'
      });
    });
  }

  // ===================== RENDER CHART =====================
  const ctx = document.getElementById('fullChart').getContext('2d');

  if (fullChart) fullChart.destroy();

  fullChart = new Chart(ctx, {
    type: chartType,
    data: { labels, datasets },
    options: {
      responsive: true,
      maintainAspectRatio: false,  // 🔥 makes chart fit small screens
      plugins: { legend: { display: true } },
      scales: { y: { beginAtZero: true, max: 100 } }
    }
  });
}



// ===================== HELPERS =====================
function hexToRgb(hex){ const c=parseInt(hex.slice(1),16); return {r:(c>>16)&255,g:(c>>8)&255,b:c&255}; }
function getGradientColor(baseColor,value){
  if(value==null) return '#999';
  const ratio = Math.min(1,value/100);
  const rgb = hexToRgb(baseColor);
  const start = {r:190,g:190,b:180};
  const r = Math.round(start.r+(rgb.r-start.r)*ratio);
  const g = Math.round(start.g+(rgb.g-start.g)*ratio);
  const b = Math.round(start.b+(rgb.b-start.b)*ratio);
  return `rgb(${r},${g},${b})`;
}

// ===================== GRADIENT SCALE =====================
function updateGradientScale(baseColor) {
  const grid = document.getElementById('gradient-grid');
  if (!grid) return;
  grid.innerHTML = '';
  let activeCellIndex = null;

  for (let i = 1; i <= 10; i++) {
    const minVal = (i - 1) * 10 + 0.000001;
    const maxVal = i * 10;

    const cell = document.createElement('div');
    cell.className = 'gradient-cell';
    cell.style.background = getGradientColor(baseColor, maxVal);
    cell.title = `${minVal.toFixed(0)}% - ${maxVal}%`;

    cell.addEventListener('mouseover', () => { cell.classList.add('active-gradient-cell'); activeGradientRange={min:minVal,max:maxVal}; filterMapByGradient(); });
    cell.addEventListener('mouseout', () => { cell.classList.remove('active-gradient-cell'); activeGradientRange=null; filterMapByGradient(); });
    cell.addEventListener('click', () => { if(activeCellIndex!==null && grid.children[activeCellIndex]) grid.children[activeCellIndex].classList.remove('active-gradient-cell'); activeCellIndex=i-1; cell.classList.add('active-gradient-cell'); activeGradientRange={min:minVal,max:maxVal}; filterMapByGradient(); });

    grid.appendChild(cell);
  }

  const noDataCell = document.createElement('div');
  noDataCell.className='gradient-cell';
  noDataCell.style.background='transparent';
  noDataCell.style.border='1px dashed #333';
  noDataCell.title='No Data';
  noDataCell.addEventListener('mouseover', ()=>{noDataCell.classList.add('active-gradient-cell'); activeGradientRange='nodata'; filterMapByGradient();});
  noDataCell.addEventListener('mouseout', ()=>{noDataCell.classList.remove('active-gradient-cell'); activeGradientRange=null; filterMapByGradient();});
  noDataCell.addEventListener('click', ()=>{if(activeCellIndex!==null && grid.children[activeCellIndex]) grid.children[activeCellIndex].classList.remove('active-gradient-cell'); activeCellIndex=10; noDataCell.classList.add('active-gradient-cell'); activeGradientRange='nodata'; filterMapByGradient();});
  grid.appendChild(noDataCell);
}

// ===================== FILTER BY GRADIENT =====================
function filterMapByGradient(){
  if(!geoLayer) return;
  geoLayer.eachLayer(layer=>{
    const props=layer.feature.properties;
    if(!activeField) return layer.setStyle(styleFeature(layer.feature));

    let val = props[activeField.toUpperCase()];
    val = (val===0||val==null||props.NO_DATA===true)?null:val;

    let inRange=false;
    if(activeGradientRange==='nodata') inRange=val===null;
    else if(activeGradientRange) inRange=(val!==null && val>=activeGradientRange.min && val<=activeGradientRange.max);
    else inRange=true;

    layer.setStyle({ ...styleFeature(layer.feature), fillOpacity: inRange?(val===null?0:0.8):0.1, opacity: inRange?1:0.3 });
  });
}
