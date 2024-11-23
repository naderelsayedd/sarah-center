@extends('backEnd.master')
@section('title') 
@lang('gallery.gallery_detail')
@endsection
<style type="text/css">
  .image-container img {
        width: 100%;
    height: 100%;
    object-fit: cover;
    }
  .modal-full-width {
    width: 100%;
    max-width: none;
  }
  #comments-container{
      border: 1px solid #f1ecec;
      padding: 13px;
      /* border-radius: 6px; */
      max-height: 272px;
      overflow-y: scroll;
  }
  .img-circle{
      width: 38px;
      margin-right: 10px;
  }
  .image-container {
      position: relative;
  }

  /* .image-overlay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      justify-content: space-between;
      width: 100px;
      background-color: rgba(0, 0, 0, 0.5);
      display: none;
  }

  .image-container:hover .image-overlay {
      display: flex;
  } */
</style>
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('gallery.gallery_detail')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('gallery.gallery')</a>
                <a href="#">@lang('gallery.gallery_detail')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">

            <div class="col-lg-12">
                <div class="white-box">
                  <div class="row">
                      <div class="col-lg-12 no-gutters mb-2">
                          <div class="main-title">
                            <div class="text-center">
                                <h3 class="mb-0">{{$gallery->title}}</h3>
                                <span class="mb-0">{{$gallery->date}}</span> | 
                                <span class="mb-0">{{$gallery->location}}</span>
                            </div>
                          </div>
                          <div class="button" style="float:right;">
                              <input type="file" id="image-upload" accept="image/*" style="display:none;">
                              <input type="hidden" name="gallery_id" value="{{$gallery->id}}">
                              <a class="primary-btn small fix-gr-bg" data-toggle="modal" data-target="#imageUploadModal"> 
                                <span class="ti-plus pr-2"></span> @lang('common.add_image')
                              </a>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    @foreach($gallery->images as $gallery_image)
                        <div class="col-lg-3 col-md-6">

                        <div class="image-gallery-box position-relative">
                            <img src="{{ asset($gallery_image->images) }}" class="img-fit w-100" data-toggle="modal" data-target="#carouselModal" data-slide-to="{{ $loop->index }}" data-gallery-id="{{ $gallery_image->id }}" data-image-path="{{ asset($gallery_image->images) }}" data-image-id="{{ $gallery_image->id }}">
                            <div class="comment-count-badge position-absolute" style="top:10px;left:10px;background-color:#e3e0e0;border-radius:50%;padding:1px 10px;font-size:12px;font-weight:bold;color:#333;">
                              {{ $gallery_image->comments_count }}
                            </div>
                            <div class="gallery-reactions">
                                <div class="image-like"><a href="#"><i class="far fa-thumbs-up"></i> 1024</a></div>
                                <div class="image-dislike"><a href="#"><i class="far fa-thumbs-down"></i> 20</a></div>
                            </div>

                            <div class="image-overlay">
															<?php if (Auth::user()->role_id == 4):?>
																<form action="{{ route('deleteSingleImage', $gallery_image->id) }}" method="POST" class="delete-form">
																	@csrf
																	@method('DELETE')
																	<button type="submit" class="delete-icon">
																		<i class="fas fa-trash"></i>
																	</button>
																</form>
															<?php endif?>
															<a href="{{ route('downloadSingleImage', $gallery_image->id) }}" class="download-icon">
																<i class="fas fa-download"></i>
															</a>
                            </div>

                          </div>

                      </div>
                    @endforeach
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal popup -->
<div class="modal fade" id="carouselModal" tabindex="-1" role="dialog" aria-labelledby="carouselModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-full-width" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="carouselModalLabel">Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 p-0">
              <!-- Image will be displayed here -->
              <img src="" id="image-preview" class="img-fluid">
            </div>
            <div class="col-md-6 p-0">
              <!-- Comments will be displayed here -->
								<div id="comments-container">Loading comments...</div>
								<form id="comment-form" method="POST" action="{{ route('comments.store') }}">
									@csrf
									<input type="hidden" name="image_id" value="">
									<input type="hidden" name="gallery_id" value="">
									<div class="form-group">
										<textarea name="comment" class="form-control" placeholder="Enter your comment" rows="1"></textarea>
									</div>
									<button type="submit" class="primary-btn small fix-gr-bg" style="float: right;">Submit</button>
								</form>                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="imageUploadModal" tabindex="-1" role="dialog" aria-labelledby="imageUploadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageUploadModalLabel">@lang('common.upload_image')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form id="image-form" action="{{route('uploadSingleImage')}}" method="post" enctype="multipart/form-data">
            <div class="col-md-12">
              <select id="image-source" class="form-control">
                <option disabled selected>@lang('common.option')</option>
                <option value="storage">@lang('common.upload_from_storage')</option>
                <option value="camera">@lang('common.take_photo')</option>
              </select>
            </div>
            <div class="col-md-12" id="storage-option" style="display: none;">
              <h5>@lang('common.upload_from_storage')</h5>
              @csrf
              <input type="file" id="image-upload-input" accept="image/*" name="image">
              <input type="hidden" name="gallery_id" value="{{$gallery->id}}">
              <button class="btn btn-success" id="save-image-btn">@lang('common.save_image')</button>
            </div>
            <div class="col-md-12" id="camera-option" style="display: none;">
              <h5>@lang('common.take_photo')</h5>
              <video id="camera-preview" width="100%" height="300" autoplay></video>
              <button class="btn btn-primary" onclick="takePhoto()">@lang('common.take_photo')</button>
              <canvas id="canvas" style="display: none;"></canvas>
              <input type="hidden" id="captured-image" name="image">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#image-source').on('change', function() {
      var selectedOption = $(this).val();
      if (selectedOption === 'storage') {
        $('#storage-option').show();
        $('#camera-option').hide();
      } else if (selectedOption === 'camera') {
        $('#storage-option').hide();
        $('#camera-option').show();
      }
    });
  });
