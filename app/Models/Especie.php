<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends Model
{
    use HasFactory;
    protected $fillable = ['familia_id', 'nombre', 'nombre_comun', 'foto'];


    //Relacion con Familia
    public function familia()
    {
        return $this->belongsTo(Familia::class, 'familia_id');
    }

    //
}
