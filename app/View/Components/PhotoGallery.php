<?php

namespace App\View\Components;

use Closure;
use App\Models\SmPhotoGallery;
use App\Gallery;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PhotoGallery extends Component
{
    public $count;
    public $column;
    public $sorting;
    /**
     * Create a new component instance.
     */
    public function __construct($count = 3, $column = 4, $sorting = 'asc')
    {
        $this->count = $count;
        $this->column = $column;
        $this->sorting = $sorting;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $photoGalleries = Gallery::with('images', 'comments')->get();
        $photoGalleries->where('school_id', app('school')->id);
        return view('components.' . activeTheme() . '.photo-gallery', compact('photoGalleries'));
    }
}
