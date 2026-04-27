// ===================== INITIALIZE MAP =====================
const map = L.map('map', {
  center: [8.4760268, 124.4809540],
  zoom: 11,
  zoomControl: true,
  dragging: true,
  scrollWheelZoom: true,
  doubleClickZoom: true,
  boxZoom: true,
  touchZoom: true
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data &copy; OpenStreetMap contributors'
}).addTo(map);

// ===================== VARIABLES =====================
let geoLayer, geoData;
let activeField = null, activeColor = null, activeLabel = null;
let activeBarangay = 'all';
let miniChart = null;
let miniChartCanvas = null;
let activeGradientRange = null;
let currentView = 'percentage';
let currentChartType = 'line';
let periodSlider = null;
let allPeriods = [];
let activePeriodRange = { start: null, end: null };
let minPeriod, maxPeriod;
let sliderTimer = null;

// Lookup map: "BARANGAY|PERIOD" => properties object
// Built once after data loads — replaces repeated .find() inside render loops
let featureMap = {};

const legendItems  = Array.from(document.querySelectorAll('#legend-buttons li'));
const mapContainer = document.getElementById('mapContainer');
const chartContainer = document.getElementById('chartContainer');
let fullChart = null;

// ===================== HELPER FUNCTIONS =====================
function formatPeriodLabel(period) {
  if (!period) return '';
  const [year, month] = period.split('-');
  const monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  return `${monthNames[parseInt(month, 10) - 1]} ${year}`;
}

function formatFullPeriod(period) {
  if (!period) return '';
  const [year, month] = period.split('-');
  const monthNames = [
    'January','February','March','April','May','June',
    'July','August','September','October','November','December'
  ];
  return `${monthNames[parseInt(month, 10) - 1]} ${year}`;
}

function filterFeaturesByPeriodRange(features, startPeriod, endPeriod) {
  if (!startPeriod || !endPeriod) return features;
  return features.filter(f => {
    const p = f.properties.PERIOD;
    return p && p >= startPeriod && p <= endPeriod;
  });
}

function updateChartRangeDisplay(startPeriod, endPeriod) {
  const rangeDatesDisplay  = document.getElementById('rangeDatesDisplay');
  const periodCountDisplay = document.getElementById('periodCountDisplay');
  const rangeTypeBadge     = document.getElementById('rangeTypeBadge');

  if (rangeDatesDisplay) {
    if (startPeriod === endPeriod) {
      rangeDatesDisplay.textContent = formatFullPeriod(startPeriod);
      if (rangeTypeBadge) rangeTypeBadge.textContent = 'Single Period';
    } else {
      rangeDatesDisplay.textContent = `${formatFullPeriod(startPeriod)} → ${formatFullPeriod(endPeriod)}`;
      if (rangeTypeBadge) rangeTypeBadge.textContent = 'Multiple Periods';
    }
  }

  if (periodCountDisplay) {
    const startIdx = allPeriods.indexOf(startPeriod);
    const endIdx   = allPeriods.indexOf(endPeriod);
    const count    = endIdx - startIdx + 1;
    periodCountDisplay.textContent = `${count} ${count === 1 ? 'period' : 'periods'}`;
  }
}

// ===================== LOAD GEOJSON DATA =====================
fetch('../landing_page/get_map_data.php')
  .then(r => {
    if (!r.ok) throw new Error(`Server error: ${r.status}`);
    return r.json();
  })
  .then(data => {
    geoData = data;

    // Build the fast lookup map once
    featureMap = {};
    geoData.features.forEach(f => {
      const key = `${(f.properties.BARANGAY || '').toUpperCase().trim()}|${f.properties.PERIOD}`;
      featureMap[key] = f.properties;
    });

    if (data.allPeriods && data.allPeriods.length > 0) {
      allPeriods = data.allPeriods;
      minPeriod  = data.minPeriod;
      maxPeriod  = data.maxPeriod;

      updatePeriodDisplays(minPeriod, maxPeriod);
      updateChartRangeDisplay(minPeriod, maxPeriod);
      initCompactPeriodSlider();
    } else {
      console.error('No periods found in data');
    }

    activeBarangay  = 'all';
    activePeriodRange = { start: minPeriod, end: maxPeriod };

    drawLayer();
    renderFullChart();
  })
  .catch(err => {
    console.error('Error loading map data:', err);
    const mapEl = document.getElementById('map');
    if (mapEl) {
      mapEl.insertAdjacentHTML(
        'afterend',
        '<p style="color:red;padding:1rem;font-weight:bold;">Failed to load map data. Please refresh the page.</p>'
      );
    }
  });

