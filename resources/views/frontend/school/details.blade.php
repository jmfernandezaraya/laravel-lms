@extends('frontend.layouts.app')

@section('title')
    {{__('Frontend.school_details')}}
@endsection

@section('css')
    <style>
        iframe{
            width: 100% !important;
            height:100 !important;
        }

        .about-school {
            width: 100%;
        }

        .Facility.border-bottom {
            width: 100%;
        }

        .dynamic_starli {
            display: inline-block;
            color: #F0F0F0;
            text-shadow: 0 0 1px #666666;
            font-size: 30px;
            cursor: pointer;
        }

        .highlight,
        .selected {
            color: #F4B30A;
            text-shadow: 0 0 1px #F48F0A;
        }

        .w-100 {
            width: 100% !important;
            height: 270px;
        }

        #carouselExampleIndicators2 {
            width: 100%;
            height: 270px;
            background: #000;
        }

        #more {
            display: none;
        }

        button#myBtn {
            border: none;
            background: none;
            color: #97d0db;
        }

        .sub-cources {
            padding: 10px 6px;
            box-shadow: 0px 0px 2px 1px #ccc;
        }

        .sub-cources:hover {
            box-shadow: 0px 0px 4px 2px #97d0db;
        }

        th {
            border: 1px solid #dee2e6;
        }

        .city {
            font-size: 12px;
            font-weight: 400;
            color: #868686;
        }

        .estd {
            float: right;
        }

        i.fa.fa-star {
            color: #edc25a;
        }
        p {
            font-size: 14px;
        }
        #loader {
            display: none;
            position: fixed;
            left: 0px;
            top: 0px;
            background-size: cover;
            background: url('{{asset('assets/images/gif.gif')}}') 50% 50% no-repeat gray;
            width: 100%;
            height: 100%;
            z-index: 9999;
            opacity: .7;
        }

        .logo-right.custom {
            padding: 0px!important;
        }
        .logo-right img{
            max-width: 100%;
            height: auto;
            margin: auto;
            max-height: 100%;
            width: 100%;
            object-fit: contain;
        }
        ul.custom{
            padding-left: 0px!important;
        }
        .border-none{
            border:none!important;
        }
        p{
            word-break: break-word;
        }
        .slick-slide img{
            width: 100%;
            height: 70px;
            object-fit: contain;
        }
        .other-branches{
            margin: 30px 0px;
        }
        .other_branches_item .img{
            padding: 10px;
            border: 1px solid #f7f1f1;
            padding-top: 30px;
            margin-bottom: 12px;
            box-shadow: 0px 0px 4px #f7f7f7;
        }
        .other_branches_item img{
            width: 100%;
            height: auto;
            max-height: 100%;
            object-fit: contain;
        }
        .other_branches_item .details h4{
            font-size: 15px;
            font-weight: bold;
            color: #000;
        }
        .other_branches_item .details {
            font-size: 10px;
            font-weight: 600;
            padding: 5px 0px;
        }
        .w-60{
            width: 65%;
            text-align: right;
        }
        .w-60 p{
            font-size: 12px;
        }
        .w-40{
            width: 35%;
            color: gray;
        }
    </style>
@endsection

@section('after_header')
    <!-- slider -->
    <div class="container pt-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <div id="tabsJustifiedContent" class="tab-content">
                    <div id="profile1" class="tab-pane fade active show">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach((array)$school->multiple_photos as $photos)
                                    <li data-target="#carouselExampleIndicators"
                                        data-slide-to="{{$loop->iteration - 1}}" class="{{$loop->iteration - 1 == 0? 'active' : ''}}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach((array)$school->multiple_photos as $photos)
                                    <div class="carousel-item {{$loop->iteration == 1 ?  "active" : '' }}">
                                        <img class="d-block w-100" src="{{asset('storage/app/public/school_images/'. $photos)}}" alt="First slide">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div id="messages1" class="tab-pane fade">
                        <div class="row pb-2">
                            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach ((array)$school->school_video as $videos)
                                        <li data-target="#carouselExampleIndicators2"
                                            data-slide-to="{{$loop->iteration - 1}}" class="{{$loop->iteration - 1 == 0 ? 'active' : ''}}"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach ((array)$school->school_video as $videos)
                                        <div class="carousel-item {{$loop->iteration == 1 ? "active" : ""}}">
                                            {!!  $videos !!}
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <ul id="tabsJustified" class="nav nav-tabs nav-fill">
                    <li class="nav-item">
                        <a href="" data-target="#profile1" data-toggle="tab" class="nav-link small text-uppercase active">Photos</a>
                    </li>
                    <li class="nav-item">
                        <a href="" data-target="#messages1" data-toggle="tab" class="nav-link small text-uppercase">Video</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- slider_end -->
    <!-- ======= Hero Section ======= -->
