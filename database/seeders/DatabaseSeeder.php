<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ProveedorAutorizado;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
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
