<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RumahSakit;

class RumahSakitSeeder extends Seeder
{
    public function run()
    {
        RumahSakit::create([
            'nama' => 'RSUD Bob Bazar',
            'alamat' => 'Jl. Trans Sumatera',
            'jenis' => 'RS Umum',
            'kapasitas' => 150,
            'koordinat' => json_encode(['type' => 'Point', 'coordinates' => [105.636948, -5.447389]]),
        ]);
    }
}
