<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;

class RumahSakitController extends Controller
{
    public function getGeoJSON()
    {
        $rumahSakits = RumahSakit::all();
        $features = $rumahSakits->map(function ($rs) {
            return [
                "type" => "Feature",
                "geometry" => json_decode($rs->koordinat),
                "properties" => [
                    "id" => $rs->id,
                    "nama" => $rs->nama,
                    "alamat" => $rs->alamat,
                    "jenis" => $rs->jenis,
                    "kapasitas" => $rs->kapasitas
                ]
            ];
        });

        return response()->json([
            "type" => "FeatureCollection",
            "features" => $features
        ]);
    }
}
