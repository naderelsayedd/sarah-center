<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryComments extends Model
{
    protected $table = 'gallery_comments';
    protected $fillable = ['gallery_id', 'image_id', 'parent_id', 'user_id', 'comment'];

    public function image()
    {
        return $this->belongsTo(GalleryImage::class);
    }

    public function replies()
    {
        return $this->hasMany(GalleryComments::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(GalleryComments::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}


?>