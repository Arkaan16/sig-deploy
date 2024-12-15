@extends('layouts.peta')

@section('title', 'Peta Rumah Sakit')

@section('content')
    <div class="flex">
        @include('components.sidebar') <!-- Memanggil Sidebar -->

        <div class="w-full flex-grow p-6">
            <h1 class="text-3xl font-bold text-black pb-6">Peta Lampung Selatan</h1>

            <!-- Search Bar -->
            <div class="mb-4">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Rumah Sakit</label>
                <div class="relative">
                    <!-- Icon search berada di sebelah kiri input -->
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <input type="text" id="search" class="mt-1 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md" placeholder="Cari berdasarkan nama Rumah Sakit" onkeyup="searchHospital()">
                </div>
            </div>
            
            <!-- Peta Leaflet -->
            <div id="map" class="mb-4 w-full" style="height: 500px;"></div>

            <div id="hospitalCountDisplay"></div>

        </div>
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
    
        var markers = []; // Array untuk menyimpan marker
        var kecamatanHospitalCount = {}; // Objek untuk menyimpan jumlah rumah sakit per kecamatan
        var kecamatanGeoJsonLayers = {}; // Menyimpan data GeoJSON kecamatan untuk setiap kecamatan
    
        // Fungsi untuk menentukan warna berdasarkan nama kecamatan
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
            };
    
            return colors[kecamatanName] || "#CCCCCC"; // Warna abu-abu default
        }
    
        // Fungsi untuk mengupdate jumlah rumah sakit per kecamatan
        function updateHospitalCountForKecamatan() {
            var count = {};
    
            markers.forEach(function(item) {
                var hospitalLatLng = L.latLng(item.latitude, item.longitude);
    
                for (var kecamatanName in kecamatanGeoJsonLayers) {
                    var layer = kecamatanGeoJsonLayers[kecamatanName];
                    if (layer.getBounds().contains(hospitalLatLng)) {
                        if (!count[kecamatanName]) {
                            count[kecamatanName] = 0;
                        }
                        count[kecamatanName]++;
                        break;
                    }
                }
            });
    
            // Update popup setiap kecamatan untuk menampilkan jumlah rumah sakit
            for (var kecamatanName in count) {
                var hospitalCount = count[kecamatanName];
    
                if (kecamatanGeoJsonLayers[kecamatanName]) {
                    var layer = kecamatanGeoJsonLayers[kecamatanName];
                    var currentPopupContent = layer.getPopup().getContent();
                    var newPopupContent = currentPopupContent + "<br><strong>Jumlah Rumah Sakit: " + hospitalCount + "</strong>";
                    layer.bindPopup(newPopupContent);
                }
            }
        }
    
        // Fungsi pencarian
        function searchHospital() {
            var searchText = document.getElementById('search').value.toLowerCase();
            var found = false;
    
            markers.forEach(function(item) {
                if (item.name.toLowerCase().includes(searchText)) {
                    item.marker.addTo(map);
                    map.setView(item.marker.getLatLng(), 16);
                    item.marker.openPopup();
                    found = true;
                } else {
                    map.removeLayer(item.marker);
                }
            });
    
            if (!found && searchText === "") {
                markers.forEach(function(item) {
                    item.marker.addTo(map);
                });
            }
        }
    
        // Fungsi untuk menampilkan legenda
        function createLegend() {
            var legend = L.control({ position: 'bottomright' });
    
            legend.onAdd = function() {
                var div = L.DomUtil.create('div', 'info legend bg-white p-2 rounded-lg shadow-lg w-72');
                var colors = {
                    "RAJABASA": "#FF0000", 
                    "SEKAMPUNG": "#FF6347", 
                    "SEKAMPUNGUDIK": "#FFD700", 
                    "SIDOMULYO": "#32CD32", 
                    "SRAGI": "#1E90FF", 
                    "SUKARAME": "#FF1493", 
                    "TANJUNGBINTANG": "#8A2BE2", 
                    "TANJUNGSARI": "#FF4500", 
                    "TANJUNGSENANG": "#ADFF2F", 
                    "TEGINENENG": "#D2691E", 
                    "TRIMUPJO": "#000080", 
                    "WAWAYKARYA": "#00BFFF", 
                    "WAYPANJI": "#8B0000", 
                    "WAYSULAN": "#3CB371", 
                    "GEDONGTATAAN": "#FF8C00", 
                    "JABUNG": "#8B4513", 
                    "JATIAGUNG": "#A52A2A", 
                    "KALIANDA": "#0000FF", 
                    "KATIBUNG": "#DC143C", 
                    "KEMILING": "#FF6347", 
                    "KETAPANG": "#FFD700", 
                    "MARGATIGA": "#32CD32", 
                    "MERBAUMATARAM": "#FF1493", 
                    "METROKIBANG": "#1E90FF", 
                    "NATAR": "#8A2BE2", 
                    "NEGERIKATON": "#00BFFF", 
                    "PALAS": "#000080", 
                    "PANJANG": "#ADFF2F", 
                    "PASIRSAKTI": "#FF4500", 
                    "PENENGAHAN": "#FF00FF", 
                    "BAKAUHENI": "#00FF00", 
                    "BATANGHARI": "#800080", 
                    "CANDIPURO": "#FF69B4", 
                };
    
                var labels = [];
                var i = 0;
                for (var kecamatan in colors) {
                    if (i % 2 === 0) {
                        labels.push('<div class="grid grid-cols-2 gap-1 mb-1 text-xs">');
                    }
    
                    labels.push(
                        '<div class="flex items-center text-ellipsis overflow-hidden">' +
                            '<div class="w-3 h-3 mr-2" style="background-color:' + colors[kecamatan] + ';"></div>' +
                            '<span class="truncate">' + kecamatan + '</span>' +
                        '</div>'
                    );
    
                    if (i % 2 !== 0) {
                        labels.push('</div>');
                    }
    
                    i++;
                }
    
                if (i % 2 !== 0) {
                    labels.push('</div>');
                }
    
                div.innerHTML = labels.join('');
                return div;
            };
    
            legend.addTo(map);
        }
    
        // Menampilkan legenda setelah peta dimuat
        createLegend();
    
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
                        kecamatanGeoJsonLayers[feature.properties.NAMOBJ] = layer;
                        layer.bindPopup("<b>" + feature.properties.NAMOBJ + "</b><br>" + feature.properties.REMARK);
                    }
                }).addTo(map);
    
                // Update jumlah rumah sakit setelah GeoJSON kecamatan dimuat
                updateHospitalCountForKecamatan();
            })
            .catch(function(error) {
                console.error("Error loading GeoJSON:", error);
            });
    
        // Menambahkan marker untuk setiap rumah sakit
        @foreach ($rs as $rsItem)
            var fotoUrl = "{{ Storage::url($rsItem->foto) }}";
            var popupContent = "<b>{{ $rsItem->namobj }}</b><br>{{ $rsItem->remark }}<br>{{ $rsItem->alamat }}";
        
            if (fotoUrl) {
                popupContent += "<br><img src='" + fotoUrl + "' alt='Foto Rumah Sakit' style='width: 100px; height: auto;'>";
            }
        
            var marker = L.marker([{{ $rsItem->latitude }}, {{ $rsItem->longitude }}])
                .addTo(map)
                .bindPopup(popupContent);
        
            markers.push({
                name: "{{ $rsItem->namobj }}",
                marker: marker,
                latitude: {{ $rsItem->latitude }},
                longitude: {{ $rsItem->longitude }},
                kecamatan: "{{ $rsItem->kecamatan }}"
            });
        @endforeach
    </script>
    
@endsection
