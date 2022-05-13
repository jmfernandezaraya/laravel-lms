
        </div>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-contact">
                        <!-- <h3>Mentor</h3> -->
                        <img src="{{ asset('public/frontend/assets/img/logo.png') }}" class="img-fluid" alt="" style="width: 50%;">
                        <p>
                            Lorem Ipsum is simply <br>
                            dummy text of the printing <br>
                            and typesetting industry. <br><br>
                            <strong>Phone:</strong> +1 1234 1234 55<br>
                            <strong>Email:</strong> Linkforsa@gmail.com<br>
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Find a school</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Get advice</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Why book with us</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services1</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services2</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services3</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services4</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Join Our Newsletter</h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <input type="email" name="email"><input type="submit" value="Subscribe">
                    </div>
                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">
            <div class="mr-md-auto text-center text-md-left">
                <div class="copyright">
                    &copy; Copyright <strong><span>Linkforsa</span></strong>. All Rights Reserved
                </div>
                <div class="credits">
                    Designed by <a href="http://reinsoft.tech/">Reinsoft</a>
                </div>
            </div>

            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
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

    <!-- Template Main JS File -->
    <script src="{{ asset('public/frontend/assets/js/main.js') }}"></script>

    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/abhilash.js') }}"></script>

    @yield('js')
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API || {}, Tawk_LoadStart = new Date();
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
</body>
</html>