<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = json_decode(file_get_contents(__DIR__ . '/../default/categories.json'))->data;
        foreach ($categories as $value) {
            $temp[] = ['name' => $value];
        }
        Category::insert($temp);
    }
}
