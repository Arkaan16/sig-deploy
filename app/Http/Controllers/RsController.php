<?php

namespace App\Http\Controllers;

use App\Models\Rs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RsController extends Controller
{
    public function index()
    {
        $rs = Rs::all();  // Ambil semua data rumah sakit
        return view('peta.index', compact('rs'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'namobj' => 'nullable|string|max:255',
            'remark' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'geojson' => 'nullable|file|mimes:json,geojson|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Proses file GeoJSON jika ada
        if ($request->hasFile('geojson')) {
            $file = $request->file('geojson');
            $geojsonData = json_decode(file_get_contents($file->getRealPath()), true);

            foreach ($geojsonData['features'] as $feature) {
                Rs::create([
                    'namobj' => $feature['properties']['NAMOBJ'],
                    'remark' => $feature['properties']['REMARK'],
                    'alamat' => $feature['properties']['ALAMAT'] ?? null,
                    'latitude' => $feature['geometry']['coordinates'][1],
                    'longitude' => $feature['geometry']['coordinates'][0],
                ]);
            }

            return redirect()->route('rumah-sakit.index')->with('success', 'Data dari GeoJSON berhasil ditambahkan.');
        }

        // Proses input data manual (jika diisi)
        if ($request->filled('latitude') && $request->filled('longitude')) {
            Rs::create([
                'namobj' => $request->input('namobj'),
                'remark' => $request->input('remark'),
                'alamat' => $request->input('alamat'),
                'foto' => $request->file('foto') ? $request->file('foto')->store('public/foto') : null,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);

            return redirect()->route('rumah-sakit.index')->with('success', 'Rumah Sakit berhasil ditambahkan.');
        }

        return redirect()->route('rumah-sakit.index')->with('error', 'Gagal menambahkan data.');
    }


    public function list()
    {
        $rs = Rs::all(); // Mengambil semua data rumah sakit
        return view('rumah-sakit.index', compact('rs')); // Mengarahkan ke file view Rumah Sakit
    }

    public function create()
{
    return view('rumah-sakit.create'); // Mengarahkan ke halaman form untuk menambah rumah sakit
}

    // Jika Anda tidak membutuhkan show(), bisa dihapus atau ditambahkan dengan method seperti berikut:
public function show($id)
{
    $hospital = Rs::findOrFail($id);
    return view('rumah-sakit.show', compact('hospital')); // Tampilkan data rumah sakit
}


    // Mengedit rumah sakit berdasarkan ID
public function edit($id)
{
    $hospital = Rs::findOrFail($id);
    return view('rumah-sakit.edit', compact('hospital'));
}

// Memperbarui data rumah sakit
public function update(Request $request, $id)
{
    $request->validate([
        'namobj' => 'required',
        'remark' => 'required',
        'foto' => 'nullable|image',
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    $hospital = Rs::findOrFail($id);

    $fotoPath = $hospital->foto; // Ambil foto lama sebagai fallback
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($hospital->foto) {
            Storage::delete($hospital->foto);
        }
        $fotoPath = $request->file('foto')->store('public/fotos');
    }

    $hospital->update([
        'namobj' => $request->namobj,
        'remark' => $request->remark,
        'alamat' => $request->alamat,
        'foto' => $fotoPath,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    return redirect()->route('rumah-sakit.index'); // Redirect ke halaman daftar rumah sakit
}


    public function destroy($id)
    {
        $hospital = Rs::findOrFail($id);  // Temukan rumah sakit berdasarkan ID

        // Hapus foto jika ada
        if ($hospital->foto) {
            Storage::delete($hospital->foto);
        }

        $hospital->delete();  // Hapus data rumah sakit

        return redirect()->route('rumah-sakit.index');  // Redirect ke halaman daftar rumah sakit
    }

}
