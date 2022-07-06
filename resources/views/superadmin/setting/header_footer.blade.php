@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.edit_header_footer')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.edit_header_footer')}}</h1>
                    <change>
                        <div class="english">
                            {{__('Admin/backend.in_english')}}
                        </div>
                        <div class="arabic">
                            {{__('Admin/backend.in_arabic')}}
                        </div>
                    </change>
                </div>
                
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

                @include('common.include.alert')
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="headerFooterForm" class="forms-sample" enctype="multipart/form-data" method="POST" action="{{route('superadmin.setting.header_footer.update')}}">
                    {{csrf_field()}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('Admin/backend.header')}}</h3></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label><h4>{{__('Admin/backend.logo')}}</h4></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input name="header_logo" type="file" class="form-control" accept="image/*">
                                    @if (isset($setting_value['header']['logo']) && $setting_value['header']['logo'])
                                        <img src="{{ getStorageImages('setting', $setting_value['header']['logo']) }}" class="img-fluid img-thumbnail" alt="Background Image">
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label><h4>{{__('Admin/backend.menu')}}</h4></label>
                                </div>
                            </div>

                            <script>
                                window.addEventListener('load', function() {
                                    header_menu_clone = {{isset($setting_value['header']['menu']) && count($setting_value['header']['menu']) ? count($setting_value['header']['menu']) - 1 : 0}};
                                }, false );
                            </script>

                            <input hidden id="header_menu_increment" name="headermenuincrement" value="{{isset($setting_value['header']['menu']) && count($setting_value['header']['menu']) ? count($setting_value['header']['menu']) - 1 : 0}}">
                            @if (isset($setting_value['header']['menu']) && count($setting_value['header']['menu']))
                                @foreach ($setting_value['header']['menu'] as $header_menu)
                                    <div id="header_menu_clone{{$loop->iteration - 1}}" class="header-menu-clone clone">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>{{__('Admin/backend.item')}}:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <select class="form-control" name="header_menu_type[]" onchange="changeHeaderFooterMenuType($(this))">
                                                    <option value="page" {{$header_menu['type'] == 'page' ? 'selected' : ''}}>{{__('Admin/backend.page')}}</option>
                                                    <option value="label" {{$header_menu['type'] == 'label' ? 'selected' : ''}}>{{__('Admin/backend.label')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-8 menu-page-label">
                                                <div class="menu-page" style="display: {{$header_menu['type'] == 'page' ? 'block' : 'none'}}">
                                                    <select class="form-control" name="header_menu_page[]">
                                                        <option value="">{{__('Admin/backend.select_option')}}</option>
                                                        @foreach ($front_pages as $front_page)
                                                            <option value="{{ $front_page->id }}" {{$front_page->id == $header_menu['page'] ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="menu-label" style="display: {{$header_menu['type'] == 'label' ? 'block' : 'none'}}">
                                                    <div class="english">
                                                        <input type="text" class="form-control" name="header_menu_label[]" value="{{ $header_menu['label'] }}" />
                                                    </div>
                                                    <div class="arabic">
                                                        <input type="text" class="form-control" name="header_menu_label_ar[]" value="{{ $header_menu['label_ar'] }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>{{__('Admin/backend.sub_menu')}}:</label>
                                            </div>
                                        </div>

                                        <input hidden id="header_menu_sub_increment{{$loop->iteration - 1}}" name="headermenusubincrement[]" value="{{$header_menu['sub_menu'] && count($header_menu['sub_menu']) ? count($header_menu['sub_menu']) - 1 : 0}}">
                                        @forelse ($header_menu['sub_menu'] as $header_menu_sub)
                                            <div id="header_menu{{$loop->parent->iteration - 1}}_sub_clone{{$loop->iteration - 1}}" class="header-menu-sub-clone clone">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <select class="form-control" name="header_menu_sub_type[{{$loop->parent->iteration - 1}}][]" onchange="changeHeaderFooterMenuType($(this))">
                                                            <option value="page" {{$header_menu_sub['type'] == 'page' ? 'selected' : ''}}>{{__('Admin/backend.page')}}</option>
                                                            <option value="label" {{$header_menu_sub['type'] == 'label' ? 'selected' : ''}}>{{__('Admin/backend.label')}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 menu-sub-page-label">
                                                        <div class="menu-page" style="display: {{$header_menu_sub['type'] == 'page' ? 'block' : 'none'}}">
                                                            <select class="form-control" name="header_menu_sub_page[{{$loop->parent->iteration - 1}}][]">
                                                                <option value="">{{__('Admin/backend.select_option')}}</option>
                                                                @foreach ($front_pages as $front_page)
                                                                    <option value="{{ $front_page->id }}" {{$front_page->id == $header_menu_sub['page'] ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="menu-label" style="display: {{$header_menu_sub['type'] == 'page' ? 'block' : 'none'}}">
                                                            <div class="english">
                                                                <input type="text" class="form-control" name="header_menu_sub_label[{{$loop->parent->iteration - 1}}][]" value="{{ $header_menu_sub['label'] }}" />
                                                            </div>
                                                            <div class="arabic">
                                                                <input type="text" class="form-control" name="header_menu_sub_label_ar[{{$loop->parent->iteration - 1}}][]" value="{{ $header_menu_sub['label_ar'] }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-2 px-1">
                                                        <i class="fa fa-plus-circle" aria-hidden="true" onclick="addHeaderMenuSubForm($(this))"></i>
                                                        <i class="fa fa-minus" aria-hidden="true" onclick="deleteHeaderMenuSubForm($(this))"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div id="header_menu{{$loop->iteration - 1}}_sub_clone0" class="header-menu-sub-clone clone">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <select class="form-control" name="header_menu_sub_type[{{$loop->iteration - 1}}][]" onchange="changeHeaderFooterMenuType($(this))">
                                                            <option value="page" selected>{{__('Admin/backend.page')}}</option>
                                                            <option value="label">{{__('Admin/backend.label')}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 menu-sub-page-label">
                                                        <div class="menu-page" style="display: block">
                                                            <select class="form-control" name="header_menu_sub_page[{{$loop->iteration - 1}}][]">
                                                                <option value="">{{__('Admin/backend.select_option')}}</option>
                                                                @foreach ($front_pages as $front_page)
                                                                    <option value="{{ $front_page->id }}">{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="menu-label" style="display: none">
                                                            <div class="english">
                                                                <input type="text" class="form-control" name="header_menu_sub_label[{{$loop->iteration - 1}}][]" value="" />
                                                            </div>
                                                            <div class="arabic">
                                                                <input type="text" class="form-control" name="header_menu_sub_label_ar[{{$loop->iteration - 1}}][]" value="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-2 px-1">
                                                        <i class="fa fa-plus-circle" aria-hidden="true" onclick="addHeaderMenuSubForm($(this))"></i>
                                                        <i class="fa fa-minus" aria-hidden="true" onclick="deleteHeaderMenuSubForm($(this))"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                                
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <button class="btn btn-primary fa fa-plus" type="button" onclick="addHeaderMenuForm($(this))"></button>
                                            </div>
                                        <div class="form-group col-md-6">
                                                <button class="btn btn-danger fa fa-minus" type="button" onclick="removeHeaderMenuForm($(this))"></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div id="header_menu_clone0" class="header-menu-clone clone">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>{{__('Admin/backend.item')}}:</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <select class="form-control" name="header_menu_type[]" onchange="changeHeaderFooterMenuType($(this))">
                                                <option value="page" selected>{{__('Admin/backend.page')}}</option>
                                                <option value="label">{{__('Admin/backend.label')}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-8 menu-page-label">
                                            <div class="menu-page" style="display: block">
                                                <select class="form-control" name="header_menu_page[]">
                                                    <option value="">{{__('Admin/backend.select_option')}}</option>
                                                    @foreach ($front_pages as $front_page)
                                                        <option value="{{ $front_page->id }}">{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="menu-label" style="display: none">
                                                <div class="english">
                                                    <input type="text" class="form-control" name="header_menu_label[]" value="" />
                                                </div>
                                                <div class="arabic">
                                                    <input type="text" class="form-control" name="header_menu_label_ar[]" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>{{__('Admin/backend.sub_menu')}}:</label>
                                        </div>
                                    </div>

                                    <input hidden id="header_menu_sub_increment0" name="headermenusubincrement[]" value="0">
                                    <div id="header_menu0_sub_clone0" class="header-menu-sub-clone clone">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <select class="form-control" name="header_menu_sub_type[0][]" onchange="changeHeaderFooterMenuType($(this))">
                                                    <option value="page" selected>{{__('Admin/backend.page')}}</option>
                                                    <option value="label">{{__('Admin/backend.label')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 menu-sub-page-label">
                                                <div class="menu-page" style="display: block">
                                                    <select class="form-control" name="header_menu_sub_page[0][]">
                                                        <option value="">{{__('Admin/backend.select_option')}}</option>
                                                        @foreach ($front_pages as $front_page)
                                                            <option value="{{ $front_page->id }}">{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="menu-label" style="display: none">
                                                    <div class="english">
                                                        <input type="text" class="form-control" name="header_menu_sub_label[0][]" value="" />
                                                    </div>
                                                    <div class="arabic">
                                                        <input type="text" class="form-control" name="header_menu_sub_label_ar[0][]" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2 px-1">
                                                <i class="fa fa-plus-circle" aria-hidden="true" onclick="addHeaderMenuSubForm($(this))"></i>
                                                <i class="fa fa-minus" aria-hidden="true" onclick="deleteHeaderMenuSubForm($(this))"></i>
                                            </div>
                                        </div>
                                    </div>
                                            
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <button class="btn btn-primary fa fa-plus" type="button" onclick="addHeaderMenuForm($(this))"></button>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button class="btn btn-danger fa fa-minus" type="button" onclick="removeHeaderMenuForm($(this))"></button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label><h3>{{__('Admin/backend.footer')}}</h3></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label><h4>{{__('Admin/backend.logo')}}</h4></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input name="footer_logo" type="file" class="form-control" accept="image/*">
                                    @if (isset($setting_value['footer']['logo']) && $setting_value['footer']['logo'])
                                        <img src="{{ getStorageImages('setting', $setting_value['footer']['logo']) }}" class="img-fluid img-thumbnail" alt="Background Image">
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label><h4>{{__('Admin/backend.description')}}</h4></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="english">
                                        <textarea class="form-control ckeditor-input" name="footer_description" id="footer_description" placeholder="{{__('Admin/backend.description')}}">{!! isset($setting_value['footer']['description']) ? $setting_value['footer']['description'] : '' !!}</textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control ckeditor-input" name="footer_description_ar" id="hero_description_ar" placeholder="{{__('Admin/backend.description')}}">{!! isset($setting_value['footer']['description_ar']) ? $setting_value['footer']['description_ar'] : '' !!}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label><h4>{{__('Admin/backend.copyright')}}</h4></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="english">
                                        <textarea class="form-control ckeditor-input" name="footer_copyright" id="footer_copyright" placeholder="{{__('Admin/backend.copyright')}}">{!! isset($setting_value['footer']['copyright']) ? $setting_value['footer']['copyright'] : '' !!}</textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control ckeditor-input" name="footer_copyright_ar" id="footer_copyright_ar" placeholder="{{__('Admin/backend.copyright')}}">{!! isset($setting_value['footer']['copyright_ar']) ? $setting_value['footer']['copyright_ar'] : '' !!}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label><h4>{{__('Admin/backend.credits')}}</h4></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="english">
                                        <textarea class="form-control ckeditor-input" name="footer_credits" id="footer_credits" placeholder="{{__('Admin/backend.credits')}}">{!! isset($setting_value['footer']['credits']) ? $setting_value['footer']['credits'] : '' !!}</textarea>
                                    </div>
                                    <div class="arabic">
                                        <textarea class="form-control ckeditor-input" name="footer_credits_ar" id="footer_credits_ar" placeholder="{{__('Admin/backend.credits')}}">{!! isset($setting_value['footer']['credits_ar']) ? $setting_value['footer']['credits_ar'] : '' !!}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label><h4>{{__('Admin/backend.menus')}}</h4></label>
                                </div>
                            </div>

                            <script>
                                window.addEventListener('load', function() {
                                    footer_menu_section_clone = {{isset($setting_value['footer']['menu']) && count($setting_value['footer']['menu']) ? count($setting_value['footer']['menu']) - 1 : 0}};
                                }, false );
                            </script>
                            
                            <input hidden id="footer_menu_section_increment" name="footermenusectionincrement" value="{{isset($setting_value['footer']['menu']) && count($setting_value['footer']['menu']) ? count($setting_value['footer']['menu']) - 1 : 0}}">
                            @if (isset($setting_value['footer']['menu']) && count($setting_value['footer']['menu']))
                                @foreach ($setting_value['footer']['menu'] as $footer_menu_section)
                                    <div id="footer_menu_section_clone{{$loop->iteration - 1}}" class="footer-menu-section-clone clone border border-dark p-2 mb-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><h5>{{__('Admin/backend.title')}}</h5></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <div class="english">
                                                    <textarea class="form-control ckeditor-input" name="footer_menu_title[]" id="footer_menu_title{{$loop->iteration - 1}}" placeholder="{{__('Admin/backend.title')}}">{!! isset($footer_menu_section['title']) ? $footer_menu_section['title'] : '' !!}</textarea>
                                                </div>
                                                <div class="arabic">
                                                    <textarea class="form-control ckeditor-input" name="footer_menu_title_ar[]" id="footer_menu_title_ar{{$loop->iteration - 1}}" placeholder="{{__('Admin/backend.title')}}">{!! isset($footer_menu_section['title_ar']) ? $footer_menu_section['title_ar'] : '' !!}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><h5>{{__('Admin/backend.menu')}}</h5></label>
                                            </div>
                                        </div>
                                        <input hidden id="footer_menu_increment{{$loop->iteration - 1}}" name="footermenuincrement[]" value="{{isset($footer_menu_section['menu']) && count($footer_menu_section['menu']) ? count($footer_menu_section['menu']) - 1 : 0}}">
                                        @if (isset($footer_menu_section['menu']))
                                            @foreach ($footer_menu_section['menu'] as $footer_menu)
                                                <div id="footer_menu{{$loop->parent->iteration - 1}}_clone{{$loop->iteration - 1}}" class="footer-menu-clone clone border border-dark p-2 mb-2">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>{{__('Admin/backend.item')}}:</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <select class="form-control" name="footer_menu_type[{{$loop->parent->iteration - 1}}][]" onchange="changeHeaderFooterMenuType($(this))">
                                                                <option value="page" {{$footer_menu['type'] == 'page' ? 'selected' : ''}}>{{__('Admin/backend.page')}}</option>
                                                                <option value="label" {{$footer_menu['type'] == 'label' ? 'selected' : ''}}>{{__('Admin/backend.label')}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-8 menu-page-label">
                                                            <div class="menu-page" style="display: {{$footer_menu['type'] == 'page' ? 'block' : 'none'}}">
                                                                <select class="form-control" name="footer_menu_page[{{$loop->parent->iteration - 1}}][]">
                                                                    <option value="">{{__('Admin/backend.select_option')}}</option>
                                                                    @foreach ($front_pages as $front_page)
                                                                        <option value="{{ $front_page->id }}" {{$front_page->id == $footer_menu['page'] ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="menu-label" style="display: {{$footer_menu['type'] == 'label' ? 'block' : 'none'}}">
                                                                <div class="english">
                                                                    <input type="text" class="form-control" name="footer_menu_label[{{$loop->parent->iteration - 1}}][]" value="{{ $footer_menu['label'] }}" />
                                                                </div>
                                                                <div class="arabic">
                                                                    <input type="text" class="form-control" name="footer_menu_label_ar[{{$loop->parent->iteration - 1}}][]" value="{{ $footer_menu['label_ar'] }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>{{__('Admin/backend.sub_menu')}}:</label>
                                                        </div>
                                                    </div>

                                                    <input hidden id="footer_menu{{$loop->parent->iteration - 1}}_sub_increment{{$loop->iteration - 1}}" name="footermenusubincrement[{{$loop->parent->iteration - 1}}][]" value="{{$footer_menu['sub_menu'] && count($footer_menu['sub_menu']) ? count($footer_menu['sub_menu']) - 1 : 0}}">
                                                    @forelse ($footer_menu['sub_menu'] as $footer_menu_sub)
                                                        <div id="footer_menu{{$loop->parent->parent->iteration - 1}}_sub{{$loop->parent->iteration - 1}}_clone{{$loop->iteration - 1}}" class="footer-menu-sub-clone clone">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <select class="form-control" name="footer_menu_sub_type[{{$loop->parent->parent->iteration - 1}}][{{$loop->parent->iteration - 1}}][]" onchange="changeHeaderFooterMenuType($(this))">
                                                                        <option value="page" {{$footer_menu_sub['type'] == 'page' ? 'selected' : ''}}>{{__('Admin/backend.page')}}</option>
                                                                        <option value="label" {{$footer_menu_sub['type'] == 'label' ? 'selected' : ''}}>{{__('Admin/backend.label')}}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6 menu-sub-page-label">
                                                                    <div class="menu-page" style="display: {{$footer_menu['type'] == 'page' ? 'block' : 'none'}}">
                                                                        <select class="form-control" name="footer_menu_sub_page[{{$loop->parent->parent->iteration - 1}}][{{$loop->parent->iteration - 1}}][]">
                                                                            <option value="">{{__('Admin/backend.select_option')}}</option>
                                                                            @foreach ($front_pages as $front_page)
                                                                                <option value="{{ $front_page->id }}" {{$front_page->id == $footer_menu_sub['page'] ? 'selected' : ''}}>{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="menu-label" style="display: {{$footer_menu_sub['type'] == 'label' ? 'block' : 'none'}}">
                                                                        <div class="english">
                                                                            <input type="text" class="form-control" name="footer_menu_sub_label[{{$loop->parent->parent->iteration - 1}}][{{$loop->parent->iteration - 1}}][]" value="{{ $footer_menu_sub['label'] }}" />
                                                                        </div>
                                                                        <div class="arabic">
                                                                            <input type="text" class="form-control" name="footer_menu_sub_label_ar[{{$loop->parent->parent->iteration - 1}}][{{$loop->parent->iteration - 1}}][]" value="{{ $footer_menu_sub['label_ar'] }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-2 px-1">
                                                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addFooterMenuSubForm($(this))"></i>
                                                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteFooterMenuSubForm($(this))"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div id="footer_menu{{$loop->parent->iteration - 1}}_sub{{$loop->iteration - 1}}_clone0" class="footer-menu-sub-clone clone">
                                                            <div class="row">
                                                                <div class="form-group col-md-4">
                                                                    <select class="form-control" name="footer_menu_sub_type[{{$loop->parent->iteration - 1}}][{{$loop->iteration - 1}}][]" onchange="changeHeaderFooterMenuType($(this))">
                                                                        <option value="page" selected>{{__('Admin/backend.page')}}</option>
                                                                        <option value="label">{{__('Admin/backend.label')}}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6 menu-sub-page-label">
                                                                    <div class="menu-page" style="display: block">
                                                                        <select class="form-control" name="footer_menu_sub_page[{{$loop->parent->iteration - 1}}][{{$loop->iteration - 1}}][]">
                                                                            <option value="">{{__('Admin/backend.select_option')}}</option>
                                                                            @foreach ($front_pages as $front_page)
                                                                                <option value="{{ $front_page->id }}">{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="menu-label" style="display: none">
                                                                        <div class="english">
                                                                            <input type="text" class="form-control" name="footer_menu_sub_label[{{$loop->parent->iteration - 1}}][{{$loop->iteration - 1}}][]" value="" />
                                                                        </div>
                                                                        <div class="arabic">
                                                                            <input type="text" class="form-control" name="footer_menu_sub_label_ar[{{$loop->parent->iteration - 1}}][{{$loop->iteration - 1}}][]" value="" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-2 px-1">
                                                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addFooterMenuSubForm($(this))"></i>
                                                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteFooterMenuSubForm($(this))"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                    
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <button class="btn btn-primary fa fa-plus" type="button" onclick="addFooterMenuForm($(this))"></button>
                                                        </div>
                                                    <div class="form-group col-md-6">
                                                            <button class="btn btn-danger fa fa-minus" type="button" onclick="removeFooterMenuForm($(this))"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div id="footer_menu{{$loop->iteration - 1}}_clone0" class="footer-menu-clone clone border border-dark p-2 mb-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>{{__('Admin/backend.item')}}:</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <select class="form-control" name="footer_menu_type[{{$loop->iteration - 1}}][]" onchange="changeHeaderFooterMenuType($(this))">
                                                            <option value="page" selected>{{__('Admin/backend.page')}}</option>
                                                            <option value="label">{{__('Admin/backend.label')}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-8 menu-page-label">
                                                        <div class="menu-page" style="display: block">
                                                            <select class="form-control" name="footer_menu_page[{{$loop->iteration - 1}}][]">
                                                                <option value="">{{__('Admin/backend.select_option')}}</option>
                                                                @foreach ($front_pages as $front_page)
                                                                    <option value="{{ $front_page->id }}">{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="menu-label" style="display: none">
                                                            <div class="english">
                                                                <input type="text" class="form-control" name="footer_menu_label[{{$loop->iteration - 1}}][]" value="" />
                                                            </div>
                                                            <div class="arabic">
                                                                <input type="text" class="form-control" name="footer_menu_label_ar[{{$loop->iteration - 1}}][]" value="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>{{__('Admin/backend.sub_menu')}}:</label>
                                                    </div>
                                                </div>

                                                <input hidden id="footer_menu{{$loop->iteration - 1}}_sub_increment0" name="footermenusubincrement[{{$loop->iteration - 1}}][]" value="0">
                                                <div id="footer_menu{{$loop->iteration - 1}}_sub0_clone0" class="footer-menu-sub-clone clone">
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <select class="form-control" name="footer_menu_sub_type[{{$loop->iteration - 1}}][0][]" onchange="changeHeaderFooterMenuType($(this))">
                                                                <option value="page" selected>{{__('Admin/backend.page')}}</option>
                                                                <option value="label">{{__('Admin/backend.label')}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6 menu-sub-page-label">
                                                            <div class="menu-page" style="display: block">
                                                                <select class="form-control" name="footer_menu_sub_page[{{$loop->iteration - 1}}][0][]">
                                                                    <option value="">{{__('Admin/backend.select_option')}}</option>
                                                                    @foreach ($front_pages as $front_page)
                                                                        <option value="{{ $front_page->id }}">{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="menu-label" style="display: none">
                                                                <div class="english">
                                                                    <input type="text" class="form-control" name="footer_menu_sub_label[{{$loop->iteration - 1}}][0][]" value="" />
                                                                </div>
                                                                <div class="arabic">
                                                                    <input type="text" class="form-control" name="footer_menu_sub_label_ar[{{$loop->iteration - 1}}][0][]" value="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-2 px-1">
                                                            <i class="fa fa-plus-circle" aria-hidden="true" onclick="addFooterMenuSubForm($(this))"></i>
                                                            <i class="fa fa-minus" aria-hidden="true" onclick="deleteFooterMenuSubForm($(this))"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                        
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <button class="btn btn-primary fa fa-plus" type="button" onclick="addFooterMenuForm($(this))"></button>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <button class="btn btn-danger fa fa-minus" type="button" onclick="removeFooterMenuForm($(this))"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <button class="btn btn-primary fa fa-plus" type="button" onclick="addFooterMenuSectionForm($(this))"></button>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <button class="btn btn-danger fa fa-minus" type="button" onclick="removeFooterMenuSectionForm($(this))"></button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div id="footer_menu_section_clone0" class="footer-menu-section-clone clone border border-dark p-2 mb-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><h5>{{__('Admin/backend.title')}}</h5></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="english">
                                                <textarea class="form-control ckeditor-input" name="footer_menu_title[]" id="footer_menu_title0" placeholder="{{__('Admin/backend.title')}}"></textarea>
                                            </div>
                                            <div class="arabic">
                                                <textarea class="form-control ckeditor-input" name="footer_menu_title_ar[]" id="footer_menu_title_ar0" placeholder="{{__('Admin/backend.title')}}"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label><h5>{{__('Admin/backend.menu')}}</h5></label>
                                        </div>
                                    </div>

                                    <input hidden id="footer_menu_increment0" name="footermenuincrement[]" value="0">
                                    <div id="footer_menu0_clone0" class="footer-menu-clone clone border border-dark p-2 mb-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>{{__('Admin/backend.item')}}:</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <select class="form-control" name="footer_menu_type[0][]" onchange="changeHeaderFooterMenuType($(this))">
                                                    <option value="page" selected>{{__('Admin/backend.page')}}</option>
                                                    <option value="label">{{__('Admin/backend.label')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-8 menu-page-label">
                                                <div class="menu-page" style="display: block">
                                                    <select class="form-control" name="footer_menu_page[0][]">
                                                        <option value="">{{__('Admin/backend.select_option')}}</option>
                                                        @foreach ($front_pages as $front_page)
                                                            <option value="{{ $front_page->id }}">{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="menu-label" style="display: none">
                                                    <div class="english">
                                                        <input type="text" class="form-control" name="footer_menu_label[0][]" value="" />
                                                    </div>
                                                    <div class="arabic">
                                                        <input type="text" class="form-control" name="footer_menu_label_ar[0][]" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>{{__('Admin/backend.sub_menu')}}:</label>
                                            </div>
                                        </div>

                                        <input hidden id="footer_menu0_sub_increment0" name="footermenusubincrement[0][]" value="0">
                                        <div id="footer_menu0_sub0_clone0" class="footer-menu-sub-clone clone">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <select class="form-control" name="footer_menu_sub_type[0][0][]" onchange="changeHeaderFooterMenuType($(this))">
                                                        <option value="page" selected>{{__('Admin/backend.page')}}</option>
                                                        <option value="label">{{__('Admin/backend.label')}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 menu-sub-page-label">
                                                    <div class="menu-page" style="display: block">
                                                        <select class="form-control" name="footer_menu_sub_page[0][0][]">
                                                            <option value="">{{__('Admin/backend.select_option')}}</option>
                                                            @foreach ($front_pages as $front_page)
                                                                <option value="{{ $front_page->id }}">{{ app()->getLocale() == 'en' ? $front_page->title : $front_page->title_ar }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="menu-label" style="display: none">
                                                        <div class="english">
                                                            <input type="text" class="form-control" name="footer_menu_sub_label[0][0][]" value="" />
                                                        </div>
                                                        <div class="arabic">
                                                            <input type="text" class="form-control" name="footer_menu_sub_label_ar[0][0][]" value="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2 px-1">
                                                    <i class="fa fa-plus-circle" aria-hidden="true" onclick="addFooterMenuSubForm($(this))"></i>
                                                    <i class="fa fa-minus" aria-hidden="true" onclick="deleteFooterMenuSubForm($(this))"></i>
                                                </div>
                                            </div>
                                        </div>
                                                
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <button class="btn btn-primary fa fa-plus" type="button" onclick="addFooterMenuForm($(this))"></button>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <button class="btn btn-danger fa fa-minus" type="button" onclick="removeFooterMenuForm($(this))"></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <button class="btn btn-primary fa fa-plus" type="button" onclick="addFooterMenuSectionForm($(this))"></button>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button class="btn btn-danger fa fa-minus" type="button" onclick="removeFooterMenuSectionForm($(this))"></button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="button" onclick="submitFormAction('headerFooterForm')" class="btn btn-gradient-primary mr-2">{{__('Admin/backend.submit')}}</button>
                    <a class="btn btn-light" href="{{url()->previous()}}">{{__('Admin/backend.cancel')}}</a>
                </form>
            </div>
        </div>
    </div>
@endsection