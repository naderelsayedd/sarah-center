@extends(config('pagebuilder.site_layout'), ['edit' => false])
{{headerContent()}}
@php
    $gs = generalSetting();
@endphp
<!-- about area start -->
<div class="inner-header bg-styles" style="background-image: url({{asset('public/theme/edulia/images/hero-bg.jpg')}});">
  <div class="container">
    <div class="row">
      <div class="col-12"><div class="inner-title">معرض الصور</div></div>
    </div>
  </div>
</div>


<x-photo-gallery :column="pagesetting('photo_gallery_column')" :count="pagesetting('photo_gallery_count')" :sorting="pagesetting('photo_gallery_sorting')"></x-photo-gallery>

{{footerContent()}}
