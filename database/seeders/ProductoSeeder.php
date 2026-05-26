<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Producto::create([
            'nombre' => 'Laptop HP Pavilion',
            'precio' => 850.00,
            'stock' => 10
        ]);

        \App\Models\Producto::create([
            'nombre' => 'Mouse Óptico Logitech',
            'precio' => 15.50,
            'stock' => 50
        ]);

        \App\Models\Producto::create([
            'nombre' => 'Teclado Mecánico Redragon',
            'precio' => 45.00,
            'stock' => 30
        ]);

        \App\Models\Producto::create([
            'nombre' => 'Monitor 24" LED LG',
            'precio' => 180.00,
            'stock' => 15
        ]);

        \App\Models\Producto::create([
            'nombre' => 'Auriculares Gamer HyperX',
            'precio' => 35.00,
            'stock' => 25
        ]);
    }
}
