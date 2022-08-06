<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteGallery extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable..
     *
     * @var array
     */
    protected $guarded = [];

    public function gallery()
    {
        return $this->belongsToMany(Gallery::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
