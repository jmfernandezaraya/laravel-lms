@extends('frontend.layouts.app')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs" data-aos="fade-in">
    <div class="container">
        <h2>How To Apply</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
    </div>
</div>
<!-- End Breadcrumbs -->

<section class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <ul id="tabsJustified" class="nav nav-tabs nav-fill">
                <!-- <li class="nav-item"><a href="" data-target="#home1" data-toggle="tab" class="nav-link small text-uppercase">Home</a></li> -->
                <li class="nav-item"><a href="" data-target="#profile1" data-toggle="tab" class="nav-link small text-uppercase active">Apply Program</a></li>
                <li class="nav-item"><a href="" data-target="#messages1" data-toggle="tab" class="nav-link small text-uppercase">Apply Visa</a></li>
            </ul>
            <div id="tabsJustifiedContent" class="tab-content mt-2">
                <div id="profile1" class="tab-pane fade active show">
                    <h5>Apply Program</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu justo a est vehicula vulputate sit amet et quam. Pellentesque placerat, elit eu ullamcorper fermentum, sem ante blandit mauris, in tincidunt tellus massa vel ex.</p>
                </div>
                <div id="messages1" class="tab-pane fade">
                    <h5>Apply Visa</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu justo a est vehicula vulputate sit amet et quam. Pellentesque placerat, elit eu ullamcorper fermentum, sem ante blandit mauris, in tincidunt tellus massa vel ex.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection