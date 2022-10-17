        </div>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-contact">
                        <img src="{{ getFooterLogo() ? getStorageImages('setting', getFooterLogo()) : asset('public/frontend/assets/img/logo.png') }}" class="img-fluid" alt="" style="width: 50%;">
                        <div>{!! getFooterDescription() !!}</div>
                        <p><strong>{{__('Frontend.phone')}}:</strong> {{ getSiteEmail() }}</p>
                        <p><strong>{{__('Frontend.email')}}:</strong> {{ getSitePhone() }}</p>
                    </div>

                    @php $footer_menu = getFooterMenu(); @endphp
                    @foreach ($footer_menu as $footer_menu_section)
                        <div class="col-lg-2 col-md-6 footer-links">
                            <h4>{!! app()->getLocale() == 'en' ? $footer_menu_section['title'] : $footer_menu_section['title_ar'] !!}</h4>
                            <ul>
                                @foreach ($footer_menu_section['menu'] as $footer_menu)
                                    <li class="{{ count($footer_menu['sub_menu']) ? 'drop-down' : '' }}">
                                        <i class="bx bx-chevron-right"></i>
                                        <a href="{{ $footer_menu['type'] == 'page' ? getPageUrl($footer_menu['page']) : '' }}">
                                            @if ($footer_menu['type'] == 'page')
                                                {{ getPageTitle($footer_menu['page']) }}
                                            @else
                                                @if (app()->getLocale() == 'en')
                                                    {{ $footer_menu['label'] }}
                                                @else
                                                    {{ $footer_menu['label_ar'] }}
                                                @endif
                                            @endif
                                        </a>
                                        @if (count($footer_menu['sub_menu']))
                                            <ul>
                                                @foreach ($footer_menu['sub_menu'] as $footer_menu_sub)
                                                    <li>
                                                        <a href="{{ $footer_menu_sub['type'] == 'page' ? getPageUrl($footer_menu_sub['page']) : '' }}">
                                                            @if ($footer_menu_sub['type'] == 'page')
                                                                {{ getPageTitle($footer_menu_sub['page']) }}
                                                            @else
                                                                @if (app()->getLocale() == 'en')
                                                                    {{ $footer_menu_sub['label'] }}
                                                                @else
                                                                    {{ $footer_menu_sub['label_ar'] }}
                                                                @endif
                                                            @endif
                                                        </a>
                                                        @if (count($footer_menu_sub['menu']))
                                                            <ul>
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>{!! getSiteNewsletter()['title'] !!}</h4>
                        <div>{!! getSiteNewsletter()['description'] !!}</div>
                        <input type="email" name="email">
                        <input type="submit" value="{{__('Frontend.subscribe')}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">
            <div class="mr-md-auto text-center text-md-left">
                <div class="copyright">
                    {!! getFooterCopyright() !!}
                </div>
                <div class="credits">
                    {!! getFooterCredits() !!}
                </div>
            </div>

            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                @php $socials = getSocials(); @endphp
                @if (isset($socials['twitter']) && $socials['twitter'])
                    <a href="{{ $socials['twitter'] }}" class="twitter" target="_blank"><i class="bx bxl-twitter"></i></a>
                @endif
                @if (isset($socials['facebook']) && $socials['facebook'])
                    <a href="{{ $socials['facebook'] }}" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a>
                @endif
                @if (isset($socials['instagram']) && $socials['instagram'])
                    <a href="{{ $socials['instagram'] }}" class="instagram" target="_blank"><i class="bx bxl-instagram"></i></a>
                @endif
                @if (isset($socials['snapchat']) && $socials['snapchat'])
                    <a href="{{ $socials['snapchat'] }}" class="google-plus" target="_blank"><i class="bx bxl-snapchat"></i></a>
                @endif
                @if (isset($socials['youtube']) && $socials['youtube'])
                    <a href="{{ $socials['youtube'] }}" class="google-plus" target="_blank"><i class="bx bxl-youtube"></i></a>
                @endif
                @if (isset($socials['tiktok']) && $socials['tiktok'])
                    <a href="{{ $socials['tiktok'] }}" class="tiktok" target="_blank"><i class="bx bxl-tiktok"></i></a>
                @endif
                @if (isset($socials['pinterest']) && $socials['pinterest'])
                    <a href="{{ $socials['pinterest'] }}" class="pinterest" target="_blank"><i class="bx bxl-pinterest"></i></a>
                @endif
                @if (isset($socials['skype']) && $socials['skype'])
                    <a href="{{ $socials['skype'] }}" class="skype" target="_blank"><i class="bx bxl-skype"></i></a>
                @endif
                @if (isset($socials['linkedin']) && $socials['linkedin'])
                    <a href="{{ $socials['linkedin'] }}" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a>
                @endif
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    
    <!-- Ignite UI for jQuery Required Combined JavaScript Files -->
    <script src="https://cdn-na.infragistics.com/igniteui/latest/js/infragistics.core.js"></script>
    <script src="https://cdn-na.infragistics.com/igniteui/latest/js/infragistics.lob.js"></script>

    <script src="{{ asset('public/frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/vendor/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/extention/choices.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/countrySelect.js') }}"></script>
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('public/frontend/assets/js/main.js') }}"></script>

    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/abhilash.js') }}"></script>

    @yield('js')
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6061b385f7ce18270934f82c/1f1uqahhq';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <script>
        var like_school_url = "{{url('like_school')}}";

        var url_search_age_list = "{{route('frontend.search.ages')}}";
        var url_search_country_list = "{{route('frontend.search.countries')}}";
        var url_search_program_type_list = "{{route('frontend.search.program_types')}}";
        var url_search_study_mode_list = "{{route('frontend.search.study_modes')}}";
        var url_search_city_list = "{{route('frontend.search.cities')}}";
        var url_search_program_name_list = "{{route('frontend.search.program_names')}}";
        var url_search_program_duration_list = "{{route('frontend.search.program_durations')}}";

        var url_search_course = "{{route('frontend.search.course')}}";
        var url_course = "{{route('frontend.course')}}";
        
        var please_choose_str = "{{__('Frontend.please_choose')}}";
        
        $('#contact-form').submit(function(event) {
            event.preventDefault();
    
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ getreCAPTCHASiteKey() }}', {action: 'contact_form'}).then(function(token) {
                    $('#contact-form').prepend('<input type="hidden" name="token" value="' + token + '">');
                    $('#contact-form').prepend('<input type="hidden" name="action" value="contact_form">');
                    $('#contact-form').unbind('submit').submit();
                });;
            });
        });
    </script>
</body>
</html>