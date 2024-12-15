@extends('layouts.peta')

@section('title', 'Data Rumah Sakit')

@section('content')
    <div class="flex">
        @include('components.sidebar') <!-- Memanggil Sidebar -->

        <div class="w-full flex-grow p-6">
            <h1 class="text-3xl font-bold text-black pb-6">Data Rumah Sakit</h1>

            <!-- Tombol Tambah Data Rumah Sakit -->
            <a href="{{ route('rumah-sakit.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                Tambah Data Rumah Sakit
            </a>

            <!-- Search Bar -->
            <div class="mb-4">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari Rumah Sakit</label>
                <div class="relative">
                    <input type="text" id="search" class="mt-1 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md" placeholder="Cari berdasarkan nama Rumah Sakit" onkeyup="searchHospital()">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                </div>
            </div>

            <!-- Tabel Data Rumah Sakit -->
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">No</th>
                        <th class="border border-gray-300 px-4 py-2">Nama</th>
                        <th class="border border-gray-300 px-4 py-2">Jenis</th>
                        <th class="border border-gray-300 px-4 py-2">Alamat</th>
                        <th class="border border-gray-300 px-4 py-2">Foto</th>
                        <th class="border border-gray-300 px-4 py-2">Latitude</th>
                        <th class="border border-gray-300 px-4 py-2">Longitude</th>
                        <th class="border border-gray-300 px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rs as $index => $hospital)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $hospital->namobj }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $hospital->remark }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $hospital->alamat }}</td>
                            <td class="border border-gray-300 px-4 py-2 flex justify-center items-center">
                                @if ($hospital->foto)
                                    <img src="{{ Storage::url($hospital->foto) }}" alt="Foto Rumah Sakit" class="w-16 h-16 object-cover">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $hospital->latitude }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $hospital->longitude }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <a href="{{ route('rumah-sakit.show', $hospital->id) }}" class="text-green-500 hover:underline flex items-center">
                                    <i class="fas fa-eye mr-2"></i> Detail
                                </a>
                                <a href="{{ route('rumah-sakit.edit', $hospital->id) }}" class="text-blue-500 hover:underline flex items-center">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>
                                <form action="{{ route('rumah-sakit.destroy', $hospital->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline flex items-center" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash-alt mr-2"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Fungsi pencarian data rumah sakit
        function searchHospital() {
            var searchText = document.getElementById('search').value.toLowerCase();
            var rows = document.querySelectorAll('tbody tr');

            rows.forEach(function(row) {
                var name = row.cells[1].innerText.toLowerCase();
                if (name.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
