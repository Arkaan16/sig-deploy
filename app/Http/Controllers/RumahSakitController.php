<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;

class RumahSakitController extends Controller
{
    // Menampilkan data dalam format GeoJSON
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

    // Menambahkan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis' => 'required|string',
            'kapasitas' => 'required|integer',
            'koordinat' => 'required|json'
        ]);

        RumahSakit::create($request->all());

        return response()->json(['message' => 'Data berhasil ditambahkan']);
    }

    // Mengupdate data yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis' => 'required|string',
            'kapasitas' => 'required|integer',
            'koordinat' => 'required|json'
        ]);

        $rumahSakit = RumahSakit::findOrFail($id);
        $rumahSakit->update($request->all());

        return response()->json(['message' => 'Data berhasil diubah']);
    }

    // Menghapus data
    public function destroy($id)
    {
        $rumahSakit = RumahSakit::findOrFail($id);
        $rumahSakit->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
