@php
$generalSetting = generalSetting();
@endphp
<style>
	.footer-item{display:none;}
</style>
<div class="mega-footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-9">
				<div class="footer-box footer-logo">
					@if(pagesetting('footer_menu_image'))
					<img src="{{asset('public/theme/edulia/images/footer-logo.png')}}" alt="">
					@endif 
					<div class="footer-summ mt-2">
						<p>{!! pagesetting('footer-right-content-text') !!}</p>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-3">
				<div class="footer-box footer-nav">
					<div class="footer-heading">روابط هامة</div>
					<ul>
						<li><a href="/home"><i class="fa-solid fa-angle-left"></i> الرئيسية</a></li>
						<li><a href="/aboutus"><i class="fa-solid fa-angle-left"></i> من نحن</a></li>
						<li><a href="/photogallery"><i class="fa-solid fa-angle-left"></i> الصور</a></li>
						<li><a href="/videogallery"><i class="fa-solid fa-angle-left"></i> الفيديوهات</a></li>
						<li><a href="/contactus"><i class="fa-solid fa-angle-left"></i> اتصل بنا</a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="footer-box footer-contact">
					<div class="footer-heading">اتصل بنا</div>
					<div class="contact-field"><i class="fa-solid fa-phone"></i> <bdi>0557444683</bdi></div>
					<div class="contact-field"><i class="fa-brands fa-whatsapp"></i> <a href="https://wa.me/+9660557444683"><bdi>مراسلة واتساب</bdi></a> | <i class="fa-solid fa-phone"></i> <a href="tel:0557444683"><bdi>اتصال</bdi></a></div>
					<div class="contact-field"><i class="fa-solid fa-envelope"></i> info@saracenter.com</div>
					<div class="contact-field"><i class="fa-solid fa-location-dot"></i> الجامعة، نجران 66554, المملكة العربية السعودية</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="footer-box footer-newsletter">
					<div class="footer-heading">النشرة البريدية</div>
					<div class="newsletter-form">
						<input type="text" class="form-control mt-2" placeholder="الاسم">
						<input type="email" class="form-control mt-2" placeholder="البريد الالكتروني">
						<button class="my-btn mt-2">اشترك</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
