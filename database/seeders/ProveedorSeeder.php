<?php
namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;
use App\Models\ProveedorAutorizado;

class ProveedorSeeder extends Seeder
{
    public function run()
    {
      // Poblar la tabla con 10 proveedores dummy
        for ($i = 0; $i < 10; $i++) {
            ProveedorAutorizado::create([
                'proveedor' => 'Proveedor ' . $i,
                'medio_de_contacto' => $i,
                'nombre_del_contacto' => 'Nombre  ' . $i,
                'clasificacion' => 'Clasificacion ' . $i
                // Agrega más atributos según sea necesario
            ]);
        }
    }
}