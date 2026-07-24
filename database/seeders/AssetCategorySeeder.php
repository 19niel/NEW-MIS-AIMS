<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssetCategory;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptop', 'slug' => 'laptop', 'description' => 'Portable computers'],
            ['name' => 'Desktop', 'slug' => 'desktop', 'description' => 'Workstation computers'],
            ['name' => 'Monitor', 'slug' => 'monitor', 'description' => 'Display screens'],
            ['name' => 'Peripheral', 'slug' => 'peripheral', 'description' => 'Keyboards, Mice, etc.'],
            ['name' => 'Server', 'slug' => 'server', 'description' => 'Network servers'],
        ];

        foreach ($categories as $category) {
            AssetCategory::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
