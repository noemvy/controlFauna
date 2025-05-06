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
        //Tabla evento
        Schema::create('evento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aerodromo_id')->constrained('aerodromos')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->string('tipo_evento');
            $table->string('comentario');
            $table->timestamps();
        });

        //Tabla patrullaje
        Schema::create('patrullaje', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aerodromo_id')->constrained('aerodromos')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->string('inicio');
            $table->string('fin');
            $table->timestamps();
        });

        //Tabla Intervenciones
        Schema::create('intervenciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('especies_id')->constrained('especies')->onDelete('cascade');
            $table->foreignId('catinventario_id')->constrained('catalogo_inventarios')->onDelete('cascade');
            $table->foreignId('acciones_id')->constrained('acciones')->onDelete('cascade');
            $table->foreignId('atractivos_id')->constrained('atractivos')->onDelete('cascade');
            $table->morphs('reportable');
            $table->integer('vistos')->nullable();
            $table->integer('sacrificados')->nullable();
            $table->integer('dispersados')->nullable();
            $table->decimal('coordenada_x', 10, 6)->nullable();
            $table->decimal('coordenada_y', 10, 6)->nullable();
            $table->json('fotos')->nullable();
            $table->float('temperatura')->nullable();
            $table->float('viento')->nullable();
            $table->float('humedad')->nullable();
            $table->text('comentarios')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('intervenciones');
        Schema::dropIfExists('patrullaje');
        Schema::dropIfExists('evento');
    }
};