function updatePeriodDisplays(startPeriod, endPeriod) {
  const startLabel = document.getElementById('compactStartPeriod');
  const endLabel   = document.getElementById('compactEndPeriod');
  if (startLabel) startLabel.textContent = formatPeriodLabel(startPeriod);
  if (endLabel)   endLabel.textContent   = formatPeriodLabel(endPeriod);
}

// ===================== INITIALIZE COMPACT PERIOD SLIDER =====================
function initCompactPeriodSlider() {
  if (!allPeriods.length) return;

  const sliderContainer = document.getElementById('compactPeriodSlider');
  if (!sliderContainer) {
    console.error('Compact slider container not found');
    return;
  }
  if (typeof noUiSlider === 'undefined') {
    console.error('noUiSlider not loaded');
    return;
  }

  if (sliderContainer.noUiSlider) {
    sliderContainer.noUiSlider.destroy();
  }

  noUiSlider.create(sliderContainer, {
    start: [0, allPeriods.length - 1],
    connect: true,
    step: 1,
    range: {
      min: 0,
      max: allPeriods.length - 1
    },
    tooltips: false,
    format: {
      to:   value => Math.round(value),
      from: value => Math.round(value)
    }
  });

  sliderContainer.noUiSlider.on('slide', values => {
    const startIdx    = Math.round(values[0]);
    const endIdx      = Math.round(values[1]);
    const startPeriod = allPeriods[startIdx];
    const endPeriod   = allPeriods[endIdx];

    // Update labels instantly — lightweight, no jank
    updatePeriodDisplays(startPeriod, endPeriod);
    updateChartRangeDisplay(startPeriod, endPeriod);

    // Debounce the heavy map + chart redraw so it only fires
    // 200ms after the user stops dragging
    clearTimeout(sliderTimer);
    sliderTimer = setTimeout(() => {
      activePeriodRange = { start: startPeriod, end: endPeriod };
      drawLayer();
      renderFullChart();
    }, 200);
  });

  periodSlider = sliderContainer;
}

// ===================== DRAW LAYER =====================
function drawLayer() {
  if (!geoData) return;

  if (geoLayer) map.removeLayer(geoLayer);

  let features = geoData.features;

  if (activePeriodRange.start && activePeriodRange.end) {
    features = filterFeaturesByPeriodRange(features, activePeriodRange.start, activePeriodRange.end);
  }

  if (activeBarangay !== 'all') {
    features = features.filter(f =>
      (f.properties.BARANGAY || '').trim().toLowerCase() === activeBarangay
    );
  }

  geoLayer = L.geoJSON({ type: 'FeatureCollection', features }, {
    style:         styleFeature,
    onEachFeature: featureHandler
  }).addTo(map);

  applyLegendFilter();
}

// ===================== STYLE FEATURES =====================
function styleFeature(feature) {
  const props = feature.properties;

  if (activeField && activeColor) {
    const val = props[activeField.toUpperCase()];
    if (!val || val === 0 || props.NO_APPROVED_DATA === true) {
      return { color: '#444', weight: 1, fillOpacity: 0, fillColor: 'transparent', dashArray: '2,2' };
    }
    let step = Math.floor(val / 2);
    if (step < 0) step = 0;
    if (step > 9) step = 9;
    return { color: '#000', weight: 2, fillOpacity: 0.8, fillColor: getGradientColor(activeColor, step + 1) };
  }

  const hasData = legendItems.some(li =>
    li.dataset.field !== 'all' && (props[li.dataset.field.toUpperCase()] ?? 0) > 0
  );
  return hasData
    ? { color: '#333', weight: 1, fillOpacity: 0.8, fillColor: '#000' }
    : { color: '#444', weight: 1, fillOpacity: 0,   fillColor: 'transparent', dashArray: '2,2' };
}

