<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Retrieve galleries that are tagged with this tag
     *
     */
    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }
}
