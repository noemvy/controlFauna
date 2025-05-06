<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Tabla Catalogos de Municiones
        Schema::create('catalogo_municiones', function (Blueprint $table) {
                $table->id();
                $table->foreignId('acciones_id')->constrained('acciones')->onDelete('cascade');
                $table->string('nombre');
                $table->boolean('consumible');
                $table->string('descripcion')->nullable();


        });

        //Tabla inventario de municiones
        Schema::create('inventario_municiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municiones_id')->constrained('catalogo_municiones')->onDelete('cascade');
            $table->foreignId('aerodromo_id')->constrained('aerodromos')->onDelete('cascade');
            $table->integer('cantidad');


    });

            //Tabla movimiento inventario
            Schema::create('movimiento_inventario', function (Blueprint $table) {
                $table->id();
                $table->foreignId('aerodromo_id')->constrained('aerodromos')->onDelete('cascade');
                $table->foreignId('municiones_id')->constrained('catalogo_municiones')->onDelete('cascade');
                $table->string('tipo_movimiento');

    });

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('movimiento_inventario');
        Schema::dropIfExists('inventario_municiones');
        Schema::dropIfExists('catalogo_municiones');
    }
};