// ===================== FEATURE HANDLER =====================
function featureHandler(feature, layer) {
  const tooltip     = document.getElementById('chart-tooltip');
  const barangayName = feature.properties.BARANGAY || 'Unknown';

  layer.on({
    mouseover() {
      const isMobile = window.innerWidth < 768;
      tooltip.style.display = 'block';
      tooltip.style.opacity = 1;
      tooltip.innerHTML     = '';
      tooltip.style.padding = '8px';

      const title = document.createElement('div');
      title.textContent  = barangayName;
      title.style.cssText = 'font-weight:bold;font-size:14px;margin-bottom:6px;';
      tooltip.appendChild(title);

      const indicatorsToShow = activeField
        ? legendItems.filter(li => li.dataset.field.toUpperCase() === activeField)
        : legendItems.filter(li => li.dataset.field !== 'all');

      const hasData = indicatorsToShow.some(li => {
        const val = feature.properties[li.dataset.field.toUpperCase()] ?? 0;
        return val > 0;
      });

      if (!hasData) {
        const noDataMsg = document.createElement('div');
        noDataMsg.textContent   = '⚠ No data available';
        noDataMsg.style.cssText = 'color:black;font-weight:normal;';
        tooltip.appendChild(noDataMsg);
        return;
      }

      // Use fast lookup instead of scanning all features
      const filteredPeriods = allPeriods.filter(p =>
        p >= activePeriodRange.start && p <= activePeriodRange.end &&
        featureMap[`${barangayName.toUpperCase().trim()}|${p}`]
      );

      const chartType = filteredPeriods.length > 1 ? 'line' : 'bar';

      const datasets = indicatorsToShow.map(li => {
        const data = filteredPeriods.map(p => {
          const props = featureMap[`${barangayName.toUpperCase().trim()}|${p}`];
          return props ? Number(props[li.dataset.field.toUpperCase()] ?? 0) : 0;
        });
        return {
          label:           li.dataset.label,
          data,
          borderColor:     li.dataset.color,
          backgroundColor: li.dataset.color,
          fill:            chartType === 'bar',
          tension:         0.3,
          borderWidth:     2,
          pointRadius:     3
        };
      });

      const labels = filteredPeriods.map(p => formatPeriodLabel(p));

      // Reuse the mini chart canvas instead of destroying + recreating
      const chartWidth  = isMobile ? '50vw'  : '200px';
      const chartHeight = isMobile ? '100px' : '150px';

      if (!miniChartCanvas) {
        const chartWrapper     = document.createElement('div');
        chartWrapper.style.cssText = `width:${chartWidth};height:${chartHeight};margin-top:4px;`;
        miniChartCanvas        = document.createElement('canvas');
        miniChartCanvas.style.cssText = 'width:100%;height:100%;';
        chartWrapper.appendChild(miniChartCanvas);
        tooltip.appendChild(chartWrapper);
      } else {
        tooltip.appendChild(miniChartCanvas.parentElement);
      }

      if (miniChart) {
        miniChart.data.labels   = labels;
        miniChart.data.datasets = datasets;
        miniChart.config.type   = chartType;
        miniChart.update();
      } else {
        miniChart = new Chart(miniChartCanvas, {
          type: chartType,
          data: { labels, datasets },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend:      { display: false },
              tooltip:     { enabled: false },
              datalabels:  { display: false }
            },
            scales: {
              x: { display: true },
              y: { beginAtZero: true, max: 20, ticks: { callback: val => val + '%', stepSize: 2 } }
            }
          },
          plugins: [ChartDataLabels]
        });
      }

      // Indicator value list below chart
      const indicatorList        = document.createElement('ul');
      indicatorList.style.cssText = 'list-style:none;padding:0;margin-top:6px;';

      indicatorsToShow.forEach(li => {
        const latestPeriod = filteredPeriods[filteredPeriods.length - 1];
        const props        = featureMap[`${barangayName.toUpperCase().trim()}|${latestPeriod}`];
        const value        = props ? Number(props[li.dataset.field.toUpperCase()] ?? 0) : 0;

        const liItem         = document.createElement('li');
        liItem.style.cssText = 'display:flex;align-items:center;margin-bottom:4px;';

        const colorBox         = document.createElement('span');
        colorBox.style.cssText = `width:12px;height:12px;background:${li.dataset.color};display:inline-block;margin-right:6px;`;

        const text         = document.createElement('span');
        text.textContent   = `${li.dataset.label}: ${value.toFixed(2)}%`;
        text.style.fontSize = '12px';

        liItem.appendChild(colorBox);
        liItem.appendChild(text);
        indicatorList.appendChild(liItem);
      });

      tooltip.appendChild(indicatorList);
    },

    mouseout() {
      tooltip.style.opacity = 0;
      tooltip.style.display = 'none';
      tooltip.innerHTML     = '';
      miniChartCanvas       = null;
      if (miniChart) {
        miniChart.destroy();
        miniChart = null;
      }
    }
  });
}

