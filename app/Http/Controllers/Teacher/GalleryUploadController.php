<?php
	
	namespace App\Http\Controllers\teacher;
	
	use App\Gallery;
	use App\GalleryImages;
	use App\GalleryComments;
	use Illuminate\Support\Facades\Validator;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use Brian2694\Toastr\Facades\Toastr;
	use File;
	use ZipArchive;
	use DB;
	class GalleryUploadController extends Controller
	{
		// Upload image to the gallery
		public function uploadGalleryImage(Request $request)
		{
			try {
				$validator = Validator::make($request->all(), [
                'gallery_name' => 'required',
                'location' => 'required',
                'date' => 'required|date',
                'class' => 'required',
                'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				]);
				if ($validator->fails()) {
					Toastr::error($validator->errors()->first(), 'Failed');
					return redirect()->back();
					} else {
					// Create a new gallery
					$gallery                = new Gallery();
					$gallery->teacher_id    = auth()->id();
					$gallery->title         = $request->input('gallery_name');
					$gallery->date          = $request->input('date');
					$gallery->class_id      = $request->input('class');
					$gallery->location      = $request->input('location');
					$gallery->save();
					
					// Upload and save images
					if ($request->hasFile('images')) {
						$images = $request->file('images');
						foreach ($images as $image) {
							$fileName = $request->teacher_id. str_replace('.', '', microtime(true)). ".". $image->getClientOriginalExtension();
							$image->move('public/uploads/gallery/', $fileName);
							$fileName = 'public/uploads/gallery/'. $fileName;
							
							$galleryImage = new GalleryImages();
							$galleryImage->gallery_id = $gallery->id;
							$galleryImage->images = $fileName;
							$galleryImage->save();
						}
					}
					
					Toastr::success('Gallery and images uploaded successfully.', 'Success');
					return redirect()->back();
				}
				} catch (Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();
			}
		}
		
		public function getGalleryImages(Request $request)
		{
			$galleryId = $request->input('gallery_id');
			$galleryImages = GalleryImages::where('gallery_id', $galleryId)->get();
			
			return response()->json($galleryImages);
		}
		
		
		public function destroy($id)
		{
			
			$image = Gallery::findOrFail($id);
			File::delete($image->image);
			$galleryImages = GalleryImages::where('gallery_id', $image->id)->get();
			foreach ($galleryImages as $key => $value) {
				File::delete($value->images);
			}
			GalleryImages::where('gallery_id', $image->id)->delete();
			if ($image->delete()) {
				Toastr::success('Image deleted successfully.', 'Success');
				return redirect()->back();
				}else{
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();   
			}
		}
		
		
		public function listing()
		{
			try {
				$gallery = Gallery::with('images')->get();
				return view('backEnd.gallery.gallery_list',compact('gallery'));
				} catch (Exception $e) {
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();   
			}
		}
		
		public function singleDelete($id)
		{
			$galleryImages = GalleryImages::where('id', $id)->first();
			File::delete($galleryImages->images);
			if ($galleryImages->delete()) {
				Toastr::success('Image deleted successfully.', 'Success');
				return redirect()->back();
				}else{
				Toastr::error('Operation Failed', 'Failed');
				return redirect()->back();  
			}
		}
		
		
		public function galleryDetails($value='')
		{
			$gallery = Gallery::where('id', $value)
			->with(['images' => function ($query) {
				$query->select('gallery_images.*', DB::raw('(SELECT COUNT(*) FROM gallery_comments WHERE gallery_comments.image_id = gallery_images.id) as comments_count'));
			}])
			->first();
			return view('backEnd.gallery.gallery_details',compact('gallery'));
		}
		
		public function downloadGallery($id)
		{
			$gallery = Gallery::find($id);
			$gallery_images = $gallery->images;
			
			$zip = new \ZipArchive();
			$zipFile = 'gallery-' . $gallery->id . '.zip';
			if ($zip->open(public_path($zipFile), \ZipArchive::CREATE)== TRUE) {
				foreach ($gallery_images as $image) {
					$imagePath = public_path(str_replace('public/', '', $image->images));
					$filename = basename($image->images);
					$zip->addFile($imagePath, $filename);
				}
				$zip->close();  
			}
			
			return response()->download(public_path($zipFile), $zipFile);
		}
		
		public function downloadGalleryAll()
		{
			$galleres = Gallery::get();
			$zip = new \ZipArchive();
			$zipFile = 'all-gallery-' . date('Y-m-d') . '.zip';
			if ($zip->open(public_path($zipFile), \ZipArchive::CREATE)== TRUE) {
				$zipFileGallery = 'gallery-' . $gallery->id . '.zip';
				$zip->addFile($imagePath, $filename);
				foreach($galleres as $gallery) {
					$gallery_images = $gallery->images;
					if ($zip->open(public_path($zipFileGallery), \ZipArchive::CREATE)== TRUE) {
						foreach ($gallery_images as $image) {
							$imagePath = public_path(str_replace('public/', '', $image->images));
							$filename = basename($image->images);
							$zip->addFile($imagePath, $filename);
						}
						$zip->close();  
					}
				}
			}
			
			return response()->download(public_path($zipFile), $zipFile);
			}
			
			public function comments($imageId,$galleryId)
			{
			
			$comments = GalleryComments::where('image_id', $imageId)
		->with(['replies.user', 'user'])->orderBy('id','DESC')
		->get();
		
        return $comments;
		}
		
		public function commentStore(Request $request)
		{
		
        $validator = Validator::make($request->all(), [
		'image_id' => 'required|integer',
		'gallery_id' => 'required|integer',
		'parent_id' => 'nullable|integer',
		'comment' => 'required|string|max:255'
		
        ]);
        if ($validator->fails()) {
		Toastr::error($validator->errors()->first(), 'Failed');
		return redirect()->back();
        }else{
		$comments               = new GalleryComments();
		$comments->gallery_id   = $request->gallery_id;
		$comments->image_id     = $request->image_id;
		$comments->comment      = $request->comment;
		$comments->user_id      = auth()->id();
		if ($request->has('parent_id')) {
		$comments->parent_id = $request->parent_id;
		}
		if ($comments->save()) {
		if ($request->has('parent_id')) {
		return true;
		}else{
		Toastr::success('Comment added successfully.', 'Success');
		return redirect()->back();
		}
		}else{
		Toastr::error('Operation Failed', 'Failed');
		return redirect()->back();  
		}
        }
		
		}
		
		public function uploadSingleImage(Request $request)
	    {
	        $request->validate([
	            'image' => 'required|max:2048',
	        ]);

	        $image = $request->file('image');
	        $fileName = str_replace('.', '', microtime(true)). ".". $image->getClientOriginalExtension();
	        $image->move('public/uploads/gallery/', $fileName);
	        $fileName = 'public/uploads/gallery/'. $fileName;
	        $galleryImage = new GalleryImages();
	        $galleryImage->gallery_id = $request->gallery_id;
	        $galleryImage->images = $fileName;

	        if ($galleryImage->save()) {
	            Toastr::success('Image added successfully.', 'Success');
	            return redirect()->back();
	        }else{
	            Toastr::error('Operation Failed', 'Failed');
	            return redirect()->back();  
	        }

	    }



		
		}
				