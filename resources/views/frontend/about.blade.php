@extends('frontend.layouts.app')

@section('content')
<div class="breadcrumbs" data-aos="fade-in">
    <div class="container">
        <h2>About Us</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- ======= About Section ======= -->
<section id="about" class="about">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                <img src="{{asset('public/frontend/assets/img/about.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                <h3>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h3>
                <p class="font-italic">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
                <ul>
                    <li><i class="icofont-check-circled"></i> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                    <li><i class="icofont-check-circled"></i> Lorem Ipsum is simply dummy text of the printing .</li>
                    <li><i class="icofont-check-circled"></i> Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                </ul>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- End About Section -->
@endsection