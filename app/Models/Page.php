<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable..
     *
     * @var array
     */
    protected $guard = [];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
