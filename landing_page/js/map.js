// ===================== INITIALIZE MAP =====================
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

  // Treat 0 or missing as No Data
  const valKeys = Object.keys(props);
  let val;
  if(activeField && activeColor){
    val = props[activeField.toUpperCase()];
    if(val === 0 || val == null || props.NO_DATA === true) {
      return { color:'#444', weight:1, fillOpacity:0, fillColor:'transparent', dashArray:'2,2' };
    }
    return { color:'#333', weight:1, fillOpacity:0.8, fillColor:getGradientColor(activeColor, val) };
  }

  // Default mixed coloring for “All Indicators”
  let r=0,g=0,b=0,total=0;
  legendItems.forEach(li => {
      if(li.dataset.field === 'all') return; 
      const v = props[li.dataset.field.toUpperCase()];
      if(v === 0 || v == null) return; // skip zero/no data
      const rgb = hexToRgb(li.dataset.color);
      r += rgb.r*v;
      g += rgb.g*v;
      b += rgb.b*v;
      total += v;
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
      fillOpacity: inRange ? (val === null ? 0 : 0.8) : 0.1,
      opacity: inRange ? 1 : 0.3
    });
  });
}