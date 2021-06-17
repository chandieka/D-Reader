<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var string
    */
    protected $model = Gallery::class;

    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, voluptatem est fuga",
            'title_original' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, voluptatem est fuga",
            'thumbnail' => asset('img/default/na-480.png'),
            'dir_path' => "/",
            'isHidden' => false,
        ];
    }
}
