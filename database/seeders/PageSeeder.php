<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($j=1; $j <= 50; $j++) {
            for ($i = 1; $i <= 20; $i++) {
                DB::table('pages')->insert([
                    'gallery_id' => $j,
                    'filename' => 'img/default/NotFound-720p.png',
                    'page_number' => $i,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
            }
        }
    }
}
