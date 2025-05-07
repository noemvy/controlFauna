<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];

    //Relacion con Especies 
    public function especies()
    {
        return $this->hasMany(Especie::class, 'familia_id');
    }
}
