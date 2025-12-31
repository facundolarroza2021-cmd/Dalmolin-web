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
        'latitud',
        'longitud',
        'cocheras',
        'video_url',
        'superficie_cubierta',
        'superficie_total',
        'descripcion',
        'direccion',
        'ciudad',
        'provincia',
        'barrio',
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
    public function getEmbedUrlAttribute()
{
    $url = $this->video_url;

    if (!$url) return null;

    // Lógica para YouTube: Convertir 'watch?v=' a 'embed/'
    if (str_contains($url, 'youtube.com/watch?v=')) {
        $videoId = explode('v=', $url)[1];
        // Quitar parámetros extra si los hay (&t=...)
        $videoId = explode('&', $videoId)[0]; 
        return "https://www.youtube.com/embed/{$videoId}";
    }
    
    // Lógica para YouTube corto (youtu.be)
    if (str_contains($url, 'youtu.be/')) {
        $videoId = explode('youtu.be/', $url)[1];
        return "https://www.youtube.com/embed/{$videoId}";
    }

    // Para Matterport, Kuula o Vimeo, devolvemos la URL tal cual
    return $url;
}
}