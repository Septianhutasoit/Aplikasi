<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Kopi',
                'slug' => 'kopi',
                'description' => 'Berbagai jenis kopi dan minuman serupa',
                // 'image' => null,
            ],
            [
                'name' => 'Baju',
                'slug' => 'baju',
                'description' => 'Pakaian pria dan wanita terbaru',
            ],
            [
                'name' => 'Celana',
                'slug' => 'celana',
                'description' => 'Berbagai pilihan celana kasual dan formal',
            ],
            [
                'name' => 'Topi',
                'slug' => 'topi',
                'description' => 'Beragam topi untuk gaya dan perlindungan',
            ],
            [
                'name' => 'Jaket',
                'slug' => 'jaket',
                'description' => 'Jaket untuk berbagai cuaca dan aktivitas',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
