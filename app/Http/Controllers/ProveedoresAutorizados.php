<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProveedorAutorizado;
use Illuminate\Support\Facades\Validator;

class ProveedoresAutorizados extends Controller
{
    public function index() {
        $proveedores = ProveedorAutorizado::all();
        return response()->json([
            'proveedores' => $proveedores,
        ]);
    }

    public function store(Request $request) {
        $validated = Validator::make($request->all(), [
            'proveedor' => 'required',
            'medio_de_contacto' => 'required',
            'nombre_del_contacto' => 'required',
            'clasificacion' => 'required',
        ]);
        
        if($validated->fails()) {
            return response()->json([
                'message' => 'Todos los campos son requeridos',
                'errors' => $validated->errors(),]);
        }

        $validated = $validated->validate();

        $proveedor = new ProveedorAutorizado();
        $proveedor->proveedor = $validated['proveedor'];
        $proveedor->medio_de_contacto = $validated['medio_de_contacto'];
        $proveedor->nombre_del_contacto = $validated['nombre_del_contacto'];
        $proveedor->clasificacion = $validated['clasificacion'];
        $proveedor->save();

        return response()->json([
            'message' => 'Proveedor creado correctamente',
            'proveedor' => $proveedor,
        ]);
    }
}