// ===================== VIEW TOGGLE BUTTONS =====================
const chartContainerDiv = document.getElementById('chartContainer');
if (chartContainerDiv) {
  const toggleButtonContainer = document.createElement('div');
  toggleButtonContainer.className = 'flex justify-center gap-4 mb-4';
  toggleButtonContainer.innerHTML = `
    <button id="btnPercentageView" class="px-4 py-2 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
      📊 Percentage View (0-20%)
    </button>
    <button id="btnTotalSumView" class="px-4 py-2 text-sm bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
      📈 Total Sum View (City Overall)
    </button>
  `;
  chartContainerDiv.insertBefore(toggleButtonContainer, chartContainerDiv.firstChild);
}

// Chart Type Toggle
const chartViewLine = document.getElementById('chartViewLine');
const chartViewBar  = document.getElementById('chartViewBar');

if (chartViewLine && chartViewBar) {
  chartViewLine.addEventListener('click', () => {
    currentChartType = 'line';
    chartViewLine.classList.add('active');
    chartViewBar.classList.remove('active');
    renderFullChart();
  });
  chartViewBar.addEventListener('click', () => {
    currentChartType = 'bar';
    chartViewBar.classList.add('active');
    chartViewLine.classList.remove('active');
    renderFullChart();
  });
}

// Percentage / Total Sum Toggle
const btnPercentageView = document.getElementById('btnPercentageView');
const btnTotalSumView   = document.getElementById('btnTotalSumView');

if (btnPercentageView && btnTotalSumView) {
  btnPercentageView.addEventListener('click', () => {
    currentView = 'percentage';
    btnPercentageView.classList.replace('bg-gray-500', 'bg-blue-500');
    btnTotalSumView.classList.replace('bg-blue-500', 'bg-gray-500');
    renderFullChart();
  });
  btnTotalSumView.addEventListener('click', () => {
    currentView = 'totalSum';
    btnTotalSumView.classList.replace('bg-gray-500', 'bg-blue-500');
    btnPercentageView.classList.replace('bg-blue-500', 'bg-gray-500');
    renderFullChart();
  });
}

// ===================== LEGEND =====================
legendItems.forEach(item => {
  item.addEventListener('click', () => {
    legendItems.forEach(li => li.classList.remove('active'));
    item.classList.add('active');
    activeField = item.dataset.field === 'all' ? null : item.dataset.field.toUpperCase();
    activeLabel = item.dataset.label;
    activeColor = item.dataset.color;

    applyLegendFilter();
    if (activeField) updateGradientScale(activeColor);
    else document.getElementById('gradient-grid').innerHTML = '';
    renderFullChart();
  });
});

