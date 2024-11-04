@extends('website.parts.app')


@section('content')
    <!-- About Start -->
    <div class="container-xxl py-5 mt-100">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img style="height: 350px;width:350px;" class="img-fluid" src="{{ asset('logo.png') }}" alt="نظام رعاية النخيل">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-5 mb-4">نظام رعاية النخيل - تحسين الإنتاج ومراقبة النمو</h1>
                    <p class="mb-4">يهدف نظام رعاية النخيل إلى مساعدة المزارعين في إدارة عملية زراعة النخيل وتحسين إنتاج التمور. نقدم حلاً شاملاً يمكن المستخدم من متابعة مراحل نمو النخيل والتعامل مع المشاكل الصحية بشكل فعال.</p>
                    <p><i class="fa fa-check text-primary me-3"></i> تقارير دورية عن حالة النخيل</p>
                    <p><i class="fa fa-check text-primary me-3"></i> متابعة دقيقة للإنتاجية</p>
                    <p><i class="fa fa-check text-primary me-3"></i> تعزيز جودة المحصول وزيادة الربحية</p>
                    <a class="btn btn-primary rounded-pill py-3 px-5 mt-3" href="#">اقرأ المزيد</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- More About the System -->
    <div class="container-fluid bg-light py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h1 class="display-5 mb-3">كيف يعمل النظام؟</h1>
                <p>نظام رعاية النخيل هو أداة رقمية مبتكرة تهدف إلى مساعدة مزارعي النخيل على تحسين إنتاج التمور. من خلال توفير بيانات دقيقة عن حالة النخيل.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <h4 class="mb-3">التقارير الدورية</h4>
                        <p class="mb-4">يتم توفير تقارير شاملة حول صحة النخيل وتطور الإنتاجية بشكل دوري لتمكين المزارعين من اتخاذ قرارات فعالة.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <h4 class="mb-3">تحديد التلفيات</h4>
                        <p class="mb-4">يمكن للنظام تحديد التلفيات التي قد تصيب النخيل خلال مراحل النمو وإبلاغ المستخدم بها فوراً مع اقتراحات الحلول.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="bg-white text-center h-100 p-4 p-xl-5">
                        <h4 class="mb-3">تحسين الإنتاج</h4>
                        <p class="mb-4">من خلال متابعة البيانات بشكل دقيق يمكن للمزارعين تحسين جودة الإنتاج وزيادة حصيلة التمور.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
