<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultCategories = json_decode(file_get_contents(__DIR__ . '/../default/categories.json'));
        foreach ($defaultCategories->data as $value) {
            DB::table('categories')->insert([
                'name' => $value,
                'created_at' => Date::now()->toDateTimeString(),
                'updated_at' => Date::now()->toDateTimeString(),
            ]);
        }
    }
}
