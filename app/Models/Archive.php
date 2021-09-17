<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archive extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable..
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user/uploader of the archive
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the process gallery from this archive
     *
     */
    public function gallery()
    {
        return $this->hasOne(Gallery::class);
    }

    public function isPublic()
    {
        // TODO: add isPublic field
        // return $this->isPublic;
        return true;
    }
}
