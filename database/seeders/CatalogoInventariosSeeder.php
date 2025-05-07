<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogoInventariosSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de acciones disponibles
        $acciones = DB::table('acciones')->pluck('id');

        if ($acciones->isEmpty()) {
            $this->command->warn('No hay acciones registradas. Ejecuta primero AccionesSeeder.');
            return;
        }

        DB::table('catalogo_inventarios')->insert([
            [
                'acciones_id' => $acciones->random(),
                'nombre' => 'Cartuchos tipo Banger',
                'consumible' => true,
                'descripcion' => 'Munición de sonido fuerte para dispersar aves en el área de operaciones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => $acciones->random(),
                'nombre' => 'Cartuchos tipo Volador',
                'consumible' => true,
                'descripcion' => 'Cartuchos pirotécnicos que generan luces y sonidos para ahuyentar fauna.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => $acciones->random(),
                'nombre' => 'Cañón de propano',
                'consumible' => false,
                'descripcion' => 'Dispositivo mecánico para emitir explosiones automáticas y ahuyentar aves.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => $acciones->random(),
                'nombre' => 'Capás (carabina de fogueo)',
                'consumible' => false,
                'descripcion' => 'Arma no letal para lanzar cartuchos de banger y volador en control de fauna.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
