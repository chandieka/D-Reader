<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = json_decode(file_get_contents(__DIR__ . '/../default/tags.json'))->data;
        $temp = [];

        foreach ($tags as $tag) {
            $temp[] = [
                "name" => $tag
            ];
        }
        Tag::insert($temp);
    }
}