// ===================== APPLY LEGEND FILTER =====================
function applyLegendFilter() {
  if (!geoLayer) return;
  geoLayer.eachLayer(layer => {
    const props = layer.feature.properties;
    let show = true;
    if (activeField) {
      const val = props[activeField.toUpperCase()] ?? 0;
      show = val > 0;
    }
    layer.setStyle({
      ...styleFeature(layer.feature),
      opacity:     show ? 1   : 0.3,
      fillOpacity: show ? 0.7 : 0.1,
      weight:      show ? 2   : 1
    });
  });
}

// ===================== BARANGAY SELECT =====================
const barangayFilter = document.getElementById('barangayFilter');
if (barangayFilter) {
  barangayFilter.addEventListener('change', e => {
    activeBarangay = e.target.value.trim().toLowerCase();
    drawLayer();
    renderFullChart();
  });
}

// ===================== CHART FLIP =====================
function flipToChart() {
  if (mapContainer)   mapContainer.classList.add('flipped');
  if (chartContainer) {
    chartContainer.classList.remove('hidden');
    chartContainer.classList.add('flipped');
  }
  renderFullChart();
}

function flipToMap() {
  if (mapContainer)   mapContainer.classList.remove('flipped');
  if (chartContainer) {
    chartContainer.classList.add('hidden');
    chartContainer.classList.remove('flipped');
  }
}

const btnMapView   = document.getElementById('btnMapView');
const btnChartView = document.getElementById('btnChartView');

if (btnMapView)   btnMapView.addEventListener('click',   flipToMap);
if (btnChartView) btnChartView.addEventListener('click', () => { flipToChart(); renderFullChart(); });

// ===================== GRADIENT =====================
function hexToRgb(hex) {
  const c = parseInt(hex.slice(1), 16);
  return { r: (c >> 16) & 255, g: (c >> 8) & 255, b: c & 255 };
}

function getGradientColor(baseColor, value) {
  if (value == null) return '#999';
  const ratio = Math.min(1, value / 9);
  const rgb   = hexToRgb(baseColor);
  const start = { r: 240, g: 240, b: 240 };
  const r = Math.round(start.r + (rgb.r - start.r) * ratio);
  const g = Math.round(start.g + (rgb.g - start.g) * ratio);
  const b = Math.round(start.b + (rgb.b - start.b) * ratio);
  return `rgb(${r},${g},${b})`;
}

function updateGradientScale(baseColor) {
  const grid = document.getElementById('gradient-grid');
  if (!grid) return;
  grid.innerHTML = '';

  for (let i = 0; i < 10; i++) {
    const min  = i * 2;
    const max  = min + 1;
    const cell = document.createElement('div');
    cell.className      = 'gradient-cell';
    cell.style.background = getGradientColor(baseColor, i + 1);
    cell.title          = `${min}% – ${max}%`;
    cell.addEventListener('mouseover', () => { cell.classList.add('active-gradient-cell');    activeGradientRange = { min, max }; filterMapByGradient(); });
    cell.addEventListener('mouseout',  () => { cell.classList.remove('active-gradient-cell'); activeGradientRange = null;         filterMapByGradient(); });
    cell.addEventListener('click',     () => { activeGradientRange = { min, max };             filterMapByGradient(); });
    grid.appendChild(cell);
  }

  const noDataCell = document.createElement('div');
  noDataCell.className      = 'gradient-cell';
  noDataCell.style.background = 'transparent';
  noDataCell.style.border   = '1px dashed #333';
  noDataCell.title          = 'No Data';
  noDataCell.addEventListener('mouseover', () => { activeGradientRange = 'nodata'; filterMapByGradient(); });
  noDataCell.addEventListener('mouseout',  () => { activeGradientRange = null;     filterMapByGradient(); });
  noDataCell.addEventListener('click',     () => { activeGradientRange = 'nodata'; filterMapByGradient(); });
  grid.appendChild(noDataCell);
}

