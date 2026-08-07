<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gamer',
                'description' => 'Equipos de alto rendimiento orientados a videojuegos.',
            ],
            [
                'name' => 'VIP',
                'description' => 'Computadoras premium con hardware de alto rendimiento.',
            ],
            [
                'name' => 'Estándar',
                'description' => 'Equipos para navegación, estudio y trabajos generales.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
