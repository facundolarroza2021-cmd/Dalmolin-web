<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;
    
    protected $fillable = ['propiedad_id', 'ruta'];

    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }
}