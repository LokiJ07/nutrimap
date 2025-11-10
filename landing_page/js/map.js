// ===================== DROPDOWN =====================
const aboutBtn = document.querySelector('.dropdown-link');
const aboutMenu = document.querySelector('.dropdown-content');
const aboutIcon = aboutBtn.querySelector('.dropdown-arrow');

function toggleDropdown(button, menu, icon) {
    const isMenuVisible = !menu.classList.contains('hidden');
    if(isMenuVisible){
        menu.classList.add('hidden');
        icon.classList.remove('rotate-180');
    } else {
        menu.classList.remove('hidden');
        icon.classList.add('rotate-180');
    }
}

aboutIcon.addEventListener('click', function(e){
    e.preventDefault();
    toggleDropdown(aboutBtn, aboutMenu, aboutIcon);
});

aboutBtn.addEventListener('click', function(e){
    if(e.target !== aboutIcon) return;
    e.preventDefault();
});

document.addEventListener('click', (event)=>{
    if(!aboutBtn.contains(event.target) && !aboutMenu.contains(event.target)){
        aboutMenu.classList.add('hidden');
        aboutIcon.classList.remove('rotate-180');
    }
});

// ===================== MAP INITIALIZATION =====================
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

let geoLayer, geoData;
let activeField = null, activeColor = null, activeLabel = null;
let activeYear = 'All';
let miniChart = null;
let activeGradientRange = null;
const legendItems = Array.from(document.querySelectorAll('#legend-buttons li'));

// ===================== LOAD GEOJSON =====================
fetch('../landing_page/get_map_data.php')
    .then(r => r.json())
    .then(data=>{
        geoData = data;
        // Populate Year Dropdown
        const years = [...new Set(geoData.features.map(f => f.properties.YEAR).filter(y => y && y !== ''))].sort((a,b)=>b-a);
        const yearSelect = document.getElementById('yearFilter');
        yearSelect.innerHTML='';
        const allOpt = document.createElement('option');
        allOpt.value='All';
        allOpt.textContent='All Years';
        yearSelect.appendChild(allOpt);
        years.forEach(y=>{
            const opt = document.createElement('option');
            opt.value=y;
            opt.textContent=y;
            yearSelect.appendChild(opt);
        });
        activeYear='All';
        yearSelect.value='All';
        drawLayer(activeYear);

        yearSelect.addEventListener('change', e=>{
            activeYear = e.target.value;
            drawLayer(activeYear);
        });
    }).catch(err=>console.error('Error loading map data:', err));

// ===================== DRAW GEO LAYER =====================
function drawLayer(selectedYear){
    if(!geoData) return;
    if(!selectedYear) selectedYear = activeYear;
    if(geoLayer) map.removeLayer(geoLayer);

    let mergedFeatures = [];

    if(selectedYear==='All'){
        const barangayMap = new Map();
        geoData.features.forEach(f=>{
            const b = f.properties.BARANGAY?.toUpperCase();
            const year = parseInt(f.properties.YEAR || 0);
            if(!barangayMap.has(b) || year > (barangayMap.get(b).properties.YEAR || 0)){
                barangayMap.set(b, f);
            }
        });
        mergedFeatures = Array.from(barangayMap.values());
    } else {
        mergedFeatures = geoData.features.filter(f=>f.properties.YEAR==selectedYear);
    }

    // Add missing barangays
    const barangayWithData = new Set(mergedFeatures.map(f=>f.properties.BARANGAY?.toUpperCase()));
    const allBarangays = geoData.features.map(f=>f.properties.BARANGAY?.toUpperCase());
    [...new Set(allBarangays)].forEach(b=>{
        if(!barangayWithData.has(b)){
            const base = geoData.features.find(f=>f.properties.BARANGAY?.toUpperCase()===b);
            if(base){
                const clone = JSON.parse(JSON.stringify(base));
                clone.properties.NO_DATA = true;
                mergedFeatures.push(clone);
            }
        }
    });

    const finalData = {type:"FeatureCollection", features: mergedFeatures};
    geoLayer = L.geoJSON(finalData, {style: styleFeature, onEachFeature: featureHandler}).addTo(map);
}