// ===================== FILTER BY GRADIENT =====================
function filterMapByGradient() {
  if (!geoLayer) return;
  geoLayer.eachLayer(layer => {
    const props = layer.feature.properties;
    if (!activeField) return layer.setStyle(styleFeature(layer.feature));

    let val = props[activeField.toUpperCase()];
    val = (!val || val === 0 || props.NO_APPROVED_DATA === true) ? null : val;

    let inRange = false;
    if (activeGradientRange === 'nodata')   inRange = val === null;
    else if (activeGradientRange)           inRange = val !== null && val >= activeGradientRange.min && val <= activeGradientRange.max;
    else                                    inRange = true;

    layer.setStyle({
      ...styleFeature(layer.feature),
      fillOpacity: inRange ? (val === null ? 0 : 0.8) : 0.1,
      opacity:     inRange ? 1 : 0.3
    });
  });
}

// ===================== HELPER: COMPUTE DYNAMIC Y AXIS MAX =====================
function computeYMax(datasets, fallback) {
  const allValues = datasets.flatMap(ds => ds.data).filter(v => v != null && !isNaN(v));
  if (!allValues.length) return fallback || 20;
  const max = Math.max(...allValues, fallback || 5);
  return Math.ceil(max / 5) * 5;
}

// ===================== FULL CHART =====================
function renderFullChart() {
  if (!geoData) return;

  const canvas = document.getElementById('fullChartCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');

  if (fullChart) {
    fullChart.destroy();
    fullChart = null;
  }

  const allBarangays     = [...new Set(geoData.features.map(f => f.properties.BARANGAY))].sort();
  const isAllBarangays   = activeBarangay === 'all';
  const isSpecificBarangay = !isAllBarangays;

  let barangaysToShow = allBarangays;
  if (isSpecificBarangay) {
    barangaysToShow = allBarangays.filter(b => b.trim().toLowerCase() === activeBarangay);
  }

  const indicatorsToShow = activeField
    ? legendItems.filter(li => li.dataset.field.toUpperCase() === activeField)
    : legendItems.filter(li => li.dataset.field !== 'all');

  const periodsInRange    = allPeriods.filter(p => p >= activePeriodRange.start && p <= activePeriodRange.end);
  const hasMultiplePeriods = periodsInRange.length > 1;

  // Respect user's chart type choice; force line if too many periods for bars
  let chartType = currentChartType;
  if (hasMultiplePeriods && currentChartType === 'bar' && periodsInRange.length > 12) {
    chartType = 'line';
  }

  // ── TOTAL SUM VIEW ────────────────────────────────────────────────────────
  if (isAllBarangays && currentView === 'totalSum') {

    if (hasMultiplePeriods) {
      const datasets = indicatorsToShow.map(indicator => {
        const field = indicator.dataset.field.toUpperCase();
        const data  = periodsInRange.map(period => {
          let total = 0;
          allBarangays.forEach(b => {
            const props = featureMap[`${b.toUpperCase().trim()}|${period}`];
            if (props && props[field] != null && !isNaN(props[field])) {
              total += Number(props[field]);
            }
          });
          return total;
        });
        return {
          label:           indicator.dataset.label,
          data,
          borderColor:     indicator.dataset.color,
          backgroundColor: indicator.dataset.color,
          borderWidth:     2,
          pointRadius:     4,
          pointHoverRadius:6,
          tension:         0.3,
          fill:            false
        };
      });

      const yMax = computeYMax(datasets, 10);

      fullChart = new Chart(ctx, {
        type: chartType,
        data: { labels: periodsInRange.map(p => formatPeriodLabel(p)), datasets },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend:  { display: true, position: 'top' },
            tooltip: { callbacks: { label: c => `${c.dataset.label}: ${c.raw.toFixed(2)}%` } }
          },
          scales: {
            y: {
              beginAtZero: true,
              max: yMax,
              title: { display: true, text: 'Total Prevalence (%) – Sum of All Barangays', font: { weight: 'bold' } },
              ticks: { callback: val => val + '%', stepSize: Math.ceil(yMax / 10) }
            },
            x: {
              title: { display: true, text: 'Report Period', font: { weight: 'bold' } },
              ticks: { maxRotation: 45, minRotation: 45, autoSkip: true }
            }
          }
        }
      });

    } else {
      // Single period — bar per indicator, summed across all barangays
      const currentPeriod = periodsInRange[0];
      const cityTotalData = indicatorsToShow.map(indicator => {
        const field = indicator.dataset.field.toUpperCase();
        let total   = 0;
        allBarangays.forEach(b => {
          const props = featureMap[`${b.toUpperCase().trim()}|${currentPeriod}`];
          if (props && props[field] != null && !isNaN(props[field]) && props.NO_APPROVED_DATA !== true) {
            total += Number(props[field]);
          }
        });
        return total;
      });

      const yMax = computeYMax([{ data: cityTotalData }], 10);

      fullChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: indicatorsToShow.map(ind => ind.dataset.label),
          datasets: [{
            label:           '🏙️ City Overall Total (sum of all barangays)',
            data:            cityTotalData,
            backgroundColor: indicatorsToShow.map(ind => ind.dataset.color),
            borderColor:     indicatorsToShow.map(ind => ind.dataset.color),
            borderWidth:     2,
            borderRadius:    4,
            barPercentage:   0.7
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend:  { display: true, position: 'top' },
            tooltip: { callbacks: { label: c => `${c.dataset.label}: ${c.raw.toFixed(2)}%` } }
          },
          scales: {
            y: {
              beginAtZero: true,
              max: yMax,
              title: { display: true, text: 'Total Prevalence (%) – Sum of All Barangays', font: { weight: 'bold' } },
              ticks: { callback: val => val + '%', stepSize: Math.ceil(yMax / 10) }
            },
            x: { title: { display: true, text: 'Nutrition Indicators', font: { weight: 'bold' } } }
          }
        }
      });
    }

  // ── MULTIPLE PERIODS ──────────────────────────────────────────────────────
  } else if (hasMultiplePeriods) {

    let datasets;

    if (isAllBarangays) {
      // Average across all barangays per period
      datasets = indicatorsToShow.map(indicator => {
        const field = indicator.dataset.field.toUpperCase();
        const data  = periodsInRange.map(period => {
          let total = 0, count = 0;
          allBarangays.forEach(b => {
            const props = featureMap[`${b.toUpperCase().trim()}|${period}`];
            if (props && props[field] != null && !isNaN(props[field])) {
              total += Number(props[field]);
              count++;
            }
          });
          return count > 0 ? total / count : 0;
        });
        return {
          label:            indicator.dataset.label,
          data,
          borderColor:      indicator.dataset.color,
          backgroundColor:  indicator.dataset.color,
          borderWidth:      2,
          pointRadius:      4,
          pointHoverRadius: 6,
          tension:          0.3,
          fill:             false
        };
      });

    } else {
      // Specific barangay — one line per indicator across periods
      const selectedBarangay = barangaysToShow[0];
      datasets = indicatorsToShow.map(indicator => {
        const field = indicator.dataset.field.toUpperCase();
        const data  = periodsInRange.map(period => {
          const props = featureMap[`${(selectedBarangay || '').toUpperCase().trim()}|${period}`];
          return props ? Number(props[field] ?? 0) : 0;
        });
        return {
          label:            indicator.dataset.label,
          data,
          borderColor:      indicator.dataset.color,
          backgroundColor:  indicator.dataset.color,
          borderWidth:      2,
          pointRadius:      4,
          pointHoverRadius: 6,
          tension:          0.3,
          fill:             false
        };
      });
    }

    const yMax = computeYMax(datasets, 20);

    fullChart = new Chart(ctx, {
      type: chartType,
      data: { labels: periodsInRange.map(p => formatPeriodLabel(p)), datasets },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend:  { display: true, position: 'top' },
          tooltip: { callbacks: { label: c => `${c.dataset.label}: ${c.raw.toFixed(2)}%` } }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: yMax,
            title: { display: true, text: 'Prevalence (%)', font: { weight: 'bold' } },
            ticks: { callback: val => val + '%', stepSize: Math.ceil(yMax / 10) }
          },
          x: {
            title: { display: true, text: 'Report Period', font: { weight: 'bold' } },
            ticks: { maxRotation: 45, minRotation: 45, autoSkip: true }
          }
        }
      }
    });

  // ── SINGLE PERIOD + ALL BARANGAYS ─────────────────────────────────────────
  } else if (!hasMultiplePeriods && isAllBarangays) {

    const currentPeriod    = periodsInRange[0];

    const datasets = indicatorsToShow.map(indicator => {
      const field = indicator.dataset.field.toUpperCase();
      const data  = allBarangays.map(b => {
        const props = featureMap[`${b.toUpperCase().trim()}|${currentPeriod}`];
        return props ? Number(props[field] ?? 0) : 0;
      });
      return {
        label:           indicator.dataset.label,
        data,
        backgroundColor: indicator.dataset.color,
        borderColor:     indicator.dataset.color,
        borderWidth:     1,
        borderRadius:    4,
        barPercentage:   0.7
      };
    });

    const yMax = computeYMax(datasets, 20);

    fullChart = new Chart(ctx, {
      type: 'bar',
      data: { labels: allBarangays, datasets },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend:  { display: true, position: 'top' },
          tooltip: { callbacks: { label: c => `${c.dataset.label}: ${c.raw.toFixed(2)}%` } }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: yMax,
            title: { display: true, text: `Prevalence (%) – ${formatPeriodLabel(currentPeriod)}`, font: { weight: 'bold' } },
            ticks: { callback: val => val + '%', stepSize: Math.ceil(yMax / 10) }
          },
          x: {
            title: { display: true, text: 'Barangay', font: { weight: 'bold' } },
            ticks: { maxRotation: 45, minRotation: 45, autoSkip: true }
          }
        }
      }
    });

  // ── SINGLE PERIOD + SPECIFIC BARANGAY ─────────────────────────────────────
  } else if (!hasMultiplePeriods && isSpecificBarangay) {

    const selectedBarangay = barangaysToShow[0];
    const currentPeriod    = periodsInRange[0];
    const props            = featureMap[`${(selectedBarangay || '').toUpperCase().trim()}|${currentPeriod}`];

    const barangayData = indicatorsToShow.map(indicator => {
      const field = indicator.dataset.field.toUpperCase();
      return props ? Number(props[field] ?? 0) : 0;
    });

    const yMax = computeYMax([{ data: barangayData }], 20);

    fullChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: indicatorsToShow.map(ind => ind.dataset.label),
        datasets: [{
          label:           `${selectedBarangay} (${formatPeriodLabel(currentPeriod)})`,
          data:            barangayData,
          backgroundColor: indicatorsToShow.map(ind => ind.dataset.color),
          borderColor:     indicatorsToShow.map(ind => ind.dataset.color),
          borderWidth:     1,
          borderRadius:    4,
          barPercentage:   0.6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend:  { display: true, position: 'top' },
          tooltip: { callbacks: { label: c => `${c.dataset.label}: ${c.raw.toFixed(2)}%` } }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: yMax,
            title: { display: true, text: `Prevalence (%) – ${formatPeriodLabel(currentPeriod)}`, font: { weight: 'bold' } },
            ticks: { callback: val => val + '%', stepSize: Math.ceil(yMax / 10) }
          },
          x: { title: { display: true, text: 'Nutrition Indicators', font: { weight: 'bold' } } }
        }
      }
    });
  }
}