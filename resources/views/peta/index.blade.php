<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Rumah Sakit</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 500px; }
    </style>
</head>
<body>
    <h1>Rumah Sakit di Kabupaten Lampung Selatan</h1>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-5.6, 105.65], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        fetch('/api/rumah-sakit')
            .then(response => response.json())
            .then(data => {
                L.geoJSON(data, {
                    onEachFeature: function (feature, layer) {
                        if (feature.properties) {
                            layer.bindPopup(`
                                <b>${feature.properties.nama}</b><br>
                                Alamat: ${feature.properties.alamat}<br>
                                Jenis: ${feature.properties.jenis}<br>
                                Kapasitas: ${feature.properties.kapasitas} kamar
                            `);
                        }
                    }
                }).addTo(map);
            });
    </script>
</body>
</html>
