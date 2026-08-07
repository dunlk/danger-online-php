<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Computer;
use Illuminate\Database\Seeder;

class ComputerSeeder extends Seeder
{
    public function run(): void
    {
        $gamer = Category::where('name', 'Gamer')->firstOrFail();
        $vip = Category::where('name', 'VIP')->firstOrFail();
        $standard = Category::where('name', 'Estándar')->firstOrFail();

        $computers = [
            [
                'name' => 'PC-01',
                'category_id' => $vip->id,
                'processor' => 'Intel Core i7-14700F',
                'ram' => 32,
                'graphics' => 'RTX 4070',
                'storage' => 'SSD NVMe 1 TB',
                'monitor' => '27" 165 Hz',
                'hourly_price' => 5.00,
                'status' => 'available',
                'description' => 'Equipo premium para juegos competitivos y títulos de alto rendimiento.',
            ],
            [
                'name' => 'PC-02',
                'category_id' => $gamer->id,
                'processor' => 'AMD Ryzen 5 7600',
                'ram' => 16,
                'graphics' => 'RTX 4060',
                'storage' => 'SSD NVMe 1 TB',
                'monitor' => '24" 144 Hz',
                'hourly_price' => 4.00,
                'status' => 'available',
                'description' => 'Equipo gamer equilibrado para juegos competitivos y uso general.',
            ],
            [
                'name' => 'PC-03',
                'category_id' => $standard->id,
                'processor' => 'Intel Core i5-12400',
                'ram' => 16,
                'graphics' => 'Intel UHD Graphics',
                'storage' => 'SSD 512 GB',
                'monitor' => '24" 75 Hz',
                'hourly_price' => 2.50,
                'status' => 'available',
                'description' => 'Equipo para navegación, estudios, ofimática y trabajos académicos.',
            ],
        ];

        foreach ($computers as $computer) {
            Computer::updateOrCreate(
                ['name' => $computer['name']],
                $computer
            );
        }
    }
}
