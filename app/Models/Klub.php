<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Klasemen;
use App\Models\Pertandingan;

class Klub extends Model
{
    use HasFactory;
    protected $table = 'klub';
    protected $primaryKey = 'id_klub'; // Menentukan primary key baru
    protected $fillable = ['nama_klub', 'kota_klub'];

    public function pertandinganTuanRumah()
    {
        return $this->hasMany(Pertandingan::class, 'klub_tuan_rumah_id', 'id_klub');
    }

    public function pertandinganTamu()
    {
        return $this->hasMany(Pertandingan::class, 'klub_tamu_id', 'id_klub');
    }

    public function klasemen()
    {
        return $this->hasOne(Klasemen::class, 'id_klub', 'id_klub');
    }
}
