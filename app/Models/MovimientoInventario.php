<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $fillable = ['aerodromo_id', 'catinventario_id', 'tipo_movimiento'];

    //Relacion con Aerodromo
    public function aerodromo()
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_id');
    }

    public function catalogoInventario()
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }


}
