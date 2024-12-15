@extends('layouts.peta')

@section('title', 'Tambah Rumah Sakit')

@section('content')
<div class="flex">
    @include('components.sidebar') <!-- Memanggil Sidebar -->

    <div class="w-full flex-grow p-6">
        <h1 class="text-3xl font-bold text-black pb-6">Tambah Rumah Sakit</h1>

        <!-- Peta Leaflet -->
        <div id="map" class="mb-4 w-full" style="height: 500px;"></div>

        <!-- Tombol Cancel -->
        <button id="cancelButton" onclick="cancelMarker()" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-md">Batal</button>

        <!-- Formulir untuk menambahkan Rumah Sakit -->
        <form id="addPointForm" method="POST" action="{{ route('rumah-sakit.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4 bg-white p-6 rounded shadow-md">
            @csrf
            <div>
                <label for="namobj" class="block text-sm font-medium text-gray-700">Nama Rumah Sakit</label>
                <input type="text" name="namobj" id="namobj" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label for="remark" class="block text-sm font-medium text-gray-700">Jenis Rumah Sakit</label>
                <input type="text" name="remark" id="remark" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
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

            <div>
                <label for="geojson" class="block text-sm font-medium text-gray-700">Upload File GeoJSON</label>
                <input type="file" name="geojson" id="geojson" accept=".geojson" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md cursor-pointer">
            </div>

            <!-- Tombol Kembali dan Tombol Tambah Rumah Sakit -->
            <div class="flex mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md mr-2">
                    Tambah Rumah Sakit
                </button>
                <a href="{{ route('rumah-sakit.index') }}" 
                   class="inline-block px-4 py-2 bg-gray-600 text-white rounded-md">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Menyertakan Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([-5.727431, 105.596359], 13);

    // Menambahkan layer peta OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var isMarkerCreated = false;
    var currentMarker = null;
    var cancelButton = document.getElementById('cancelButton');
    var kecamatanGeoJsonLayers = {}; // Menyimpan data GeoJSON kecamatan

    // Menambahkan batas kecamatan dari file GeoJSON
    fetch('{{ asset("geojson/batas_kecamatan.geojson") }}')
        .then(response => response.json())
        .then(data => {
            L.geoJSON(data, {
                style: function(feature) {
                    return {
                        fillColor: getColorByKecamatan(feature.properties.NAMOBJ),
                        weight: 2,
                        opacity: 1,
                        color: 'white',
                        fillOpacity: 0.7
                    };
                },
                onEachFeature: function(feature, layer) {
                    kecamatanGeoJsonLayers[feature.properties.NAMOBJ] = layer; // Menyimpan layer kecamatan
                    // Menambahkan popup kecamatan
                    layer.on('click', function(e) {
                        e.target.openPopup();
                    });
                }
            }).addTo(map);
        })
        .catch(function(error) {
            console.error("Error loading GeoJSON:", error);
        });

    // Fungsi untuk mendapatkan warna berdasarkan kecamatan
    function getColorByKecamatan(kecamatanName) {
        var colors = {
            "RAJABASA": "#FF0000", // Merah untuk Rajabasa
                "SEKAMPUNG": "#FF6347", // Tomat untuk Sekampung
                "SEKAMPUNGUDIK": "#FFD700", // Emas untuk Sekampungudik
                "SIDOMULYO": "#32CD32", // Hijau lime untuk Sidomulyo
                "SRAGI": "#1E90FF", // Dodger blue untuk Sragi
                "SUKARAME": "#FF1493", // Deep pink untuk Sukarame
                "TANJUNGBINTANG": "#8A2BE2", // BlueViolet untuk Tanjungbintang
                "TANJUNGSARI": "#FF4500", // Oranye merah untuk Tanjungsari
                "TANJUNGSENANG": "#ADFF2F", // Green yellow untuk Tanjungsenang
                "TEGINENENG": "#D2691E", // Chocolate untuk Tegineneng
                "TRIMUPJO": "#000080", // Navy untuk Trimupjo
                "WAWAYKARYA": "#00BFFF", // Deep sky blue untuk Wawaykarya
                "WAYPANJI": "#8B0000", // Dark red untuk Waypanji
                "WAYSULAN": "#3CB371", // Medium sea green untuk Waysulan
                "GEDONGTATAAN": "#FF8C00", // Dark orange untuk Gedongtataan
                "JABUNG": "#8B4513", // Saddle brown untuk Jabung
                "JATIAGUNG": "#A52A2A", // Brown untuk Jatiagung
                "KALIANDA": "#0000FF", // Biru untuk Kalinda
                "KATIBUNG": "#DC143C", // Crimson untuk Katibung
                "KEMILING": "#FF6347", // Tomat untuk Kemiling
                "KETAPANG": "#FFD700", // Emas untuk Ketapang
                "MARGATIGA": "#32CD32", // Lime hijau untuk Margatiga
                "MERBAUMATARAM": "#FF1493", // Deep pink untuk Merbaumataram
                "METROKIBANG": "#1E90FF", // Dodger blue untuk Metrokibang
                "NATAR": "#8A2BE2", // BlueViolet untuk Natar
                "NEGERIKATON": "#00BFFF", // Deep sky blue untuk Negerikaton
                "PALAS": "#000080", // Navy untuk Palas
                "PANJANG": "#ADFF2F", // Green yellow untuk Panjang
                "PASIRSAKTI": "#FF4500", // Oranye merah untuk Pasirsakti
                "PENENGAHAN": "#FF00FF", // Fuchsia untuk Penengahan
                // Menambahkan kecamatan baru
                "BAKAUHENI": "#00FF00", // Hijau untuk Bakauheni
                "BATANGHARI": "#800080", // Ungu untuk Batanghari
                "CANDIPURO": "#FF69B4", // Hot pink untuk Candipuro
            // Tambahkan warna kecamatan lain sesuai dengan kebutuhan Anda
        };
        return colors[kecamatanName] || "#CCCCCC";
    }

    // Menangani klik pada peta untuk menambahkan marker
    map.on('click', function(e) {
        if (isMarkerCreated) {
            return; // Jangan buat marker baru jika sudah ada
        }

        // Menyimpan koordinat yang diklik ke dalam input tersembunyi
        document.getElementById('latitude').value = e.latlng.lat;
        document.getElementById('longitude').value = e.latlng.lng;

        // Menambahkan marker di titik yang diklik
        currentMarker = L.marker(e.latlng, {draggable: true}).addTo(map);
        currentMarker.on('dragend', function() {
            // Menyimpan koordinat yang dipindahkan ke dalam input tersembunyi
            document.getElementById('latitude').value = currentMarker.getLatLng().lat;
            document.getElementById('longitude').value = currentMarker.getLatLng().lng;
        });

        isMarkerCreated = true;
        cancelButton.style.display = 'block'; // Menampilkan tombol Cancel
    });

    // Fungsi untuk membatalkan penandaan titik
    function cancelMarker() {
        if (currentMarker) {
            map.removeLayer(currentMarker); // Menghapus marker yang telah dibuat
            currentMarker = null;
            document.getElementById('latitude').value = ''; // Mengosongkan input latitude
            document.getElementById('longitude').value = ''; // Mengosongkan input longitude
        }
        cancelButton.style.display = 'none'; // Menyembunyikan tombol Cancel
        isMarkerCreated = false; // Reset status marker
    }

    // Menambahkan marker untuk rumah sakit yang sudah ada
    @foreach ($rs as $rsItem)
        var fotoUrl = "{{ Storage::url($rsItem->foto) }}";
        var popupContent = "<b>{{ $rsItem->namobj }}</b><br>{{ $rsItem->remark }}<br>{{ $rsItem->alamat }}";

        if (fotoUrl) {
            popupContent += "<br><img src='" + fotoUrl + "' alt='Foto Rumah Sakit' style='width: 100px; height: auto;'>";
        }

        var marker = L.marker([{{ $rsItem->latitude }}, {{ $rsItem->longitude }}])
            .addTo(map)
            .bindPopup(popupContent);
    @endforeach
</script>

@endsection
