<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = 'propiedades';

    protected $fillable = [
        'titulo',
        'slug',
        'meta_descripcion',
        'imagen_principal',
        'estado',
        'precio',
        'moneda',
        'tipo_operacion',
        'tipo_propiedad',
        'habitaciones',
        'banos',
        'cocheras',
        'superficie_cubierta',
        'superficie_total',
        'descripcion',
        'direccion',
        'ciudad',
        'provincia',
        'barrio',
        'latitud',
        'longitud',
        'publicada',
        'destacada',
        'fecha_publicacion',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'publicada' => 'boolean',
        'destacada' => 'boolean',
        'fecha_publicacion' => 'datetime',
    ];

    public function scopeActivas($query)
    {
        return $query->where('publicada', true);
    }
    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }
}