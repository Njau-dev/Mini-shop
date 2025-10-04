<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'hat'],
            ['name' => 'shirt'],
            ['name' => 'jacket'],
            ['name' => 'trouser'],
            ['name' => 'short'],
            ['name' => 'shoe'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
