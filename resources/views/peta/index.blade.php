<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Rumah Sakit</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            max-width: 80%;
            margin: 20px auto;
            border: 2px solid #ccc;
            border-radius: 10px;
        }
        .form-container {
            max-width: 80%;
            margin: 20px auto;
            display: none;
        }
        .form-container input,
        .form-container textarea,
        .form-container button {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .button-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Rumah Sakit di Kabupaten Lampung Selatan</h1>
    <div id="map"></div>

    <!-- Tombol untuk menampilkan form -->
    <div class="button-container">
        <button id="add-data-button">Tambah Data Rumah Sakit</button>
    </div>

    <!-- Form untuk tambah/edit data -->
    <div class="form-container" id="form-container">
        <h3>Tambah/Edit Rumah Sakit</h3>
        <form id="hospital-form">
            <input type="hidden" id="hospital-id" />
            <input type="text" id="hospital-name" placeholder="Nama Rumah Sakit" required />
            <textarea id="hospital-address" placeholder="Alamat" required></textarea>
            <input type="text" id="hospital-type" placeholder="Jenis Rumah Sakit" required />
            <input type="number" id="hospital-capacity" placeholder="Kapasitas" required />
            <input type="text" id="hospital-coordinates" placeholder="Koordinat (lat,lng)" required />
            <button type="submit">Simpan</button>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-5.6, 105.65], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Fungsi untuk menampilkan data
        function loadHospitals() {
            fetch('/api/rumah-sakit')
                .then(response => response.json())
                .then(data => {
                    L.geoJSON(data, {
                        onEachFeature: function (feature, layer) {
                            layer.bindPopup(`
                                <b>${feature.properties.nama}</b><br>
                                Alamat: ${feature.properties.alamat}<br>
                                Jenis: ${feature.properties.jenis}<br>
                                Kapasitas: ${feature.properties.kapasitas} kamar<br>
                                <button onclick="editHospital(${feature.properties.id}, '${feature.properties.nama}', '${feature.properties.alamat}', '${feature.properties.jenis}', ${feature.properties.kapasitas}, '${JSON.stringify(feature.geometry)}')">Edit</button>
                                <button onclick="deleteHospital(${feature.properties.id})">Hapus</button>
                            `);
                        }
                    }).addTo(map);
                });
        }

        loadHospitals();

        // Menangani form submission
        document.getElementById('hospital-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('hospital-id').value;
            const coordinates = document.getElementById('hospital-coordinates').value.split(',').map(Number);

            const hospitalData = {
                nama: document.getElementById('hospital-name').value,
                alamat: document.getElementById('hospital-address').value,
                jenis: document.getElementById('hospital-type').value,
                kapasitas: document.getElementById('hospital-capacity').value,
                koordinat: JSON.stringify({ type: "Point", coordinates: [coordinates[1], coordinates[0]] })
            };

            fetch(id ? `/api/rumah-sakit/${id}` : '/api/rumah-sakit', {
                method: id ? 'PUT' : 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(hospitalData)
            }).then(() => {
                alert('Data berhasil disimpan!');
                location.reload();
            });
        });

        // Fungsi untuk edit data
        function editHospital(id, nama, alamat, jenis, kapasitas, geometry) {
            document.getElementById('hospital-id').value = id;
            document.getElementById('hospital-name').value = nama;
            document.getElementById('hospital-address').value = alamat;
            document.getElementById('hospital-type').value = jenis;
            document.getElementById('hospital-capacity').value = kapasitas;
            document.getElementById('hospital-coordinates').value = `${geometry.coordinates[1]},${geometry.coordinates[0]}`;
            document.getElementById('form-container').style.display = 'block';
        }

        // Fungsi untuk hapus data
        function deleteHospital(id) {
            fetch(`/api/rumah-sakit/${id}`, { method: 'DELETE' })
                .then(() => {
                    alert('Data berhasil dihapus!');
                    location.reload();
                });
        }

        // Menampilkan form tambah data
        document.getElementById('add-data-button').addEventListener('click', function () {
            document.getElementById('form-container').style.display = 'block';
            document.getElementById('hospital-id').value = '';
            document.getElementById('hospital-form').reset();
        });
    </script>
</body>
</html>
