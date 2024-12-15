@extends('layouts.peta')

@section('title', 'Edit Data Rumah Sakit')

@section('content')
    <div class="flex">
        @include('components.sidebar') <!-- Memanggil Sidebar -->

        <div class="w-full flex-grow p-6">
            <h1 class="text-3xl font-bold text-black pb-6">Edit Data Rumah Sakit</h1>

            <!-- Form Edit -->
            <form action="{{ route('rumah-sakit.update', $hospital->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Metode PUT untuk update -->
                
                <div class="mb-4">
                    <label for="namobj" class="block text-sm font-medium text-gray-700">Nama Rumah Sakit</label>
                    <input type="text" id="namobj" name="namobj" value="{{ old('namobj', $hospital->namobj) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="remark" class="block text-sm font-medium text-gray-700">Jenis</label>
                    <input type="text" id="remark" name="remark" value="{{ old('remark', $hospital->remark) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $hospital->alamat) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                    <input type="file" id="foto" name="foto" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                    @if ($hospital->foto)
                        <img src="{{ Storage::url($hospital->foto) }}" alt="Foto Rumah Sakit" class="w-16 h-16 mt-2">
                    @endif
                </div>

                <div class="mb-4">
                    <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $hospital->latitude) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $hospital->longitude) }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Tombol Update -->
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>

                    <!-- Tombol Kembali -->
                    <a href="{{ route('rumah-sakit.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
