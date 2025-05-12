<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferenciaMunicion extends Model
{
    protected $table = 'transferencias_municiones';

    protected $fillable = [
        'aerodromo_origen_id',
        'aerodromo_destino_id',
        'catinventario_id',
        'cantidad',
        'user_id',
        'observaciones',
    ];

    // Aeródromo de origen
    public function aerodromoOrigen(): BelongsTo
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_origen_id');
    }

    // Aeródromo de destino
    public function aerodromoDestino(): BelongsTo
    {
        return $this->belongsTo(Aerodromo::class, 'aerodromo_destino_id');
    }

    // Relación con el catálogo de inventario (munición)
    public function catinventario(): BelongsTo
    {
        return $this->belongsTo(CatalogoInventario::class, 'catinventario_id');
    }

    // Usuario que realizó la transferencia
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // (Opcional) Relación con los movimientos si deseas registrar uno por transferencia
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'catinventario_id', 'catinventario_id')
            ->where(function ($query) {
                $query->where('aerodromo_id', $this->aerodromo_origen_id)
                      ->orWhere('aerodromo_id', $this->aerodromo_destino_id);
            });
    }
}