// ===================== STYLE FEATURES =====================
function styleFeature(feature){
    const props = feature.properties;
    if(props.NO_DATA) return {color:'#444', weight:1, fillOpacity:0, fillColor:'transparent', dashArray:'2,2'};

    if(activeField && activeColor){
        const val = props[activeField.toUpperCase()] ?? 0;
        return {color:'#333', weight:1, fillOpacity:0.8, fillColor:getGradientColor(activeColor,val)};
    }

    // Default mixed coloring for all
    let r=0,g=0,b=0,total=0;
    legendItems.forEach(li=>{
        if(li.dataset.field==='all') return;
        const val = props[li.dataset.field.toUpperCase()] ?? 0;
        const rgb = hexToRgb(li.dataset.color);
        r+=rgb.r*val; g+=rgb.g*val; b+=rgb.b*val; total+=val;
    });
    if(total===0) return {color:'#444', weight:1, fillOpacity:0, fillColor:'transparent', dashArray:'2,2'};
    return {color:'#333', weight:1, fillOpacity:0.8, fillColor:`rgb(${Math.round(r/total)},${Math.round(g/total)},${Math.round(b/total)})`};
}

// ===================== TOOLTIP & CHART =====================
function featureHandler(feature, layer){
    const tooltip = document.getElementById('chart-tooltip');
    layer.on({
        mouseover(e){
            tooltip.style.display='block'; tooltip.style.opacity=1; tooltip.innerHTML='';
            const barangayName = feature.properties.BARANGAY || 'Unknown';
            let labels=[], datasets=[];

            const indicators = legendItems.filter(li=>li.dataset.field!=='all');
            const title = document.createElement('div');
            title.className='tooltip-title'; title.textContent=barangayName;
            tooltip.appendChild(title);

            if(activeField){
                const legendLabel = activeLabel || activeField;
                let value=0;
                if(activeYear==='All'){
                    const allYears = [...new Set(
                        geoData.features.filter(f=>f.properties.BARANGAY===barangayName).map(f=>f.properties.YEAR)
                    )].sort((a,b)=>a-b);

                    labels=allYears;
                    const values = allYears.map(y=>{
                        const f = geoData.features.find(ff=>ff.properties.BARANGAY===barangayName && String(ff.properties.YEAR)===String(y));
                        return f ? Number(f.properties[activeField.toUpperCase()] ?? null) : null;
                    });
                    value = values.filter(v=>v!==null).pop() ?? 0;
                    datasets.push({
                        label: legendLabel,
                        data: values,
                        borderColor: activeColor,
                        backgroundColor: activeColor,
                        tension:0.3,
                        borderWidth:2,
                        fill:false,
                        spanGaps:true,
                        pointRadius:3
                    });
                } else {
                    labels=[activeYear];
                    const f = geoData.features.find(ff=>ff.properties.BARANGAY===barangayName && String(ff.properties.YEAR)===String(activeYear));
                    value = f ? Number(f.properties[activeField.toUpperCase()] ?? 0) : 0;
                    datasets.push({label:legendLabel,data:[value],borderColor:activeColor,backgroundColor:activeColor,borderWidth:1});
                }
                const legendDiv=document.createElement('div');
                legendDiv.className='tooltip-indicator-line';
                legendDiv.innerHTML=`<span class="color-box" style="background:${activeColor};width:12px;height:12px;display:inline-block;margin-right:8px;border:1px solid #333;"></span><strong>${value}%</strong>`;
                tooltip.appendChild(legendDiv);
                const canvas=document.createElement('canvas');
                canvas.width=320; canvas.height=200;
                tooltip.appendChild(canvas);
                if(miniChart) miniChart.destroy();
                miniChart=new Chart(canvas,{type:activeYear==='All'?'line':'bar',data:{labels,datasets},options:{responsive:false,plugins:{legend:{display:false},tooltip:{enabled:false},datalabels:{display:false}},scales:{x:{display:activeYear==='All'},y:{display:false,min:0,max:100}}},plugins:[ChartDataLabels]});
                return;
            }

            // ALL INDICATORS
            const flexWrapper=document.createElement('div'); flexWrapper.className='tooltip-flex'; tooltip.appendChild(flexWrapper);
            const indicatorsDiv=document.createElement('div'); indicatorsDiv.style.flex='1'; indicatorsDiv.style.fontSize='13px'; flexWrapper.appendChild(indicatorsDiv);
            const chartWrapper=document.createElement('div'); chartWrapper.style.flex='1'; flexWrapper.appendChild(chartWrapper);

            if(activeYear==='All'){
                const allYears=[...new Set(geoData.features.filter(f=>f.properties.BARANGAY===barangayName).map(f=>f.properties.YEAR))].sort((a,b)=>a-b);
                labels=allYears;
                indicators.forEach(li=>{
                    const field=li.dataset.field.toUpperCase(); const color=li.dataset.color;
                    const values = allYears.map(y=>{
                        const f = geoData.features.find(ff=>ff.properties.BARANGAY===barangayName && String(ff.properties.YEAR)===String(y));
                        return f ? Number(f.properties[field] ?? null) : null;
                    });
                    const latestVal = values.filter(v=>v!==null).pop() ?? 0;
                    datasets.push({label:li.dataset.label,data:values,borderColor:color,backgroundColor:color,tension:0.3,borderWidth:2,fill:false,spanGaps:true,pointRadius:3});
                    const line = document.createElement('div'); line.className='tooltip-indicator-line'; line.innerHTML=`<span class="color-box" style="background:${color};width:12px;height:12px;display:inline-block;margin-right:8px;border:1px solid #333;"></span><span>${latestVal}%</span>`;
                    indicatorsDiv.appendChild(line);
                });
            } else {
                labels = indicators.map(li=>li.dataset.label);
                const values = indicators.map(li=>{
                    const f = geoData.features.find(ff=>ff.properties.BARANGAY===barangayName && String(ff.properties.YEAR)===String(activeYear));
                    return f ? Number(f.properties[li.dataset.field.toUpperCase()] ?? 0) : 0;
                });
                const colors = indicators.map(li=>li.dataset.color);
                datasets.push({label:'Percentage',data:values,backgroundColor:colors,borderColor:colors,borderWidth:1});
                indicators.forEach((li,i)=>{
                    const val=values[i]; const color=li.dataset.color;
                    const line=document.createElement('div'); line.className='tooltip-indicator-line';
                    line.innerHTML=`<span class="color-box" style="background:${color};width:12px;height:12px;display:inline-block;margin-right:8px;border:1px solid #333;"></span><span>${val}%</span>`;
                    indicatorsDiv.appendChild(line);
                });
            }

            const canvas=document.createElement('canvas'); canvas.width=260; canvas.height=200; chartWrapper.appendChild(canvas);
            if(miniChart) miniChart.destroy();
            miniChart=new Chart(canvas,{type:activeYear==='All'?'line':'bar',data:{labels,datasets},options:{responsive:false,plugins:{legend:{display:false},tooltip:{enabled:false},datalabels:{display:false}},scales:{x:{display:activeYear==='All'},y:{display:false,min:0,max:100}}},plugins:[ChartDataLabels]});
        },
        mouseout(e){
            tooltip.style.opacity=0; tooltip.style.display='none'; tooltip.innerHTML='';
            if(miniChart) miniChart.destroy();
        }
    });
}

