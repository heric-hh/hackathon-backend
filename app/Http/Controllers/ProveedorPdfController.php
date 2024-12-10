<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PdfProveedores;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProveedorAutorizado;
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

    public function listarPdf(Request $request) {
        //Obtener los pdf con paginacion
        $pdfs = PdfProveedores::orderBy('created_at', 'desc')->paginate($request->input('per_page', 10));

        //Transformar la respuesta para incluir la URL completa del archivo
        $pdfs->getCollection()->transform(function ($pdf) {
            return [
                'id' => $pdf->id,
                'nombre_archivo' => $pdf->nombre_archivo,
                'ruta_archivo' => Storage::url($pdf->ruta_archivo),
                'fecha_generacion' => $pdf->fecha_generacion,
                'total_proveedores' => $pdf->total_proveedores,
                'created_at' => $pdf->created_at,
            ];
        });
        return response()->json($pdfs);
    }

    //Método para descargar un PDF especifico
    public function descargarPdf($id) {
        $pdf = PdfProveedores::findOrFail($id);

        //Verificar si el archivo existe
        if(!Storage::exists($pdf->ruta_archivo)) {
            return response()->json([
               'mensaje' => 'El archivo no existe'
            ], 404);
        }

        //Descargar el archivo
        return Storage::download($pdf->ruta_archivo, $pdf->nombre_archivo);
    }

    //Metodo para eliminar un PDF
    public function eliminarPdf($id) {
        $pdf = PdfProveedores::findOrFail($id);
        
        if(!Storage::exists($pdf->ruta_archivo)) {
            return response()->json([
                'mensaje' => 'El archivo no existe'
            ], 404);
        }
        //Eliminar el archivo del sistema de archivos
        if(Storage::exists($pdf->ruta_archivo)) {
            Storage::delete($pdf->ruta_archivo);
        }


        //Eliminar el registro de la base de datos
        $pdf->delete();

        return response()->json(['mensaje' => 'PDF eliminado exitosamente'], 200);
    }
}
