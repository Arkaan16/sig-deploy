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
    $request->validate([
        'namobj' => 'required',
        'remark' => 'required',
        'foto' => 'nullable|image',
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('public/fotos');
    }

    Rs::create([
        'namobj' => $request->namobj,
        'remark' => $request->remark,
        'alamat' => $request->alamat,
        'foto' => $fotoPath,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    return redirect()->route('peta.index'); // Pastikan route ini ada
}


    public function show(Rs $rs)
    {
        return view('peta.show', compact('rs'));
    }
}
