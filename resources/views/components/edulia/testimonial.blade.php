<div class="section testimonials">
			<div class="container">
				<div class="row"><div class="col-12"><div class="heading text-center wow pulse"><span>آراء عملائنا</span></div></div></div>
				<div class="row">
					<div class="col-md-12">
						<div id="testimonials-carousel" class="owl-carousel owl-theme wow fadeInRight">
						 @foreach ($testimonials as $testimonial)
							<div class="testi-box">
								<div class="testi-text">
									<p>{{ $testimonial->description }}</p>
								</div>
								<div class="testi-client">
									<div class="client-profile bg-styles" style="background-image: url({{ file_exists(@$testimonial->image) ? asset($testimonial->image) : asset('public/uploads/staff/demo/staff.jpg') }});"></div>
									<div class="client-name">{{ $testimonial->name }}, <span>{{ $testimonial->designation }}
                    {{ $testimonial->institution_name }}</span></div>
								</div>
							</div>
						@endforeach
						
						</div>
					</div>
				</div>
			</div>
		</div>
