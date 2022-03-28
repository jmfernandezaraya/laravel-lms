@extends('frontend.layouts.app')

@section('content')
<div class="breadcrumbs" data-aos="fade-in">
    <div class="container">
        <h2>Apply Now</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- ======= login Section ======= -->
<div class="container mt-5 mb-5">
    <form id="login-form">
        <div class="heading">Apply Now</div>
        <div class="left">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="First name">
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" placeholder="Last name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="phone" class="form-control" placeholder="**********">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Apply Now</button>
        </div>
    </form>
</div>
@endsection