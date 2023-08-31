<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Klub;

class Klasemen extends Model
{
    use HasFactory;
    protected $table = 'klasemen';
    protected $fillable = ['id_klub', 'main', 'menang', 'seri', 'kalah', 'goal_menang', 'goal_kalah'];

    public function klub()
    {
        return $this->belongsTo(Klub::class, 'id_klub', 'id_klub');
    }
}
