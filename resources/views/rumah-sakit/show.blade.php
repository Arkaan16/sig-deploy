@extends('layouts.peta')

@section('title', 'Detail Rumah Sakit')

@section('content')
    <div class="flex">
        @include('components.sidebar') <!-- Memanggil Sidebar -->

        <div class="w-full flex-grow p-6">
            <h1 class="text-3xl font-bold text-black pb-6">Detail Data Rumah Sakit</h1>

            <!-- Menampilkan informasi rumah sakit -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">{{ $hospital->namobj }}</h2>
                
                <div class="mb-4">
                    <strong class="text-gray-700">Jenis:</strong> 
                    <span>{{ $hospital->remark }}</span>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Alamat:</strong> 
                    <span>{{ $hospital->alamat }}</span>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Latitude:</strong> 
                    <span>{{ $hospital->latitude }}</span>
                </div>

                <div class="mb-4">
                    <strong class="text-gray-700">Longitude:</strong> 
                    <span>{{ $hospital->longitude }}</span>
                </div>

                @if ($hospital->foto)
                    <div class="mb-4">
                        <strong class="text-gray-700">Foto Rumah Sakit:</strong>
                        <img src="{{ Storage::url($hospital->foto) }}" alt="Foto Rumah Sakit" class="w-32 h-32 mt-2">
                    </div>
                @endif
                
                <!-- Tombol untuk edit data -->
                <a href="{{ route('rumah-sakit.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
