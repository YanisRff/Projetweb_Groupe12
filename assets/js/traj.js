let type = null;

document.addEventListener('DOMContentLoaded', function () {
    addFilter();
});

function addFilter() {
    const filter = document.getElementById('filter');

    const menu = document.createElement('select');
    menu.id = 'menu';

    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = '--Choose an option--';
    menu.appendChild(defaultOption);

    filter.appendChild(menu);

    menu.addEventListener('change', function () {
        ajaxRequest('GET', './php/request.php/getBoat?MMSI=' + menu.value, function(data){
          
          ajaxRequest('GET', './php/request.php/type?length=' + data[data.length - 1].length + '&width=' + data[data.length - 1].width + '&draft=' + data[data.length - 1].draft, function(response){
            type = response;

            for (let i = 0; i < 5; i++) {
              ajaxRequest('GET', './php/request.php/nextPred?latitude=' + data[data.length - 1].latitude + '&longitude=' + data[data.length - 1].longitude + '&sog=' + data[data.length - 1].sog + '&cog=' + data[data.length - 1].cog + '&heading=' + data[data.length - 1].heading + '&type=' + type + '&length=' + data[data.length - 1].length + '&width=' + data[data.length - 1].width + '&draft=' + data[data.length - 1].draft,function(response){
                data.push({ mmsi: data[data.length - 1].mmsi, name: data[data.length - 1].name, length: data[data.length - 1].length, width: data[data.length - 1].width, draft: data[data.length - 1].draft, 
                  basedatetime: ((d => d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0') + ' ' + String(d.getHours()).padStart(2,'0') + ':' + String(d.getMinutes()).padStart(2,'0') + ':' + String(d.getSeconds()).padStart(2,'0'))(new Date(new Date((data[data.length - 1].basedatetime).replace(' ', 'T')).getTime() + 5*60*1000))),
                  latitude: response.latitude, longitude: response.longitude, sog: data[data.length - 1].sog, cog: data[data.length - 1].cog, heading:data[data.length - 1].heading, status: data[data.length - 1].status, prediction: 'True'
                });
              });
            }

            let talk = document.getElementById('type');
            let talking = document.createElement('h2');
            if(parseInt(type) === 60){
              talking.textContent = 'Ce navire est de type : Passager (60)';
            }
            if(type == '70'){
              talking.textContent = 'Ce navire est de type : Cargo (70)';
            }
            if(type == '80'){
              talking.textContent = 'Ce navire est de type : Tanker (80)';
            }
            else{
              talking.textContent = 'Ce navire est de type : Inconnu (' + type +')';
            }
            talk.appendChild(talking);

            printMap(data, type);
            
          });
        });
    });

    ajaxRequest('GET', './php/request.php/getMMSI', function (data) {
        data.forEach(entry => {
            if ('mmsi' in entry) {
                const option = document.createElement('option');
                option.value = entry.mmsi;
                option.textContent = entry.mmsi;
                menu.appendChild(option);
            }
        });
    });
}


function printMap(rawData, type){
  const boatDataGrouped = rawData.reduce((acc, point) => {
            point.latitude = parseFloat(point.latitude);
            point.longitude = parseFloat(point.longitude);
            point.sog = parseFloat(point.sog);
            point.cog = parseFloat(point.cog);
            point.length = parseFloat(point.length);
            point.width = parseFloat(point.width);
            point.draft = parseFloat(point.draft);

            if (!acc[point.mmsi]) {
                acc[point.mmsi] = {
                    mmsi: point.mmsi,
                    name: point.name,
                    color: '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0'), // Couleur aléatoire hexadécimale
                    trajectory: []
                };
            }
            acc[point.mmsi].trajectory.push(point);
            return acc;
        }, {});

        const boatData = Object.values(boatDataGrouped);

        const data = [];

        boatData.forEach(boat => {
            boat.trajectory.sort((a, b) => new Date(a.basedatetime).getTime() - new Date(b.basedatetime).getTime());

            const lats = [];
            const lons = [];
            const hoverTexts = [];

            boat.trajectory.forEach(p => {
                if (typeof p.latitude === 'number' && typeof p.longitude === 'number' &&
                    p.latitude >= -90 && p.latitude <= 90 &&
                    p.longitude >= -180 && p.longitude <= 180) {
                    lats.push(p.latitude);
                    lons.push(p.longitude);

                    hoverTexts.push(
                        `<b>Nom:</b> ${p.name}<br>` +
                        `<b>MMSI:</b> ${p.mmsi}<br>` +
                        `<b>VesselType:</b> ${type}<br>` +
                        `<b>Date/Heure:</b> ${new Date(p.basedatetime).toLocaleString()}<br>` +
                        `<b>Latitude:</b> ${p.latitude.toFixed(5)}<br>` +
                        `<b>Longitude:</b> ${p.longitude.toFixed(5)}<br>` +
                        `<b>Vitesse (SOG):</b> ${p.sog} nœuds<br>` +
                        `<b>Cap (COG):</b> ${p.cog}°<br>` +
                        `<b>Cap (Heading):</b> ${p.heading === 511 ? 'Inconnu' : p.heading + '°'}<br>` +
                        `<b>Longueur:</b> ${p.length} m<br>` +
                        `<b>Largeur:</b> ${p.width} m<br>` +
                        `<b>Tirant d'eau:</b> ${p.draft} m`
                    );
                } else {
                    console.warn(`Coordonnées invalides pour MMSI ${p.mmsi} à la position ${p.id_pos}: lat ${p.latitude}, lon ${p.longitude}`);
                }
            });

            if (lats.length === 0) {
                console.warn(`Aucun point valide pour le bateau ${boat.name} (MMSI: ${boat.mmsi}). La trace ne sera pas affichée.`);
                return;
            }

            data.push({
                type: 'scattermapbox',
                mode: 'lines',
                lat: lats,
                lon: lons,
                name: `${boat.name} (${boat.mmsi})`,
                line: {
                    color: boat.color,
                    width: 2
                },
                showlegend: true
            });

            data.push({
                type: 'scattermapbox',
                mode: 'markers',
                lat: lats,
                lon: lons,
                name: `${boat.name} (${boat.mmsi}) - Points`,
                marker: {
                    size: 8,
                    color: boat.color,
                    symbol: 'circle'
                },
                text: hoverTexts,
                hoverinfo: 'text',
                showlegend: false
            });
        });

        let centerLat = 0;
        let centerLon = 0;
        let validPointsCount = 0;

        rawData.forEach(p => {
            const lat = parseFloat(p.latitude);
            const lon = parseFloat(p.longitude);
            if (!isNaN(lat) && !isNaN(lon) && lat >= -90 && lat <= 90 && lon >= -180 && lon <= 180) {
                centerLat += lat;
                centerLon += lon;
                validPointsCount++;
            }
        });

        if (validPointsCount > 0) {
            centerLat /= validPointsCount;
            centerLon /= validPointsCount;
        } else {
            centerLat = 27.5;
            centerLon = -82.5;
        }


        const layout = {
            mapbox: {
                style: 'open-street-map',
                center: { lat: centerLat, lon: centerLon },
                zoom: 7
            },
            margin: { r: 0, t: 0, b: 0, l: 0 },
            showlegend: true,
            legend: {
                x: 0.01,
                y: 0.99,
                xanchor: 'left',
                yanchor: 'top',
                bgcolor: 'rgba(255, 255, 255, 0.7)',
                bordercolor: '#ccc',
                borderwidth: 1
            },
            hovermode: 'closest'
        };

        Plotly.newPlot('trajMap', data, layout);
}

