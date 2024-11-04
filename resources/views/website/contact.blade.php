@extends('website.parts.app')


@section('content')
    <!-- Contact Start -->
    <div class="container-xxl py-6 mt-100">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <h1 class="display-5 mb-3">تواصل معنا</h1>
                <p>لديك أي استفسار؟ لا تتردد في التواصل معنا. فريقنا مستعد للإجابة على جميع أسئلتك وتقديم المساعدة.</p>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-lg-5 col-md-12 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-primary text-white d-flex flex-column justify-content-center h-100 p-5">
                        <h5 class="text-white">اتصل بنا</h5>
                        <p class="mb-5"><i class="fa fa-phone-alt me-3"></i>+966 123 456 789</p>
                        <h5 class="text-white">راسلنا</h5>
                        <p class="mb-5"><i class="fa fa-envelope me-3"></i>info@palmtreecare.com</p>
                        <h5 class="text-white">موقع المكتب</h5>
                        <p class="mb-5"><i class="fa fa-map-marker-alt me-3"></i>شارع 123، الجبيل، المملكة العربية السعودية</p>
                        <h5 class="text-white">تابعنا</h5>
                        <div class="d-flex pt-2">
                            <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
                    <p class="mb-4">يرجى ملء النموذج أدناه وسنقوم بالرد عليك في أقرب وقت ممكن.</p>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="اسمك">
                                    <label for="name">اسمك</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="بريدك الإلكتروني">
                                    <label for="email">بريدك الإلكتروني</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subject" placeholder="الموضوع">
                                    <label for="subject">الموضوع</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="اترك رسالتك هنا" id="message" style="height: 200px"></textarea>
                                    <label for="message">رسالتك</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary rounded-pill py-3 px-5" type="submit">إرسال الرسالة</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <!-- Google Map Start -->
    <div class="container-xxl mt-4 mb-4 px-0 wow fadeIn" data-wow-delay="0.1s" style="margin-bottom: -6px;">
        <iframe class="w-100" style="height: 450px;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d460499.0282986735!2d49.471618287475215!3d27.01151307137944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e352236d5ac7689%3A0x71c82bf8d3e2ffcd!2sJubail%2C%20Saudi%20Arabia!5e0!3m2!1sen!2ssa!4v1603794290143!5m2!1sen!2ssa"
                frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <!-- Google Map End -->

@endsection
