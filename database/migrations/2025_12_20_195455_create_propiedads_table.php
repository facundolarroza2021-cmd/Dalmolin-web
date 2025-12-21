<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('propiedades', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('meta_descripcion')->nullable();

            $table->decimal('precio', 12, 2);
            $table->string('moneda', 3)->default('USD');
            $table->enum('tipo_operacion', ['venta', 'alquiler', 'temporal']); 
            $table->enum('tipo_propiedad', ['casa', 'departamento', 'terreno', 'local', 'oficina']);

            $table->integer('habitaciones')->nullable();
            $table->integer('banos')->nullable();
            $table->integer('cocheras')->nullable();
            $table->integer('superficie_cubierta')->nullable();
            $table->integer('superficie_total')->nullable();
            $table->longText('descripcion');

            $table->string('direccion')->nullable();
            $table->string('ciudad');
            $table->string('provincia');
            $table->string('barrio')->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();

            $table->boolean('publicada')->default(false);
            $table->boolean('destacada')->default(false);
            $table->timestamp('fecha_publicacion')->nullable();

            $table->timestamps(); 

            $table->index(['publicada', 'tipo_operacion', 'tipo_propiedad']);
            $table->index('precio');
            $table->index('ciudad');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propiedades');
    }
};
