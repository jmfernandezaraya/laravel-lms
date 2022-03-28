@extends('frontend.layouts.app')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs" data-aos="fade-in">
    <div class="container">
        <h2> @lang('Frontend.blog_details') </h2>
        <p>Est dolorum ut non facere possimus quibusdam eligendi voluptatem. Quia id aut similique quia voluptas sit quaerat debitis. Rerum omnis ipsam aperiam consequatur laboriosam nemo harum praesentium. </p>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- ======= Cource Details Section ======= -->
<section id="course-details" class="course-details">
    <div class="container" data-aos="fade-up">
        <div class="row">
            <div class="col-lg-12">
                <h3>{{$blog->{'title_'. get_language() } }}</h3>
                <p>
                    {!! $blog->{'description_'. get_language() } !!}
                </p>
            </div>
        </div>
    </div>
</section>
<!-- End Cource Details Section -->
@endsection