</script>

<script>
  let cameraStream = null;
  let capturedImage = null;

  function uploadImageFromCamera() {
    console.log('Requesting access to camera...');
    navigator.mediaDevices.getUserMedia({ video: true, audio: false })
     .then(stream => {
        console.log('Camera access granted!');
        cameraStream = stream;
        document.getElementById('camera-preview').srcObject = stream;
      })
     .catch(error => {
        console.error('Error accessing camera:', error);
        alert('Error accessing camera. Please check your camera settings and try again.');
      });
  }

  function takePhoto() {
    if (!cameraStream) return;

    const video = document.getElementById('camera-preview');
    const canvas = document.getElementById('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    capturedImage = canvas.toDataURL('image/jpeg');
    const byteString = atob(capturedImage.split(',')[1]);
    const arrayBuffer = new ArrayBuffer(byteString.length);
    const uint8Array = new Uint8Array(arrayBuffer);

    for (let i = 0; i < byteString.length; i++) {
      uint8Array[i] = byteString.charCodeAt(i);
    }

    const file = new File([uint8Array], 'camera-image.jpg', {
      type: 'image/jpeg',
    });

    const fileInput = document.getElementById('image-upload-input');
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    fileInput.files = dataTransfer.files;
    const formData = new FormData();
    formData.append('image', file);
    const form = document.getElementById('image-form');
    form.submit(); // Submit the form
  }

  // Call the uploadImageFromCamera() function when the modal is shown
  $('#imageUploadModal').on('shown.bs.modal', function() {
    uploadImageFromCamera();
  });
</script>





<!-- JavaScript code to fetch comments and display in modal -->
<script>
  $(document).ready(function() {
    $('#carouselModal').on('show.bs.modal', function(event) {
      var imageId = $(event.relatedTarget).data('image-id');
      var galleryId = $(event.relatedTarget).data('gallery-id');
      var imagePath = $(event.relatedTarget).data('image-path');
      // Update the hidden input values
      $('#comment-form input[name="image_id"]').val(imageId);
      $('#comment-form input[name="gallery_id"]').val(galleryId);
      $('#image-preview').attr('src', imagePath);
      $.ajax({
        type: 'GET',
        url: '{{ route('comments.index', ['imageId' => '__imageId__', 'galleryId' => '__galleryId__']) }}'.replace('__imageId__', imageId).replace('__galleryId__', galleryId),
        success: function(data) {
          var commentsHtml = '';
          $.each(data, function(index, comment) {
            commentsHtml += `
              <div class="media comment" id="comment-${comment.id}">
                <div class="media-left">
                  <img src="https://static.thenounproject.com/png/363640-200.png" class="media-object img-circle" alt="${comment.user ? comment.user.full_name : 'Anonymous'}">
                </div>
                <div class="media-body">
                  <h5 class="media-heading">${comment.user ? comment.user.full_name : 'Anonymous'}</h5>
                  <div class="comment-txt">${comment.comment}</div>
                  <small class="text-muted">
                    ${moment(comment.created_at).format('YYYY-MM-DD')}
                    <a href="#" class="reply-link" data-comment-id="${comment.id}">
                      <i class="fas fa-reply"></i> Reply
                    </a>
                  </small>
                  <div class="reply-form" style="display: none;">
                    <form>@csrf
                      <input type="hidden" name="image_id" value="${imageId}">
                      <input type="hidden" name="gallery_id" value="${galleryId}">
                      <input type="hidden" name="parent_id" value="${comment.id}">
                      <textarea name="comment" class="form-control"></textarea>
                      <button class="btn btn-primary btn-sm" style="float:right;">Reply</button>
                    </form>
                  </div>
                  <div class="replies-container">
                    ${renderReplies(comment.replies, imageId, galleryId)}
                  </div>
                </div>
              </div><hr>
            `;
          });
          $('#comments-container').html(commentsHtml);

          // Add event listener to reply links
          $('.reply-link').on('click', function(event) {
            event.preventDefault();
            var commentId = $(this).data('comment-id');
            var replyForm = $(this).closest('.media-body').find('.reply-form');
            replyForm.slideToggle();
          });

          // Add event listener to reply form submit
          $('#comments-container').on('submit', '.reply-form form', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var form = $(this);
            $.ajax({
              type: 'POST',
              url: '{{ route('comments.store') }}',
              data: formData,
              success: function(data) {
                if (data) {
                  window.location.reload();
                }
                console.log(data);
                // Update the comments container with the new reply
                var newReplyHtml = `
                  <div class="media comment" id="comment-${data.id}">
                    <div class="media-left">
                      <img src="https://static.thenounproject.com/png/363640-200.png" class="media-object img-circle" alt="${data.user ? data.user.full_name : 'Anonymous'}">
                    </div>
                    <div class="media-body">
                      <h5 class="media-heading">${data.user ? data.user.full_name : 'Anonymous'}</h5>
                      <div>${data.comment}</div><br>
                      <small class="text-muted">${moment(data.created_at).format('YYYY-MM-DD')}</small>
                    </div>
                  </div><hr>
                `;
                form.closest('.media-body').find('.replies-container').append(newReplyHtml);
                form.find('textarea').val('');
                form.hide();
              }
            });
          });
        }
      });
    });
  });

  function renderReplies(replies, imageId, galleryId) {
    var repliesHtml = '';
    $.each(replies, function(index, reply) {
      repliesHtml += `
        <div class="media comment" id="comment-${reply.id}">
          <div class="media-left">
            <img src="https://static.thenounproject.com/png/363640-200.png" class="media-object img-circle" alt="${reply.user ? reply.user.full_name : 'Anonymous'}">
          </div>
          <div class="media-body">
            <h5 class="media-heading">${reply.user ? reply.user.full_name : 'Anonymous'}</h5>
            <div class="comment-txt">${reply.comment}</div>
            <small class="text-muted">${moment(reply.created_at).format('YYYY-MM-DD')}</small>
          </div>
        </div><hr>
      `;
    });
    return repliesHtml;
}

</script>


@endsection
@include('backEnd.partials.data_table_js')
