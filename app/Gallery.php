<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';

    public function images()
    {
        return $this->hasMany(GalleryImages::class, 'gallery_id');
    }

    public function comments()
    {
        return $this->hasMany(GalleryComments::class);
    }

}
