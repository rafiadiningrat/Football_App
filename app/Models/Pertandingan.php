<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Klub;

class Pertandingan extends Model
{
    use HasFactory;
    protected $table = 'pertandingan';
    protected $fillable = ['klub_tuan_rumah_id', 'klub_tamu_id', 'skor_tuan_rumah', 'skor_tamu'];

    public function klubTuanRumah()
    {
        return $this->belongsTo(Klub::class, 'klub_tuan_rumah_id', 'id_klub');
    }

    public function klubTamu()
    {
        return $this->belongsTo(Klub::class, 'klub_tamu_id', 'id_klub');
    }
}
