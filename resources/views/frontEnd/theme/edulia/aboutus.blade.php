@extends(config('pagebuilder.site_layout'), ['edit' => false])
{{headerContent()}}
@php
    $gs = generalSetting();
@endphp
<!-- about area start -->
<div class="inner-header bg-styles" style="background-image: url({{asset('public/theme/edulia/images/hero-bg.jpg')}});">
  <div class="container">
    <div class="row">
      <div class="col-12"><div class="inner-title">من نحن</div></div>
    </div>
  </div>
</div>


<div class="section welcome-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 valign-center wow fadeInRight"><div class="welcome-img"><img src="{{asset('public/theme/edulia/images/welcome-img.jpg')}}" class="w-100" alt=""></div></div>
      <div class="col-lg-7 valign-center wow fadeInLeft">
        <div class="welcome-txt">
          <div class="heading"><span>مرحبا بكم</span></div>
          <div class="welcome-p">
            <p>مرحبا بكم في منصة مركز سارة النموذجي عالم متكامل لطفلك حيث التعلم باللعب منهجنا، نؤمن بفلسفة المنتسوري وأن ما تزرعيه في طفلك تحصدينه بالمستقبل، ونحن نساعدك في تكوين شخصية الطفل حيث أثبتت الدراسات، أن أفضل سن للتعلم هو السن المبكرة، حيث يستطيع طفلك أن يبدأ أول خطوات حياته التعليمية والأخلاقية</p>
          </div>
          <div class="row advantages-wrapper">
            <div class="col-sm-6">
              <div class="advantage-box">الملاذ الأمن لطفلك  بدون شك .وبكل فخر...</div>
            </div>
            <div class="col-sm-6">
              <div class="advantage-box">أفضل الخدمات التعليمية والترفيهية بأقل الأسعار</div>
            </div>
            <div class="col-sm-6">
              <div class="advantage-box">مقالات ومقاطع توعوية تخص التربية الحديثة</div>
            </div>
            <div class="col-sm-6">
              <div class="advantage-box">استعد لاكتشاف عالم رائع</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row about-us-row">
      <div class="col-lg-3 col-sm-6">
        <div class="about-us-box">
          <div class="about-us-title">رؤيتنا</div>
          <div class="about-us-p">
            <p>تقديم أجود الخدمات التعليمية بأفضل سعر</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-us-box">
          <div class="about-us-title">رسالتنا</div>
          <div class="about-us-p">
            <p>تحقيق احتياجات الطفل للتعلم باستخدام احدث الوسائل التعليمية. بطرق التعليم الحديثة. حيث يكون عونا لوالديه ودينه ووطنه</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-us-box">
          <div class="about-us-title">أهدافنا</div>
          <div class="about-us-p">
            <p>تحقيق مبتغى أولياء الأمور في تطلعاتهم نحو أبنائهم</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="about-us-box">
          <div class="about-us-title">مميزاتنا</div>
          <div class="about-us-p">
            <p>أفضل الخدمات التعليمية – بأفضل الأسعار التنافسية</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- about area end -->

 <x-teacher-list :column="pagesetting('teacher_area_column')" :count="pagesetting('teacher_count')"> </x-teacher-list>
 
 <div class="cta-section" style="background:#e9f2fa;">
  <div class="container">
    <div class="row">
      <div class="col-12 wow flipInX">
        <div class="cta">
          <div class="cta-img"><img src="{{asset('public/theme/edulia/images/cta-img.jpg')}}" class="w-100" alt=""></div>
          <div class="cta-txt">
            <div class="row">
              <div class="col-8">
                <div class="cta-title">المنصة الإلكترونية لمركز سارة النموذجي <br> تعدكم بأفضل سعر لأفضل خدمة <br> طفلك يستحق</div>
                <!-- <div class="mt-4 text-center"><a class="theme-btn wow pulse" href="#">انضم إلينا</a></div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="counters-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="counter-box">
          <h1><span class="counter with-plus">4</span></h1>
          <h3>أقسام</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="counter-box">
          <h1><span class="counter with-plus">20</span></h1>
          <h3>معلمة متخصصة</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="counter-box">
          <h1><span class="counter with-plus">421</span></h1>
          <h3>مشترك سابقين</h3>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="counter-box">
          <h1><span class="counter with-plus">92</span></h1>
          <h3>مشتركين حاليين</h3>
        </div>
      </div>
    </div>
  </div>
</div>

<x-testimonial :count="pagesetting('testionmonial_count')" :sorting="pagesetting('testionmonial_sorting')"> </x-testimonial>

{{footerContent()}}