@endsection

@section('content')
    <div class="courses">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-right mt-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="logo-right custom">
                                    <img src="{{$school->logo}}" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="school-name">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th class="border-none" scope="row">{{ucfirst($school->name)}}
                                                    - {{is_array($school->branch_name) ? implode(", ", $school->branch_name) : $school->branch_name}}<br><span class="city">{{$school->city}},</span><span
                                                      class="city">{{$school->country}}</span><br>
                                                    <ul class="custom">
                                                        @for($i = 1; $i <=5; $i ++)
                                                            <li data-toggle="modal" data-target="#myModal"
                                                              class="dynamic_starli" onclick="save_rating({{$i}})"
                                                                onmouseover="highlightStar(this);"
                                                                onClick="addRating(this);" id="rating{{$i}}">★
                                                            </li>
                                                        @endfor
                                                        ({{round($school->avgRating())}})
                                                    </ul>
                                                </th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">School Capacity</th>
                                                <td>{{$school->school_capacity}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Class Size</th>
                                                <td>{{$school->class_size}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Year is Established</th>
                                                <td>{{$school->opened}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="about-school border-bottom pt-0">
                                <h5 class="best">About the school</h5>
                                <p class="m-0">{!! $school->about !!}</p>
                            </div>

                            <div class="Facility border-bottom">
                                <h5 class="best">facilities</h5>
                                {!! $school->facilities !!}
                            </div>

                            <section class="customer-logos slider">
                                @if ($school->logos)
                                    @foreach($school->logos as $logoss)
                                        <div class="slide">
                                            <img src="{{ asset('storage/app/public/school_images/' . $logoss) }}">
                                        </div>
                                    @endforeach
                                @endif
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <div class="program-hd mt-3">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Programs</h5>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-3 col-form-label text-right pr-0">{{__('SuperAdmin/backend.study_mode')}}</label>
                            <div class="col-sm-9">
                                <select onchange="get_program($(this).val())" name="study_mode" class="form-control" id="study_mode">
                                    @foreach($study_modes as $study_mode)
                                        <option value="{{$study_mode->unique_id}}">{{$study_mode->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="program">
            </div>

            <div class="review-section border-bottom mt-3">
                <h5 class="best">Reviews</h5>
                <p class="m-0">100% Recommend</p>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <span>based on 5 reviews</span>
                <div class="row">
                    <div class="col-md-3">
                        <p>5 Stars</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>Quality of teaching</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>4 Stars</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">5</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>School facilities</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>3 Stars</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">4</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>Social activities</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>2 Stars</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">3
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>School location</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>1 Stars</p>
                    </div>
                    <div class="col-md-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">2</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p>School Location</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            <div class="teacher-review mt-3 border-bottom">
                <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i
                  class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i
                  class="fa fa-star" aria-hidden="true"></i><span class="best">"Lorem Ipsum is simply dummy text of the printing and typesetting industry."</span>
                <p class="city mb-0 mt-1">{{$school->city}}, {{$school->country}}</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy
                    text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry.</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book.</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <h6 class="best">MY RATINGS FOR THIS SCHOOL</h6>
                <div class="row">
                    <div class="col-md-3">
                        <p>Quality of teaching</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3">
                        <p>DURATION OF STUDY</p>
                    </div>
                    <div class="col-md-3">
                        <p>4 weeks</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>School facilities</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3">
                        <p>DATE OF STUDY</p>
                    </div>
                    <div class="col-md-3">
                        <p>3 Jun 2019 - 5 Jul 2019</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>Quality of teaching</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i
                          class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i
                          class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3">
                        <p>DURATION OF STUDY</p>
                    </div>
                    <div class="col-md-3">
                        <p>3 Jun 2019 - 5 Jul 2019</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <p>Social activities</p>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i
                          class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i
                          class="fa fa-star" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3">
                        <p>WOULD YOU RECOMMEND THIS SCHOOL?</p>
                    </div>
                    <div class="col-md-3">
                        <p>Yes</p>
                    </div>
                </div>
                <p>This is a verified review. This student has booked a course at this school through Language
                    International.</p>
            </div>

            <div class="row mt-4">
                <!--Google map-->
                <div id="map-container-google-2" class="z-depth-1-half map-container" style="height: 400px; width: 100%;">
                    @if(str_contains($school->address, "<iframe"))
                        {!! $school->address !!}
                    @else
                        <iframe src="{!! $school->address !!}" frameborder="0"  style="border:0; width: 100% !important; height: 400px;" allowfullscreen></iframe>
                    @endif
                </div>
                <!--Google Maps-->

                <!-- Other Branches -->
                <section class="slider customer-logos">
                    @foreach($school->getCityCountryState()->getCountry() as $countries)
                        <div class="other_branches_item slide" style="">
                            <div class="img">
                                <img src="{{$school->logo}}">
                            </div>
                            <div class="details">
                                <h4>{{$school->getBranchByCity($countries)}}</h4>
                                <div class="d-flex">
                                    <div class="w-40 float-left text-align-left">
                                        {{$countries}},{{$school->getCityByCountry($countries)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </section>
            </div>
        </div>
    </div>

    {{-- Rate Comment Modal --}}
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{route('rateSaved')}}">
                @csrf
                <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">{{ucfirst($school->name)}}</h4>
                        <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Comments</label>
                            <textarea class="form-control" name="comments" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var save_rating_url = "{{route('save_rating')}}";
        $(document).ready(function () {
            $('.customer-logos').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            });
        });

        function highlightStar(obj) {
            removeHighlight();
            $('li').each(function (index) {
                $(this).addClass('highlight');
                if (index == $("li").index(obj)) {
                    return false;
                }
            });
        }

        function removeHighlight() {
            $('li').removeClass('selected');
            $('li').removeClass('highlight');
        }

        function addRating(obj) {
            $('li').each(function (index) {
                $(this).addClass('selected');
                $('#rating').val((index + 1));
                if (index == $("li").index(obj)) {
                    return false;
                }
            });
        }

        $(document).ready(function () {
            var maximumvalue="{{round($school->avgRating())}}";
            for (var i = 0; i <= maximumvalue; i++) {
                $("#rating" + i).addClass('selected');
            }
        });

        function resetRating() {
            if ($("#rating").val()) {
                $('li').each(function (index) {
                    $(this).addClass('selected');
                    if ((index + 1) == $("#rating").val()) {
                        return false;
                    }
                });
            }
        }

        function save_rating(how_much) {
            $.post(save_rating_url, {
                _token: "{{csrf_token()}}",
                how_much: how_much,
                school_id: "{{$school->id}}"
            }, function (data) {
                if (data.failed) {
                    $("#close_modal").click();
                    setTimeout(function () {
                        alert(data.failed);
                    }, 2000);
                }
            });
        }

        function get_program(value) {
            var urlname="{{route('school.programs')}}";
            $.post(urlname, {study_mode: value, id: "{{$id}}", _token: "{{csrf_token()}}"}, function (data) {
                $(".program").html(data.data)
                $("#loader").hide()
            });
        }

        $(document).ready(function () {
            get_program($('#study_mode').val());
        });
    </script>
    <div id="loader"></div>
@endsection