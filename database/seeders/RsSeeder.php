<?php

namespace Database\Seeders;

use App\Models\Rs; // Pastikan menggunakan model Rs
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RSSeeder extends Seeder
{
    public function run()
    {
        // Tentukan path ke file GeoJSON
        $filePath = storage_path('app/public/geojson/rs.geojson');
        
        // Ambil isi file GeoJSON dan decode
        $geojson = json_decode(file_get_contents($filePath), true);

        // Proses setiap feature dalam GeoJSON
        foreach ($geojson['features'] as $feature) {
            Rs::create([ // Gunakan model Rs untuk menyimpan data ke tabel rs
                'namobj' => $feature['properties']['NAMOBJ'],
                'remark' => $feature['properties']['REMARK'],
                'alamat' => $feature['properties']['ALAMAT'] ?? null,
                'foto' => $feature['properties']['FOTO'] ?? null, // Sesuaikan jika ada kolom foto
                'latitude' => $feature['geometry']['coordinates'][1],
                'longitude' => $feature['geometry']['coordinates'][0],
            ]);
        }
    }
}
