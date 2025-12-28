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
        'porcentaje_descuento',
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'precio' => 'decimal:2',
        'publicada' => 'boolean',
        'destacada' => 'boolean',
    ];

    public function scopeActivas($query)
    {
        return $query->where('publicada', true);
    }
    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }
    public function getPrecioFinalAttribute()
    {
        if ($this->porcentaje_descuento > 0) {
            return $this->precio - ($this->precio * ($this->porcentaje_descuento / 100));
        }
        return $this->precio;
    }
}