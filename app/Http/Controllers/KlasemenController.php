<?php

namespace App\Http\Controllers;

use App\Models\Klub;
use App\Models\Pertandingan;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KlasemenController extends Controller
{
    //
    public function showKlasemen()
{
    $klubs = Klub::all();

    // Menghitung statistik pertandingan dan mengatur klasemen
    foreach ($klubs as $klub) {
        $klub->main = Pertandingan::where('klub_tuan_rumah_id', $klub->id_klub)
            ->orWhere('klub_tamu_id', $klub->id_klub)
            ->count();

            $klub->menang = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_tuan_rumah_id', $klub->id_klub)
                    ->whereColumn('skor_tuan_rumah', '>', 'skor_tamu');
            })
            ->orWhere(function ($query) use ($klub) {
                $query->where('klub_tamu_id', $klub->id_klub)
                    ->whereColumn('skor_tamu', '>', 'skor_tuan_rumah');
            })
            ->count();
            
            $klub->seri = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_tuan_rumah_id', $klub->id_klub)
                    ->whereColumn('skor_tuan_rumah', '=', 'skor_tamu');
            })
            ->orWhere(function ($query) use ($klub) {
                $query->where('klub_tamu_id', $klub->id_klub)
                    ->whereColumn('skor_tamu', '=', 'skor_tuan_rumah');
            })
            ->count();
            
            $klub->kalah = $klub->main - ($klub->menang + $klub->seri);

            $klub->goal_menang = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_tuan_rumah_id', $klub->id_klub)
                    ->where('skor_tuan_rumah', '>', 0);
            })->orWhere(function ($query) use ($klub) {
                $query->where('klub_tamu_id', $klub->id_klub)
                    ->where('skor_tamu', '>', 0);
            })->sum(DB::raw('CASE 
                WHEN klub_tuan_rumah_id = '.$klub->id_klub.' THEN skor_tuan_rumah
                WHEN klub_tamu_id = '.$klub->id_klub.' THEN skor_tamu
                ELSE 0
                END'));
            
            $klub->goal_kalah = Pertandingan::where(function ($query) use ($klub) {
                $query->where('klub_tuan_rumah_id', $klub->id_klub)
                    ->where('skor_tamu', '>', 0);
            })->orWhere(function ($query) use ($klub) {
                $query->where('klub_tamu_id', $klub->id_klub)
                    ->where('skor_tuan_rumah', '>', 0);
            })->sum(DB::raw('CASE 
                WHEN klub_tuan_rumah_id = '.$klub->id_klub.' THEN skor_tamu
                WHEN klub_tamu_id = '.$klub->id_klub.' THEN skor_tuan_rumah
                ELSE 0
                END'));
            
                        

        $klub->point = ($klub->menang * 3) + $klub->seri;
    }

    // Urutkan klub berdasarkan point dan goal difference
    $klubs = $klubs->sortByDesc(function ($klub) {
        return $klub->point * 1000 + ($klub->goal_menang - $klub->goal_kalah);
    });

    return view('klasemen.view', compact('klubs'));
}

}
