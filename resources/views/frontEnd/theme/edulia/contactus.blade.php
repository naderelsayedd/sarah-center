@extends(config('pagebuilder.site_layout'), ['edit' => false])
{{headerContent()}}
@php
    $gs = generalSetting();
@endphp
<!-- about area start -->
<div class="inner-header bg-styles" style="background-image: url({{asset('public/theme/edulia/images/hero-bg.jpg')}});">
  <div class="container">
    <div class="row">
      <div class="col-12"><div class="inner-title">اتصل بنا</div></div>
    </div>
  </div>
</div>


<div class="section latest-works-section grey-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="new-contact-box mt-3">
          <h2>اتصل بنا</h2>
          <p>شكرا لكم على تحمسكم في التواصل معنا، نحن أيضا متحمسون لتواصلكم معنا</p>
          <div class="contact-details">
            <ul>
              <li>
                <div class="contact-icon"><i class="fa-solid fa-mobile"></i></div>
                <div class="contact-detail-txt">
                  <p>اتصل بنا للاستفسار</p>
                  <h5><a href="tel:0557444683"><bdi>0557444683</bdi></a></h5>
                  <p>للشكاوى والاقتراحات</p>
                  <h5><a href="tel:0556902250"><bdi>0556902250</bdi></a></h5>
                </div>
              </li>
              <li>
                <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                <div class="contact-detail-txt">
                  <p>أو ارسل لنا رسالة</p>
                  <h5><a href="mailto:Sarah_Baby_Center@hotmail.com">Sarah_Baby_Center@hotmail.com</a></h5>
                </div>
              </li>
              <li>
                <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div class="contact-detail-txt">
                  <p>أو يمكنكم زيارة مقر المركز</p>
                  <h5>الجامعة، نجران 66554, المملكة العربية السعودية</h5>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="new-contact-box mt-3">
          <form action="request-job" class="row bb-form">
            <div class="col-sm-6 mb-3">
              <input type="text" class="form-control" placeholder="الاسم">
            </div>
            <div class="col-sm-6 mb-3">
              <input type="email" class="form-control" placeholder="البريد الإلكتروني">
            </div>
            <div class="col-12 mb-3">
              <input type="text" class="form-control" placeholder="رقم الهاتف">
            </div>
            <div class="col-sm-12 mb-3">
              <textarea rows="6" class="form-control" placeholder="الرسالة"></textarea>
            </div>
            <div class="col-sm-12 mb-3">
              <button class="my-btn">إرسال</button>
            </div>
          </form>
  
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12 mt-4">
        <div class="map-wraper"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3802.408982869939!2d44.484611375943345!3d17.63077829574642!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15ff2fee9f13dae7%3A0x84a5ea35976d2016!2z2YXYsdmD2LIg2LPYp9ix2Kkg2KfZhNmG2YXZiNiw2KzZiiDZhNi22YrYp9mB2Kkg2KfZhNii2LfZgdin2YQg2KfZhNij2YfZhNmK2Kk!5e0!3m2!1sen!2seg!4v1724664214206!5m2!1sen!2seg" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></iframe></div>
      </div>
    </div>
  </div>
</div>   
{{footerContent()}}
