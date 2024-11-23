@extends(config('pagebuilder.site_layout'), ['edit' => false])
{{headerContent()}}
@php
    $gs = generalSetting();
@endphp
<!-- about area start -->
<div class="inner-header bg-styles" style="background-image: url({{asset('public/theme/edulia/images/hero-bg.jpg')}});">
  <div class="container">
    <div class="row">
      <div class="col-12"><div class="inner-title">معرض الفيديوهات</div></div>
    </div>
  </div>
</div>


<x-video-gallery :column="pagesetting('video_gallery_column')" :count="pagesetting('video_gallery_count')" :sorting="pagesetting('photo_gallery_sorting')"></x-video-gallery>
   
{{footerContent()}}
