@extends('backEnd.master')
@section('title') 
@lang('gallery.gallery_list')
@endsection
<style type="text/css">
    .img-container {
      position: relative;
      width: 100%; /* fixed width */
      height: 200px; /* fixed height */
      margin: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      overflow: hidden;
    }

    .img-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .delete-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 1;
      cursor: pointer;
    }
    /* increase modal size */
      .modal-lg {
        max-width: 800px; /* adjust the width as needed */
      }

      /* increase image size */
      .image-container img {
        width: 200px; /* adjust the width as needed */
        height: 150px; /* adjust the height as needed */
        margin: 10px; /* add some margin for spacing */
      }
</style>
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('gallery.gallery_list')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('gallery.gallery')</a>
                <a href="#">@lang('gallery.gallery_list')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($gallery))
         @if(userPermission("chart-of-account-store"))

        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('chart-of-account')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </a>
            </div>
        </div>
        @endif
        @endif
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12 white-box">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($single_gallery))
                                    @lang('gallery.edit_gallery')
                                @else
                                    @lang('gallery.add_gallery')
                                @endif
                               
                            </h3>
                        </div>
                        @if(isset($single_gallery))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true,  'route' => array('chart-of-account-update',@$single_gallery->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                          @if(userPermission("chart-of-account-store")) 

                          @endif

                          {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'uploadGallery',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        <div class="form-group">
                            <label for="gallery_name">Gallery Name:</label>
                            <input type="text" class="form-control" id="gallery_name" name="gallery_name" required>
                          </div>
                          <div class="form-group">
                            <label for="location">Location:</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                          </div>
                          <div class="form-group">
                            <label for="location">Date:</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                          </div>
                          <!-- Add other required fields for gallery here -->
                          <div class="form-group">
                            <label for="images">Images:</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple required>
                          </div>
                          <div class="text-center">
                                <button type="submit" class="btn btn-primary">Upload</button>
                          </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('gallery.gallery_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <x-table>
                        <table id="table_id" class="table" cellspacing="0" width="100%">

                            <thead>
                               
                                <tr>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('gallery.date')</th>
                                    <th>@lang('gallery.location')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($gallery as $single_gallery)
                                <tr>
                                    <td>{{@$single_gallery->title}}</td>
                                    <td>{{@$single_gallery->date}}</td>
                                    <td>{{@$single_gallery->location}}</td>
                                    <td>
                                        <button type="button" class="primary-btn" onclick="getGalleryImages(this, {{$single_gallery->id}});">
                                          View Gallery
                                        </button>
                                        <a href="{{ route('deleteGallery', $single_gallery->id) }}"><button type="button" class="btn btn-primary">Delete</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- model box for display images -->
<div class="modal" id="gallery-modal">
  <div class="modal-dialog modal-lg"> <!-- added modal-lg class -->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Gallery Images</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <!-- Images will be displayed here -->
        <div class="image-container"> <!-- added image-container class -->
          <!-- images will be appended here -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@include('backEnd.partials.data_table_js')
<script>
  function getGalleryImages(button,galleryId) {
    $(button).html('Loading...'); // change button text to "Loading..."
    var modal = $('#gallery-modal'); // Define the modal variable
    var modalBody = modal.find('.modal-body');
    modalBody.empty();
    /*for button element*/
    $.ajax({
      type: 'GET',
      url: '{{ route("getGalleryImages") }}',
      data: { gallery_id: galleryId },
      success: function(data) {
        var row = $('<div class="row">');
        var imageCount = 0;

        $.each(data, function(index, image) {
          var col = $('<div class="col-md-4">');
          var imgContainer = $('<div class="img-container">');
          var img = $('<img src="' + image.images + '">');
          img.appendTo('.image-container');
          imgContainer.append(img);
          col.append(imgContainer);

          // Add delete button on hover
          imgContainer.hover(function() {
            var deleteButton = $(`<a href="{{ route('deleteSingleImage', ':id') }}"><button class="btn btn-danger delete-btn">Delete</button></a>`);
            deleteButton.attr('href', deleteButton.attr('href').replace(':id', image.id));

            imgContainer.append(deleteButton);
          }, function() {
            imgContainer.find('.delete-btn').remove();
          });

          imgContainer.on('click', '.delete-btn', function() {
            // Delete image logic here
            console.log('Delete image ', image.id);
          });

          row.append(col);
          imageCount++;

          if (imageCount === 3) {
            modalBody.append(row);
            row = $('<div class="row">');
            imageCount = 0;
          }
        });

        if (imageCount > 0) {
          modalBody.append(row);
        }

        // Show the modal
        modal.modal('show');
        $(button).html('View Gallery'); // change button text back to "View"
      }
    });
  }
</script>