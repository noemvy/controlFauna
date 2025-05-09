<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $fillable = ['aerodromo_id', 'catinventario_id', 'user_id','tipo_movimiento','cantidad_usar','comentario'];
    protected $table = 'movimiento_inventario';




 protected static function booted()
{
    static::creating(function ($movimiento) {
        self::ajustarInventario($movimiento, 'crear');
    });

    static::updating(function ($movimiento) {
        self::ajustarInventario($movimiento, 'editar');
    });

    static::deleting(function ($movimiento) {
        self::ajustarInventario($movimiento, 'eliminar');
    });
}

protected static function ajustarInventario($movimiento, $accion)
{
    $inventario = InventarioMuniciones::where('aerodromo_id', $movimiento->aerodromo_id)
        ->where('catinventario_id', $movimiento->catinventario_id)
        ->first();

    if (! $inventario) return;

    if ($accion === 'crear') {
        if ($movimiento->tipo_movimiento === 'Entrada') {
            $inventario->cantidad_actual += $movimiento->cantidad_usar;
        } else {
            $inventario->cantidad_actual -= $movimiento->cantidad_usar;
        }
    }

    if ($accion === 'editar') {
        // Obtener movimiento original (antes de actualizar)
        $original = $movimiento->getOriginal();

        // Revertir cambio anterior
        if ($original['tipo_movimiento'] === 'Entrada') {
            $inventario->cantidad_actual -= $original['cantidad_usar'];
        } else {
            $inventario->cantidad_actual += $original['cantidad_usar'];
        }

        // Aplicar nuevo cambio
        if ($movimiento->tipo_movimiento === 'Entrada') {
            $inventario->cantidad_actual += $movimiento->cantidad_usar;
        } else {
            $inventario->cantidad_actual -= $movimiento->cantidad_usar;
        }
    }

    if ($accion === 'eliminar') {
        if ($movimiento->tipo_movimiento === 'Entrada') {
            $inventario->cantidad_actual -= $movimiento->cantidad_usar;
        } else {
            $inventario->cantidad_actual += $movimiento->cantidad_usar;
        }
    }

    $inventario->save();
}




    //Relacion con Aerodromo
    public function aerodromo()
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_id');
    }

    public function catalogoInventario()
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    // En el modelo MovimientoInventario
    public function inventario()
    {
        return $this->belongsTo(InventarioMuniciones::class, 'catinventario_id', 'catinventario_id')
            ->where('aerodromo_id', $this->aerodromo_id); // Si deseas filtrar por aeródromo
    }





}