// ===================== LEGEND CLICK =====================
legendItems.forEach(item=>{
    item.addEventListener('click', ()=>{
        legendItems.forEach(li=>li.classList.remove('active'));
        item.classList.add('active');
        const field=item.dataset.field;
        activeField=field==='all'?null:field;
        activeLabel=item.dataset.label;
        activeColor=field==='all'?'#888':item.dataset.color;
        if(geoLayer) geoLayer.setStyle(styleFeature);
        if(activeColor && field!=='all') updateGradientScale(activeColor);
        else document.getElementById('gradient-grid').innerHTML='';
    });
});

// ===================== BARANGAY FILTER =====================
document.getElementById('barangayFilter').addEventListener('change', function(){
    const selected = this.value.toLowerCase();
    geoLayer.eachLayer(layer=>{
        const name = layer.feature.properties.BARANGAY?.toLowerCase();
        layer.setStyle({...styleFeature(layer.feature), opacity:(selected==='all'||selected===name)?1:0.3, fillOpacity:(selected==='all'||selected===name)?0.7:0.1});
    });
});

// ===================== HELPERS =====================
function hexToRgb(hex){ const c=parseInt(hex.slice(1),16); return {r:(c>>16)&255,g:(c>>8)&255,b:c&255}; }
function getGradientColor(baseColor, value){
    if(value==null) return '#999';
    const ratio = Math.min(1,value/100);
    const rgb=hexToRgb(baseColor);
    const start={r:190,g:190,b:180};
    const r=Math.round(start.r+(rgb.r-start.r)*ratio);
    const g=Math.round(start.g+(rgb.g-start.g)*ratio);
    const b=Math.round(start.b+(rgb.b-start.b)*ratio);
    return `rgb(${r},${g},${b})`;
}

