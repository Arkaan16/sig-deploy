@extends('layouts.landing')

@section('title', 'SIG Lampung Selatan')

@section('content')
    @include('components.navbar')

    <!-- Hero Section -->
    <div id="home" class="relative bg-cover bg-center h-screen" style="background-image: url('/assets/img/sigerr.jpg');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-sky-700 bg-opacity-50"></div>
        <!-- Content -->
        <div class="flex items-center justify-center h-full relative z-10 animate-fade-up">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">SIG Lampung Selatan</h1>
                <p class="text-lg md:text-xl mb-6">Sistem Informasi Geografis untuk Analisis Sebaran Rumah Sakit di Lampung Selatan</p>
                <a href="/peta" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-3 px-6 rounded-full text-lg">Jelajahi Sekarang</a>
            </div>
        </div>
    </div>

    <!-- Features -->
    <section id="feature" class="py-20 mt-20 lg:mt-5 px-4 md:px-8 lg:px-16">
        <!-- Heading -->
        <div class="sm:w-3/4 lg:w-5/12 mx-auto px-2 animate-fade-up">
            <h1 class="text-3xl text-center text-gray-800">Fitur Utama</h1>
            <p class="text-center text-gray-600 mt-4">
                SIG Lampung Selatan menyediakan berbagai fitur untuk membantu analisis sebaran rumah sakit dengan mudah dan akurat.
            </p>
        </div>

        <!-- Feature #1 -->
        <div class="relative mt-20 lg:mt-24 animate-fade-up">
            <div class="container flex flex-col lg:flex-row items-center justify-center gap-x-24 mx-auto">
                <!-- Image -->
                <div class="flex flex-1 justify-center z-10 mb-10 lg:mb-0">
                    <img class="w-5/6 h-5/6 sm:w-3/4 sm:h-3/4 md:w-full md:h-full" src="assets/img/illustration-features-tab-1.png" alt="Analisis Sebaran" />
                </div>
                <!-- Content -->
                <div class="flex flex-1 flex-col items-center lg:items-start">
                    <h1 class="text-3xl text-gray-800">Analisis Sebaran</h1>
                    <p class="text-gray-600 my-4 text-center lg:text-left sm:w-3/4 lg:w-full">
                        SIG Lampung Selatan memetakan lokasi rumah sakit di seluruh wilayah, membantu memahami distribusi layanan kesehatan dengan lebih baik.
                    </p>
                </div>
            </div>
            <!-- Rounded Rectangle -->
            <div class="hidden lg:block overflow-hidden bg-sky-700 rounded-r-full absolute h-80 w-2/4 -bottom-24 -left-36"></div>
        </div>

        <!-- Feature #2 -->
        <div class="relative mt-20 lg:mt-52 animate-fade-up">
            <div class="container flex flex-col lg:flex-row-reverse items-center justify-center gap-x-24 mx-auto">
                <!-- Image -->
                <div class="flex flex-1 justify-center z-10 mb-10 lg:mb-0">
                    <img class="w-5/6 h-5/6 sm:w-3/4 sm:h-3/4 md:w-full md:h-full" src="assets/img/illustration-features-tab-2.png" alt="Data Interaktif" />
                </div>
                <!-- Content -->
                <div class="flex flex-1 flex-col items-center lg:items-start">
                    <h1 class="text-3xl text-gray-800">Data Interaktif</h1>
                    <p class="text-gray-600 my-4 text-center lg:text-left sm:w-3/4 lg:w-full">
                        Dengan data interaktif berbasis peta, pengguna dapat mencari informasi lokasi rumah sakit berdasarkan wilayah atau jarak tertentu.
                    </p>
                </div>
            </div>
            <!-- Rounded Rectangle -->
            <div class="hidden lg:block overflow-hidden bg-sky-700 rounded-l-full absolute h-80 w-2/4 -bottom-24 -right-0"></div>
        </div>

        <!-- Feature #3 -->
        <div class="relative mt-20 lg:mt-52 animate-fade-up">
            <div class="container flex flex-col lg:flex-row items-center justify-center gap-x-24 mx-auto">
                <!-- Image -->
                <div class="flex flex-1 justify-center z-10 mb-10 lg:mb-0">
                    <img class="w-5/6 h-5/6 sm:w-3/4 sm:h-3/4 md:w-full md:h-full" src="assets/img/illustration-features-tab-3.png" alt="Hasil Cepat" />
                </div>
                <!-- Content -->
                <div class="flex flex-1 flex-col items-center lg:items-start text-center lg:text-left">
                    <h1 class="text-3xl text-gray-800">Hasil Cepat dan Akurat</h1>
                    <p class="text-gray-600 my-4 sm:w-3/4 lg:w-full">
                        Sistem ini memberikan hasil analisis dengan cepat, membantu para pemangku kepentingan mengambil keputusan yang lebih baik.
                    </p>
                </div>
            </div>
            <!-- Rounded Rectangle -->
            <div class="hidden lg:block overflow-hidden bg-sky-700 rounded-r-full absolute h-80 w-2/4 -bottom-24 -left-36"></div>
        </div>
    </section>

    <!-- Seksi Tim Kami -->
    <section id="team" class="py-20 mt-40 px-4 md:px-8 lg:px-16 bg-sky-700">
        <!-- Judul -->
        <div class="sm:w-3/4 lg:w-5/12 mx-auto px-2 animate-fade-up">
            <h1 class="text-3xl text-center text-white font-bold">Tim Kami</h1>
            <p class="text-center text-white mt-4">
                Kenali para profesional berdedikasi yang ada di balik pengembangan SIG Lampung Selatan.
            </p>
        </div>

        <!-- Kartu Tim -->
        <div class="container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 max-w-screen-lg mt-16 mx-auto">
            <!-- Anggota Tim 1 -->
            <div class="flex flex-col items-center bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:translate-y-[-10px] animate-fade-up">
                <div class="w-full overflow-hidden flex justify-center pt-6">
                    <img src="assets/img/arkaan.png" alt="Anggota Tim 1" class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-full">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-lg font-semibold text-sky-700">M. Faruq Arkaan</h3>
                    <p class="text-sky-600 font-light">Front-End Developer</p>
                    <p class="mt-4 text-gray-600">"Kami berkomitmen untuk menyediakan solusi SIG terbaik bagi masyarakat Lampung Selatan."</p>
                </div>
            </div>
            <!-- Anggota Tim 2 -->
            <div class="flex flex-col items-center bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:translate-y-[-10px] animate-fade-up">
                <div class="w-full overflow-hidden flex justify-center pt-6">
                    <img src="assets/img/daffa.png" alt="Anggota Tim 2" class="object-top w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-full">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-lg font-semibold text-sky-700">Daffa Rizqan Fairuz</h3>
                    <p class="text-sky-600 font-light">Back-End Developer</p>
                    <p class="mt-4 text-gray-600">"Setiap baris kode kami didedikasikan untuk mendukung layanan kesehatan di Lampung Selatan."</p>
                </div>
            </div>
            <!-- Anggota Tim 3 -->
            <div class="flex flex-col items-center bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:translate-y-[-10px] animate-fade-up">
                <div class="w-full overflow-hidden flex justify-center pt-6">
                    <img src="assets/img/muslim.png" alt="Anggota Tim 3" class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-full">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-lg font-semibold text-sky-700">Nurwahid Muslim</h3>
                    <p class="text-sky-600 font-light">GIS Specialist</p>
                    <p class="mt-4 text-gray-600">"SIG Lampung Selatan adalah langkah kami untuk meningkatkan aksesibilitas informasi kesehatan."</p>
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')
@endsection
