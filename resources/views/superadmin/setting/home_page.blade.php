@extends('superadmin.layouts.app')

@section('title')
    {{__('SuperAdmin/backend.edit_home_page')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('SuperAdmin/backend.edit_home_page')}}</h1>
                    <change>
                        <div class="english">
                            {{__('SuperAdmin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('SuperAdmin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>
                
                <div id="menu">
                    <ul class="lang text-right">
                        <li class="{{app()->getLocale() == 'en' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('english', 'arabic')"><img class="pr-2" src="{{asset('public/frontend/assets/img/eng.png')}}" alt="logo">{{__('SuperAdmin/backend.english')}}</a>
                        </li>
                        <li class="{{app()->getLocale() == 'ar' ? 'current_page_item selected' : ''}}">
                            <a onclick="changeLanguage('arabic', 'english')"><img class="pr-2" src="{{asset('public/frontend/assets/img/ar.png')}}" alt="logo">{{__('SuperAdmin/backend.arabic')}}</a>
                        </li>
                    </ul>
                </div>

                @include('superadmin.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="frontPageForm" class="forms-sample" enctype="multipart/form-data" method="POST" action="{{route('superadmin.setting.home_page.update')}}">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label><h3>{{__('SuperAdmin/backend.hero')}}</h3></label>

                            <script>
                                window.addEventListener('load', function() {
                                    home_hero_clone = {{$setting_value && $setting_value['heros'] ? count($setting_value['heros']) - 1 : 0}};
                                }, false );
                            </script>
                            <input hidden id="home_hero_increment" name="heroincretment" value="{{$setting_value && $setting_value['heros'] ? count($setting_value['heros']) - 1 : 0}}">
                            @if ($setting_value && $setting_value['heros'] && count($setting_value['heros']))
                                @foreach ($setting_value['heros'] as $hero)
                                    <div id="home_hero_clone{{$loop->iteration - 1}}" class="home-hero-clone clone">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="background">{{__('SuperAdmin/backend.background')}}:</label>
                                                <input name="hero_background[]" type="file" class="form-control" accept="image/*">
                                                @if (!is_null($hero['background']))
                                                    <img src="{{ getStorageImages('setting', $hero['background']) }}" class="img-fluid img-thumbnail" alt="Background Image">
                                                @endif
                                                @if ($errors->has('logo'))
                                                    <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>{{__('SuperAdmin/backend.title')}}:</label>
                                                <div class="english">
                                                    <textarea class="form-control ckeditor-input" name="hero_title[]" id="hero_title{{$loop->iteration - 1}}" placeholder="{{__('SuperAdmin/backend.title')}}">{!! $hero['title'] !!}</textarea>
                                                </div>
                                                <div class="arabic">
                                                    <textarea class="form-control ckeditor-input" name="hero_title_ar[]" id="hero_title_ar{{$loop->iteration - 1}}" placeholder="{{__('SuperAdmin/backend.title')}}">{!! $hero['title_ar'] !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>{{__('SuperAdmin/backend.text')}}:</label>
                                                <div class="english">
                                                    <textarea class="form-control ckeditor-input" name="hero_text[]" id="hero_text{{$loop->iteration - 1}}" placeholder="{{__('SuperAdmin/backend.text')}}">{!! $hero['text'] !!}</textarea>
                                                </div>
                                                <div class="arabic">
                                                    <textarea class="form-control ckeditor-input" name="hero_text_ar[]" id="hero_text_ar{{$loop->iteration - 1}}" placeholder="{{__('SuperAdmin/backend.text')}}">{!! $hero['text_ar'] !!}</textarea>
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
                                <div id="home_hero_clone0" class="home-hero-clone clone">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="background">{{__('SuperAdmin/backend.background')}}</label>
                                            <input name="hero_background[]" type="file" class="form-control" accept="image/*">
                                            @if ($errors->has('logo'))
                                                <div class="alert alert-danger">{{$errors->first('logo')}}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>{{__('SuperAdmin/backend.title')}}:</label>
                                            <div class="english">
                                                <textarea class="form-control ckeditor-input" name="hero_title[]" id="hero_title0" placeholder="{{__('SuperAdmin/backend.title')}}"></textarea>
                                            </div>
                                            <div class="arabic">
                                                <textarea class="form-control ckeditor-input" name="hero_title_ar[]" id="hero_title_ar0" placeholder="{{__('SuperAdmin/backend.title')}}"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{__('SuperAdmin/backend.text')}}:</label>
                                            <div class="english">
                                                <textarea class="form-control ckeditor-input" name="hero_text[]" id="hero_text0" placeholder="{{__('SuperAdmin/backend.text')}}"></textarea>
                                            </div>
                                            <div class="arabic">
                                                <textarea class="form-control ckeditor-input" name="hero_text_ar[]" id="hero_text_ar0" placeholder="{{__('SuperAdmin/backend.text')}}"></textarea>
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
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label><h3>{{__('SuperAdmin/backend.school_promotion')}}</h3></label>

                            <select name="school_id[]" id="school_id_choose" multiple="multiple" class="3col active">
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" {{in_array($school->id, isset($setting_value['school_promotions']) ? $setting_value['school_promotions'] : []) ? 'selected' : ''}}>
                                        {{ app()->getLocale() == 'en' ? ($school->name ? $school->name->name : '-') . ' / ' . ($school->city ? $school->city->name : '-') . ' / ' . ($school->country ? $school->country->name : '-') : ($school->name ? $school->name->name_ar : '-') . ' / ' . ($school->city ? $school->city->name_ar : '-') . ' / ' . ($school->country ? $school->country->name_ar : '-') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label><h3>{{__('SuperAdmin/backend.popular_country')}}</h3></label>
                            @php
                                $popular_country_ids = [];
                                $popular_country_logos = [];
                                if ($setting_value && $setting_value['popular_countries']) {
                                    foreach ($setting_value['popular_countries'] as $popular_country) {
                                        if ($popular_country['id']) {
                                            $popular_country_ids[] = $popular_country['id'];
                                            $popular_country_logos[] = $popular_country['logo'];
                                        }
                                    }
                                }
                            @endphp

                            @foreach ($countries as $country)
                                <div class="row">
                                    <div class="form-group col-md-1">
                                        <input type="checkbox" onclick="togglePopularCountry($(this))" data-id="{{ $country->id }}" {{ in_array($country->id, $popular_country_ids) ? 'checked' : '' }}/>
                                        <input type="hidden" name="country_id[]" value="{{ in_array($country->id, $popular_country_ids) ? $country->id : '' }}" />
                                    </div>
                                    <div class="form-group col-md-7">
                                        <div class="english">
                                            {{ $country->name }}
                                        </div>
                                        <div class="arabic">
                                            {{ $country->name_ar }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input name="country_logo[]" type="file" class="form-control" accept="image/*">
                                        @if ($popular_country_logos && in_array($country->id, $popular_country_ids))
                                            <img src="{{ getStorageImages('setting', $popular_country_logos[array_search($country->id, $popular_country_ids)]) }}" class="img-fluid img-thumbnail" />
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="button" onclick="submitForm($(this).parents().find('#frontPageForm'))" class="btn btn-gradient-primary mr-2">{{__('SuperAdmin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('SuperAdmin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection