<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioMuniciones extends Model
{
    protected $fillable = ['catinventario_id', 'aerodromo_id', 'cantidad'];

    //Relacion con Aerodromo
        public function aerodromo()
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_id');
    }

    //Relacion con Catalogo Inventario
        public function catalogoInventario()
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

}
}
