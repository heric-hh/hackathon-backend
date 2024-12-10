<?php

namespace App\Http\Controllers;

use App\Models\ProveedorAutorizado;
use App\Models\PdfProveedores;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProveedorPdfController extends Controller
{
    public function generarPdfProveedores()
    {
        // Obtener todos los proveedores autorizados
        $proveedores = ProveedorAutorizado::all();

        // Generar el PDF
        $pdf = PDF::loadView('pdfs.proveedores', [
            'proveedores' => $proveedores
        ]);

        // Generar un nombre de archivo único
        $nombreArchivo = 'proveedores_autorizados_' . now()->format('YmdHis') . '.pdf';

        // Guardar el PDF en el disco local
        $rutaArchivo = 'pdfs/proveedores/' . $nombreArchivo;
        Storage::put($rutaArchivo, $pdf->output());

        // Crear un registro en la tabla de PDFs
        $registroPdf = PdfProveedores::create([
            'nombre_archivo' => $nombreArchivo,
            'ruta_archivo' => $rutaArchivo,
            'fecha_generacion' => now(),
            'total_proveedores' => $proveedores->count()
        ]);

        return response()->json([
            'mensaje' => 'PDF generado exitosamente',
            'archivo' => $registroPdf
        ]);
    }
}
