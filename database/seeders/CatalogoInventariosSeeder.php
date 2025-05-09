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
                'categoria_equipo' => 'Arma',
                'descripcion' => 'Munición de sonido fuerte para dispersar aves en el área de operaciones.',
                // 'cantidad_minima' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => $acciones->random(),
                'nombre' => 'Cartuchos tipo Volador',
                'categoria_equipo' => 'Instrumento',
                'descripcion' => 'Cartuchos pirotécnicos que generan luces y sonidos para ahuyentar fauna.',
                // 'cantidad_minima' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => $acciones->random(),
                'nombre' => 'Cañón de propano',
                'categoria_equipo' => 'Municiones',
                'descripcion' => 'Dispositivo mecánico para emitir explosiones automáticas y ahuyentar aves.',
                // 'cantidad_minima' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'acciones_id' => $acciones->random(),
                'nombre' => 'Capás (carabina de fogueo)',
                'categoria_equipo' => 'Arma',
                'descripcion' => 'Arma no letal para lanzar cartuchos de banger y volador en control de fauna.',
                // 'cantidad_minima' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
