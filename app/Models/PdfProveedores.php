<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfProveedores extends Model
{
    use HasFactory;

    protected $table = 'pdf_proveedores';

    protected $fillable = [
        'nombre_archivo',
        'ruta_archivo',
        'fecha_generacion',
        'total_proveedores'
    ];
}
