<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use App\Models\Pertandingan;
use Illuminate\Http\Request;

class PertandinganController extends Controller
{
    //
    public function index()
    {
        $klubs = Klub::all(); // Ambil semua data klub dari database
        return view('pertandingan.view', compact('klubs'));
    }

    public function saveScore(Request $request)
    {
        $request->validate([
            'klub1' => 'required',
            'klub2' => 'required|different:klub1', // Add different rule
            'score1' => 'required|integer',
            'score2' => 'required|integer',
        ]);

        Pertandingan::create([
            'klub_tuan_rumah_id' => $request->klub1,
            'klub_tamu_id' => $request->klub2,
            'skor_tuan_rumah' => $request->score1,
            'skor_tamu' => $request->score2,
        ]);

        return redirect()->back()->with('success', 'Skor pertandingan berhasil disimpan.');
    }

    public function saveMultipleScores(Request $request)
    {
        $request->validate([
            'scores' => 'required',
        ]);

        $scoresData = explode("\n", $request->scores);

        foreach ($scoresData as $score) {
            $scoreParts = explode(',', $score);
            if (count($scoreParts) == 2) {
                $klubParts = explode('-', $scoreParts[0]);
                $scoreParts = explode('-', $scoreParts[1]);

                if (count($klubParts) == 2 && count($scoreParts) == 2) {
                 Pertandingan::create([
                        'klub_tuan_rumah_id' => trim($klubParts[0]),
                        'klub_tamu_id' => trim($klubParts[1]),
                        'skor_tuan_rumah' => trim($scoreParts[0]),
                        'skor_tamu' => trim($scoreParts[1]),
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Skor pertandingan berhasil disimpan.');
    }

    public function checkMatch($klub1, $klub2)
{
    $matchExists = Pertandingan::where(function ($query) use ($klub1, $klub2) {
        $query->where('klub_tuan_rumah_id', $klub1)
            ->where('klub_tamu_id', $klub2);
    })->orWhere(function ($query) use ($klub1, $klub2) {
        $query->where('klub_tuan_rumah_id', $klub2)
            ->where('klub_tamu_id', $klub1);
    })->exists();

    return response()->json(['exists' => $matchExists]);
}
}
