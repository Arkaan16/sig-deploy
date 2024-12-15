<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rumah Sakit</title>

    <!-- Menyertakan Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    <!-- Menyertakan Tailwind CSS untuk styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        #map { height: 500px; } /* Ukuran map */
    </style>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-xl font-bold mb-4">Tambah Rumah Sakit</h1>
        
        <!-- Peta Leaflet -->
        <div id="map"></div>

        <!-- Formulir untuk menambahkan Rumah Sakit -->
        <form id="addPointForm" method="POST" action="/peta" enctype="multipart/form-data" class="mt-4 space-y-4 bg-white p-6 rounded shadow-md">
            @csrf
            <div>
                <label for="namobj" class="block text-sm font-medium text-gray-700">Nama Rumah Sakit</label>
                <input type="text" name="namobj" id="namobj" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="remark" class="block text-sm font-medium text-gray-700">Jenis Rumah Sakit</label>
                <input type="text" name="remark" id="remark" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>

            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md cursor-pointer">
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="alamat" id="alamat" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Tambah Rumah Sakit</button>
        </form>
    </div>

    <!-- Menyertakan Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Inisialisasi peta dan set koordinat awal
        var map = L.map('map').setView([-5.727431, 105.596359], 13);

        // Menambahkan layer peta OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Menambahkan marker untuk setiap rumah sakit
        // Menambahkan marker untuk setiap rumah sakit
@foreach ($rs as $rsItem)
    var fotoUrl = "{{ Storage::url($rsItem->foto) }}"; // Mengambil URL foto dari storage
    var popupContent = "<b>{{ $rsItem->namobj }}</b><br>{{ $rsItem->remark }}<br>{{ $rsItem->alamat }}";
    
    // Jika foto ada, tampilkan di popup
    if (fotoUrl) {
        popupContent += "<br><img src='" + fotoUrl + "' alt='Foto Rumah Sakit' style='width: 100px; height: auto;'>";
    }

    L.marker([{{ $rsItem->latitude }}, {{ $rsItem->longitude }}])
        .addTo(map)
        .bindPopup(popupContent);
@endforeach


        var marker;

        // Menangani klik pada peta
        map.on('click', function(e) {
            // Jika marker sudah ada, pindahkan ke lokasi baru
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                // Jika belum ada marker, buat marker baru
                marker = L.marker(e.latlng).addTo(map);
            }

            // Menyimpan koordinat yang diklik ke dalam input tersembunyi
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>

</body>
</html>
