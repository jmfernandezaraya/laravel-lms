                  <footer class="footer">
                        <div class="container-fluid clearfix">
                              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Team24 2020</span>
                        </div>
                  </footer>
                  <!-- partial -->
            </div>
      <!-- main-panel ends -->
      </div>
<!-- page-body-wrapper ends -->
</div>

<!-- container-scroller -->

@toastr_js
@toastr_render

<script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js" integrity="sha512-RnlQJaTEHoOCt5dUTV0Oi0vOBMI9PjCU7m+VHoJ4xmhuUNcwnB5Iox1es+skLril1C3gHTLbeRepHs1RpSCLoQ==" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script src="{{asset('assets/js/cloneData.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/dist/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/tag/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>

<script src="{{asset('assets/js/abhilash.js')}}"></script>
<script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{asset('assets/vendors/chart.js/Chart.min.js')}}"></script>
<!-- End plugin js for this page -->
<!-- inject:js --> 
<script src="{{asset('assets/js/off-canvas.js')}}"></script>
<script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('assets/js/misc.js')}}"></script>
<!-- endinject -->    <!-- Custom js for this page -->
<script src="{{asset('assets/js/dashboard.js')}}"></script>
<script src="{{asset('assets/js/todolist.js')}}"></script>
<script src="{{asset('assets/datatables/datatables.min.js')}}"></script>
@livewireScripts
<script>
    $(document).ready(function() {
      if($('table').length){      
            $('table').DataTable();      
      }
    });
    var token = "{{csrf_token()}}";
    var delete_on_confirm= "{{__('SuperAdmin/backend.confirm_delete')}}";    	
</script>
<!-- End custom js for this page -->
@yield('js')