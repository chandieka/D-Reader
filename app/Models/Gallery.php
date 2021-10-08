<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [];

    /**
     * The attributes that aren't mass assignable..
     *
     * @var array
     */
    protected $guarded = [];

    /**
     *  Get all the pages from the gallery
     *
     */
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get the category for the gallery
     *
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the language in used in the gallery
     *
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the uploader of the gallery
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all artist that contribute on creating the gallery
     *
     */
    public function artist()
    {
        return $this->belongsToMany(Artist::class);
    }

    /**
     * Get all the tags for the gallery
     *
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }
}
