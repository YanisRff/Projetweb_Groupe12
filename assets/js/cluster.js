document.addEventListener('DOMContentLoaded', function() {
    printMap();
});

function printMap() {
    ajaxRequest('GET', './php/request.php/cluster', function(rawData) {
        const clusterColors = {};

        const boatDataGrouped = rawData.reduce((acc, point) => {
            point.latitude = parseFloat(point.latitude);
            point.longitude = parseFloat(point.longitude);
            point.sog = parseFloat(point.sog);
            point.cog = parseFloat(point.cog);
            point.length = parseFloat(point.length);
            point.width = parseFloat(point.width);
            point.draft = parseFloat(point.draft);

            if (!clusterColors[point.cluster]) {
                clusterColors[point.cluster] = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
            }

            if (!acc[point.mmsi]) {
                acc[point.mmsi] = {
                    mmsi: point.mmsi,
                    name: point.name,
                    trajectory: []
                };
            }
            acc[point.mmsi].trajectory.push(point);
            return acc;
        }, {});

        const boatData = Object.values(boatDataGrouped);

        const data = [];

        const clusterGroupedData = {};
        boatData.forEach(boat => {
            boat.trajectory.sort((a, b) => new Date(a.basedatetime).getTime() - new Date(b.basedatetime).getTime());

            boat.trajectory.forEach(p => {
                if (typeof p.latitude === 'number' && typeof p.longitude === 'number' &&
                    p.latitude >= -90 && p.latitude <= 90 &&
                    p.longitude >= -180 && p.longitude <= 180) {

                    if (!clusterGroupedData[p.cluster]) {
                        clusterGroupedData[p.cluster] = {
                            lats: [],
                            lons: [],
                            hoverTexts: []
                        };
                    }

                    clusterGroupedData[p.cluster].lats.push(p.latitude);
                    clusterGroupedData[p.cluster].lons.push(p.longitude);
                    clusterGroupedData[p.cluster].hoverTexts.push(
                        `<b>Nom:</b> ${p.name}<br>` +
                        `<b>MMSI:</b> ${p.mmsi}<br>` +
                        `<b>Date/Heure:</b> ${new Date(p.basedatetime).toLocaleString()}<br>` +
                        `<b>Latitude:</b> ${p.latitude.toFixed(5)}<br>` +
                        `<b>Longitude:</b> ${p.longitude.toFixed(5)}<br>` +
                        `<b>Vitesse (SOG):</b> ${p.sog} nœuds<br>` +
                        `<b>Cap (COG):</b> ${p.cog}°<br>` +
                        `<b>Cap (Heading):</b> ${p.heading === 511 ? 'Inconnu' : p.heading + '°'}<br>` +
                        `<b>Longueur:</b> ${p.length} m<br>` +
                        `<b>Largeur:</b> ${p.width} m<br>` +
                        `<b>Tirant d'eau:</b> ${p.draft} m<br>` +
                        `<b>Cluster:</b> ${p.cluster}`
                    );
                } else {
                    console.warn(`Coordonnées invalides pour MMSI ${p.mmsi} à la position ${p.id_pos}: lat ${p.latitude}, lon ${p.longitude}`);
                }
            });
        });

        for (const clusterId in clusterGroupedData) {
            const clusterInfo = clusterGroupedData[clusterId];
            const color = clusterColors[clusterId];

            if (clusterInfo.lats.length === 0) {
                console.warn(`Aucun point valide pour le cluster ${clusterId}. La trace ne sera pas affichée.`);
                continue;
            }

            data.push({
                type: 'scattermapbox',
                mode: 'lines',
                lat: clusterInfo.lats,
                lon: clusterInfo.lons,
                name: `Cluster ${clusterId}`,
                line: {
                    color: color,
                    width: 2
                },
                showlegend: true
            });

            data.push({
                type: 'scattermapbox',
                mode: 'markers',
                lat: clusterInfo.lats,
                lon: clusterInfo.lons,
                name: `Cluster ${clusterId} - Points`,
                marker: {
                    size: 8,
                    color: color,
                    symbol: 'circle'
                },
                text: clusterInfo.hoverTexts,
                hoverinfo: 'text',
                showlegend: false
            });
        }

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
                center: {
                    lat: centerLat,
                    lon: centerLon
                },
                zoom: 7
            },
            margin: {
                r: 0,
                t: 0,
                b: 0,
                l: 0
            },
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

        Plotly.newPlot('clusterMap', data, layout);
    });
}
