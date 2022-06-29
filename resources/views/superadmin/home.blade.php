@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.edit_home_page')}}
@endsection

@section('content')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.edit_home_page')}}</h1>
                    <change>
                        <div class="english">
                            {{__('Admin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('Admin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>

                @include('admin.include.alert')
                
                <div id="menu">
                    <ul class="lang text-right">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('Admin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('Admin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                <form id="frontPageForm" class="forms-sample" enctype="multipart/form-data" method="POST" action="{{route('superadmin.front_page.home.update')}}">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label><h3>{{__('Admin/backend.hero')}}</h3></label>
                        </div>

                        <input hidden id="heroincretment" name="heroincretment" value="{{$content && $content->heros && $content->heros->count() ? $content->heros->count() - 1 : 0}}">
                        @if ($content && $content->heros && count($content->heros))
                            @foreach ($content->heros as $hero)
                                <div id="hero_clone{{$loop->iteration - 1}}" class="hero-clone clone">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="background">{{__('Admin/backend.background')}}</label>
                                            <input name="background[]" type="file" onchange="$(this).hide()" class="form-control" accept="image/*">
                                            @if (!is_null($hero->background))
                                                <img src="{{$hero->background}}" class="img-fluid img-thumbnail" alt="Background Image">
                                            @endif
                                            @if ($errors->has('logo'))
                                                <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>{{__('Admin/backend.title')}}:</label>
                                            <div class="english">
                                                <textarea class="form-control ckeditor-input" name="title[]" placeholder="{{__('Admin/backend.title')}}">{!! $hero->title !!}</textarea>
                                            </div>
                                            <div class="arabic">
                                                <textarea class="form-control ckeditor-input" name="title_ar[]" placeholder="{{__('Admin/backend.title')}}">{!! $hero->title_ar !!}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>{{__('Admin/backend.text')}}:</label>
                                            <div class="english">
                                                <textarea class="form-control ckeditor-input" name="text[]" placeholder="{{__('Admin/backend.text')}}">{!! $hero->text !!}</textarea>
                                            </div>
                                            <div class="arabic">
                                                <textarea class="form-control ckeditor-input" name="text_ar[]" placeholder="{{__('Admin/backend.text')}}">{!! $hero->text_ar !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <button class="btn btn-primary fa fa-plus" type="button" onclick="addHomeHero($(this))"></button>
                                        </div>
                                        <div class="pull-right">
                                            <button class="btn btn-danger fa fa-minus" type="button" onclick="removeHomeHero($(this))"></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div id="hero_clone0" class="hero-clone clone">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="background">{{__('Admin/backend.background')}}</label>
                                        <input name="background[]" type="file" onchange="$(this).hide()" class="form-control" accept="image/*">
                                        @if ($errors->has('logo'))
                                            <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('Admin/backend.title')}}:</label>
                                        <div class="english">
                                            <textarea class="form-control ckeditor-input" name="title[]" placeholder="{{__('Admin/backend.title')}}"></textarea>
                                        </div>
                                        <div class="arabic">
                                            <textarea class="form-control ckeditor-input" name="title_ar[]" placeholder="{{__('Admin/backend.title')}}"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>{{__('Admin/backend.text')}}:</label>
                                        <div class="english">
                                            <textarea class="form-control ckeditor-input" name="text[]" placeholder="{{__('Admin/backend.text')}}"></textarea>
                                        </div>
                                        <div class="arabic">
                                            <textarea class="form-control ckeditor-input" name="text_ar[]" placeholder="{{__('Admin/backend.text')}}"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addHomeHero($(this))"></button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="removeHomeHero($(this))"></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label><h3>{{__('Admin/backend.school_promotion')}}</h3></label>
                        </div>

                        @foreach ($schools as $school)
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <input type="checkbox" onclick="toggleSchoolPromotion($(this))" data-id="{{ $school->id }}" {{ $content && $content->school_promotions && count($content->school_promotions) && in_array($school->id, $content->school_promotions) ? 'checked' : '' }}/>
                                    <input type="hidden" name="school_id[]" value="{{ $content && $content->school_promotions && count($content->school_promotions) && in_array($school->id, $content->school_promotions) ? $school->id : '' }}" />
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="english">
                                        <h5>{{ $school->name ? $school->name->name : '' }}</h5>
                                        {{ $school->city ? $school->city->name : '' }}, {{ $school->country ? $school->country->name : '' }}
                                    </div>
                                    <div class="arabic">
                                        <h5>{{ $school->name ? $school->name->name_ar : '' }}</h5>
                                        {{ $school->city ? $school->city->name_ar : ''}}, {{ $school->country ? $school->country->name_ar : '' }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <img src="{{ $school->logo }}" class="img-fluid img-thumbnail" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label><h3>{{__('Admin/backend.popular_country')}}</h3></label>
                        </div>

                        @php
                            $popular_country_ids = [];
                            $popular_country_logos = [];
                            if ($content && $content->popular_countries) {
                                foreach ($content->popular_countries as $content->popular_country) {
                                    $popular_country_ids[] = $content->popular_country->id;
                                    $popular_country_logos[] = $content->popular_country->logo;
                                }
                            }
                        @endphp

                        @foreach ($countries as $country)
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <input type="checkbox" onclick="toggleSchoolPromotion($(this))" data-id="{{ $country->id }}" {{ in_array($country->id, $popular_country_ids) ? 'checked' : '' }}/>
                                    <input type="hidden" name="country_id[]" value="{{ in_array($country->id, $popular_country_ids) ? $country->id : '' }}" />
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="english">
                                        {{ $country->name }}
                                    </div>
                                    <div class="arabic">
                                        {{ $country->name_ar }}
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <input name="country_logo[]" type="file" class="form-control" accept="image/*">
                                    @if ($popular_country_logos && array_search($country->id, $popular_country_ids) != -1)
                                        <img src="{{ $popular_country_logos[array_search($country->id, $popular_country_ids)] }}" class="img-fluid img-thumbnail" />
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection