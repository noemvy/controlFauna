<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'descripcion', 'estado'];
    protected $table = 'departamentos';

    //Relacion con Users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
