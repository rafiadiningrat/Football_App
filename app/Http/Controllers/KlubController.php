<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use Illuminate\Http\Request;

class KlubController extends Controller
{
    //
    public function index()
    {
        $klubs = Klub::all();
        return view('klub.view', compact('klubs'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'nama_klub' => 'required|unique:klub,nama_klub',
        //     'kota_klub' => 'required'
        // ]);
    
        // // Periksa apakah nama klub sudah ada
        // $namaKlubExists = Klub::where('nama_klub', $request->nama_klub)->exists();
    
        // if ($namaKlubExists) {
        //     return redirect('/klub')->with('error', 'Nama klub sudah ada. Harap pilih nama klub yang lain.');
        // }
    
        // Klub::create([
        //     'nama_klub' => $request->nama_klub,
        //     'kota_klub' => $request->kota_klub
        // ]);
    
        // return redirect('/klub')->with('success', 'Klub berhasil ditambahkan.');

        $request->validate([
            'nama_klub' => 'required|unique:klub,nama_klub',
            'kota_klub' => 'required'
        ]);
    
        Klub::create([
            'nama_klub' => $request->nama_klub,
            'kota_klub' => $request->kota_klub
        ]);
    
        return redirect('/klub')->with('success', 'Klub berhasil ditambahkan.');
    }
}