// ===================== GRADIENT SCALE =====================
function updateGradientScale(baseColor){
    const grid=document.getElementById('gradient-grid'); if(!grid) return; grid.innerHTML='';
    let activeCellIndex=null;
    for(let i=0;i<10;i++){
        const minVal=i*10, maxVal=(i+1)*10, val=(i+1)*10;
        const cell=document.createElement('div'); cell.className='gradient-cell';
        cell.style.background=getGradientColor(baseColor,val); cell.title=`${minVal}% - ${maxVal}%`;
        cell.addEventListener('mouseover', ()=>{
            cell.classList.add('active-gradient-cell'); activeGradientRange={min:minVal,max:maxVal}; filterMapByGradient();
        });
        cell.addEventListener('mouseout', ()=>{
            cell.classList.remove('active-gradient-cell'); activeGradientRange=null;
            if(geoLayer) geoLayer.eachLayer(layer=>layer.setStyle(styleFeature(layer.feature)));
        });
        cell.addEventListener('click', ()=>{
            if(activeCellIndex!==null && grid.children[activeCellIndex]) grid.children[activeCellIndex].classList.remove('active-gradient-cell');
            activeCellIndex=i; cell.classList.add('active-gradient-cell'); activeGradientRange={min:minVal,max:maxVal}; filterMapByGradient();
        });
        grid.appendChild(cell);
    }
    const noDataCell=document.createElement('div'); noDataCell.className='gradient-cell'; noDataCell.style.background='transparent'; noDataCell.style.border='1px dashed #333'; noDataCell.title='No Data'; grid.appendChild(noDataCell);
}

// ===================== FILTER BY GRADIENT =====================
function filterMapByGradient(){
    if(!geoLayer) return;
    geoLayer.eachLayer(layer=>{
        if(!activeField) return layer.setStyle(styleFeature(layer.feature));
        const val=Number(layer.feature.properties[activeField.toUpperCase()] ?? 0);
        const inRange=activeGradientRange && val>=activeGradientRange.min && val<=activeGradientRange.max;
        layer.setStyle({...styleFeature(layer.feature), fillOpacity:inRange?0.8:0.1, opacity:inRange?1:0.3});
    });
}
