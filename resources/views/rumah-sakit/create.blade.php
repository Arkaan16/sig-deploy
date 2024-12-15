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
        // Inisialisasi peta dan set koordinat awal
        var map = L.map('map').setView([-5.727431, 105.596359], 13);

        // Menambahkan layer peta OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var isMarkerCreated = false; // Penanda untuk memeriksa apakah marker sudah dibuat
        var currentMarker = null; // Menyimpan marker saat ini
        var cancelButton = document.getElementById('cancelButton');

        // Menangani klik pada peta
        map.on('click', function(e) {
            // Jika marker sudah ada, pindahkan ke lokasi baru
            if (isMarkerCreated) {
                return; // Jangan buat marker baru jika sudah ada
            }

            // Jika belum ada marker, buat marker baru
            currentMarker = L.marker(e.latlng, {draggable: true}).addTo(map); // Menambahkan marker yang dapat dipindahkan
            currentMarker.on('dragend', function() {
                // Menyimpan koordinat yang dipindahkan ke dalam input tersembunyi
                document.getElementById('latitude').value = currentMarker.getLatLng().lat;
                document.getElementById('longitude').value = currentMarker.getLatLng().lng;
            });

            // Menyimpan koordinat yang diklik ke dalam input tersembunyi
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;

            // Menandai bahwa marker sudah dibuat dan tampilkan tombol Cancel
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
    </script>
@endsection
