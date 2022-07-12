            <footer class="footer">
                <div class="container-fluid clearfix">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Team24 2020</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
</div>
<!-- page-body-wrapper ends -->

@livewireScripts

<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js" integrity="sha512-RnlQJaTEHoOCt5dUTV0Oi0vOBMI9PjCU7m+VHoJ4xmhuUNcwnB5Iox1es+skLril1C3gHTLbeRepHs1RpSCLoQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<!-- Ignite UI for jQuery Required Combined JavaScript Files -->
<script src="https://cdn-na.infragistics.com/igniteui/latest/js/infragistics.core.js"></script>
<script src="https://cdn-na.infragistics.com/igniteui/latest/js/infragistics.lob.js"></script>

<script src="{{asset('assets/js/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/js/cloneData.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/dist/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/tag/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>

<script src="{{asset('assets/js/abhilash.js')}}"></script>

<script src="{{asset('assets/vendors/chart.js/Chart.min.js')}}"></script>

<script src="{{asset('assets/js/off-canvas.js')}}"></script>
<script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('assets/js/misc.js')}}"></script>

<script src="{{asset('assets/js/dashboard.js')}}"></script>
<script src="{{asset('assets/js/todolist.js')}}"></script>
<script src="{{asset('assets/datatables/datatables.min.js')}}"></script>

<script src="{{asset('assets/js/tag/js/tag-it.js')}}"></script>
<script src="{{asset('assets/js/ckeditor/ckeditor.js')}}"></script>

<script>
    var token = "{{csrf_token()}}";
    var delete_on_confirm = "{{__('Admin/backend.confirm_delete')}}";
    var clone_on_confirm = "{{__('Admin/backend.confirm_clone')}}";
    
    @auth ('superadmin')
        var url_school_city_by_country_list = "{{route('superadmin.school.city_by_country.list')}}";
        var url_school_country_list = "{{route('superadmin.school.country.list')}}";
        var url_school_city_list = "{{route('superadmin.school.city.list')}}";
        var url_school_branch_list = "{{route('superadmin.school.branch.list')}}";    
        var course_list_page = "{{route('superadmin.course.index')}}";
        var course_url_store = "{{route('superadmin.course.store')}}";
        var program_under_age_url = "{{route('superadmin.course.program_under_age')}}";
        var edit_program_under_age_url = "{{route('superadmin.course.program_under_age.edit')}}";  
        var accommodation_url = "{{route('superadmin.course.accommodation')}}";
        var edit_accommodation_url = "{{route('superadmin.course.accommodation.edit')}}";
        var accomm_under_age_url = "{{route('superadmin.course.accomm_under_age')}}";
        var edit_accomm_under_age_url = "{{route('superadmin.course.accomm_under_age.edit')}}";
        var other_service_url = "{{route('superadmin.course.other_service')}}";
        var edit_other_service_url = "{{route('superadmin.course.other_service.edit')}}";
        var add_language_url = "{{route('superadmin.language.add')}}";
        var delete_language_url = "{{route('superadmin.language.delete')}}";
        var add_study_mode_url = "{{route('superadmin.study_mode.add')}}";
        var delete_study_mode_url = "{{route('superadmin.study_mode.delete')}}";
        var add_program_type_url = "{{route('superadmin.program_type.add')}}";
        var delete_program_type_url = "{{route('superadmin.program_type.delete')}}";
        var add_branch_url = "{{route('superadmin.branch.add')}}";
        var delete_branch_url = "{{route('superadmin.branch.delete')}}";
        var add_study_time_url = "{{route('superadmin.study_time.add')}}";
        var delete_study_time_url = "{{route('superadmin.study_time.delete')}}";
        var add_classes_day_url = "{{route('superadmin.classes_day.add')}}";
        var delete_classes_day_url = "{{route('superadmin.classes_day.delete')}}";
        var add_start_day_url = "{{route('superadmin.start_day.add')}}";
        var delete_start_day_url = "{{route('superadmin.start_day.delete')}}";
        var add_program_age_range_url = "{{route('superadmin.program_age_range.add')}}";
        var delete_program_age_range_url = "{{route('superadmin.program_age_range.delete')}}";
        var add_program_under_age_range_url = "{{route('superadmin.program_under_age_range.add')}}";
        var delete_program_under_age_range_url = "{{route('superadmin.program_under_age_range.delete')}}";
        var add_accomm_age_range_url = "{{route('superadmin.accomm_age_range.add')}}";
        var delete_accomm_age_range_url = "{{route('superadmin.accomm_age_range.delete')}}";
        var add_accomm_custodian_range_url = "{{route('superadmin.accomm_custodian_age.add')}}";
        var delete_accomm_custodian_range_url = "{{route('superadmin.accomm_custodian_age.delete')}}";
        var add_accomm_under_range_url = "{{route('superadmin.accomm_under_age.add')}}";
        var delete_accomm_under_range_url = "{{route('superadmin.accomm_under_age.delete')}}";
        var add_school_nationality_url = "{{route('superadmin.school.nationality.add')}}";
        var delete_school_nationality_url = "{{route('superadmin.school.nationality.delete')}}";
    @else
        @auth ('schooladmin')
            var url_school_city_by_country_list = "{{route('schooladmin.school.city_by_country.list')}}";
            var url_school_country_list = "{{route('schooladmin.school.country.list')}}";
            var url_school_city_list = "{{route('schooladmin.school.city.list')}}";
            var url_school_branch_list = "{{route('schooladmin.school.branch.list')}}";    
            var course_list_page = "{{route('schooladmin.course.index')}}";
            var course_url_store = "{{route('schooladmin.course.store')}}";
            var program_under_age_url = "{{route('schooladmin.course.program_under_age')}}";
            var edit_program_under_age_url = "{{route('schooladmin.course.program_under_age.edit')}}";  
            var accommodation_url = "{{route('schooladmin.course.accommodation')}}";
            var edit_accommodation_url = "{{route('schooladmin.course.accommodation.edit')}}";
            var accomm_under_age_url = "{{route('schooladmin.course.accomm_under_age')}}";
            var edit_accomm_under_age_url = "{{route('schooladmin.course.accomm_under_age.edit')}}";
            var other_service_url = "{{route('schooladmin.course.other_service')}}";
            var edit_other_service_url = "{{route('schooladmin.course.other_service.edit')}}";
            var add_language_url = "{{route('schooladmin.language.add')}}";
            var delete_language_url = "{{route('schooladmin.language.delete')}}";
            var add_study_mode_url = "{{route('schooladmin.study_mode.add')}}";
            var delete_study_mode_url = "{{route('schooladmin.study_mode.delete')}}";
            var add_program_type_url = "{{route('schooladmin.program_type.add')}}";
            var delete_program_type_url = "{{route('schooladmin.program_type.delete')}}";
            var add_branch_url = "{{route('schooladmin.branch.add')}}";
            var delete_branch_url = "{{route('schooladmin.branch.delete')}}";
            var add_study_time_url = "{{route('schooladmin.study_time.add')}}";
            var delete_study_time_url = "{{route('schooladmin.study_time.delete')}}";
            var add_classes_day_url = "{{route('schooladmin.classes_day.add')}}";
            var delete_classes_day_url = "{{route('schooladmin.classes_day.delete')}}";
            var add_start_day_url = "{{route('schooladmin.start_day.add')}}";
            var delete_start_day_url = "{{route('schooladmin.start_day.delete')}}";
            var add_program_age_range_url = "{{route('schooladmin.program_age_range.add')}}";
            var delete_program_age_range_url = "{{route('schooladmin.program_age_range.delete')}}";
            var add_program_under_age_range_url = "{{route('schooladmin.program_under_age_range.add')}}";
            var delete_program_under_age_range_url = "{{route('schooladmin.program_under_age_range.delete')}}";
            var add_accomm_age_range_url = "{{route('schooladmin.accomm_age_range.add')}}";
            var delete_accomm_age_range_url = "{{route('schooladmin.accomm_age_range.delete')}}";
            var add_accomm_custodian_range_url = "{{route('schooladmin.accomm_custodian_age.add')}}";
            var delete_accomm_custodian_range_url = "{{route('schooladmin.accomm_custodian_age.delete')}}";
            var add_accomm_under_range_url = "{{route('schooladmin.accomm_under_age.add')}}";
            var delete_accomm_under_range_url = "{{route('schooladmin.accomm_under_age.delete')}}";
            var add_school_nationality_url = "{{route('schooladmin.school.nationality.add')}}";
            var delete_school_nationality_url = "{{route('schooladmin.school.nationality.delete')}}";
        @endauth
    @endauth

    
    var select_option = "{{__('Admin/backend.select_option')}}";
    var search = "{{__('Admin/backend.search')}}";

    var formnum = typeof(formnums) != 'undefined' ? formnums :  0;
    var rowNum = typeof(rowNums) != 'undefined' ? rowNums :0;
    var textbooknum = typeof(textbooknums) != 'undefined' ? textbooknums : 1;
    var rowNum1 = typeof(rowNum1s) != 'undefined' ? rowNum1s : 1;
    var rowNum2 = typeof(rowNum2s) != 'undefined' ? rowNum2s :  1;
    var rowNum3 = typeof(rowNum3s) != 'undefined' ? rowNum3s : 1;
    var rowNum4 = typeof(rowNum4s) != 'undefined' ? rowNum4s : 1;
    var rowNum5 = typeof(rowNum5s) != 'undefined' ? rowNum5s : 1;
    var remove_program_button = 0;
    var i = 1;
    var edit_textbooknum = typeof(edit_textbooknums) != 'undefined' ? edit_textbooknums : 1;

    /*
    * Function for Text Book
    * */
    function addTextBook(this_object) {
        var copied = $($(this_object).parent().parent()).clone(true);
        copied.insertAfter($(this_object).parent().parent());
        console.log(o);
    }

    function removeTextBook(object, this_object) {
        $(this_object).parent().parent().remove();
    }

    function removeTextBookFee(object) {
        if (!(textbooknum <= 1)) {
            textbooknum--;
            $(object).parent().parent().remove();
        }
    }

    /*
    * Function for Course Program
    * */
    var course_program_clone = 0;
    function addCourseProgram(object) {
        course_program_clone++;
        var clone_course_program_form = object.closest(".clone");
        var course_program_clone_index = parseInt($(clone_course_program_form).attr('id').replace("course_program_clone", ""));
        var new_clone_form = $(clone_course_program_form).clone(true);
        new_clone_form.attr('id', 'course_program_clone' + course_program_clone);
        $('#program_increment').val(course_program_clone);

        var clone_course_program_forms = $(".course-program-clone");
        for (var course_program_index = 0; course_program_index < clone_course_program_forms.length; course_program_index++) {
            var clone_course_program_index = parseInt($(clone_course_program_forms[course_program_index]).attr('id').replace("course_program_clone", ""));
            if (clone_course_program_index > course_program_clone_index) {
                $(clone_course_program_forms[course_program_index]).attr('id', 'course_program_clone' + (clone_course_program_index + 1));
                $(clone_course_program_forms[course_program_index]).find('[name="age_range[' + clone_course_program_index + '][]"]').attr('name', 'age_range[' + (clone_course_program_index + 1) + '][]');
                $(clone_course_program_forms[course_program_index]).find('[name="available_days[]"]').data('index', clone_course_program_index + 1);

                $(clone_course_program_forms[course_program_index]).find('[name="about_courier[]"]').attr('id', 'about_courier' + (clone_course_program_index + 1));
                $(clone_course_program_forms[course_program_index]).find('#cke_about_courier' + clone_course_program_index).attr('id', 'cke_about_courier' + (clone_course_program_index + 1));
                $(clone_course_program_forms[course_program_index]).find('[name="about_courier_ar[]"]').attr('id', 'about_courier_ar' + (clone_course_program_index + 1));
                $(clone_course_program_forms[course_program_index]).find('#cke_about_courier_ar' + clone_course_program_index).attr('id', 'cke_about_courier_ar' + (clone_course_program_index + 1));
            }
        }

        var course_program_id = ((new Date()).getTime()).toString();
        $(new_clone_form).find('[name="program_id[]"]').val(course_program_id);
        $(new_clone_form).find('[name="program_id[]"]').attr('id', 'program_id' + (course_program_clone_index + 1));
        $(new_clone_form).find('[name="program_registration_fee[]"]').val('');
        $(new_clone_form).find('[name="program_duration[]"]').val('');
        $(new_clone_form).find('[name="deposit[]"]').val('');
        var age_range_html = $(new_clone_form).find('[name="age_range[' + course_program_clone_index + '][]"]').html();
        age_range_html = '<select name="age_range[' + (course_program_clone_index + 1) + '][]" id="program_age_range_choose' + (course_program_clone_index + 1) + '" multiple="multiple" class="3col active">' + age_range_html + '</select>';
        $(new_clone_form).find('[name="age_range[' + course_program_clone_index + '][]"]').parent().remove();
        $(new_clone_form).find('.age_range').append(age_range_html);
        $(new_clone_form).find('[name="age_range[' + (course_program_clone_index + 1) + '][]"]').val('');
        $(new_clone_form).find('[name="age_range[' + (course_program_clone_index + 1) + '][]"]').multiselect({ includeSelectAllOption: true });
        $(new_clone_form).find('[name="courier_fee[]"]').val('');
        $(new_clone_form).find('[name="about_courier[]"]').attr('id', 'about_courier' + (course_program_clone_index + 1));
        $(new_clone_form).find('[name="about_courier[]"]').text('');
        $(new_clone_form).find('#cke_about_courier' + course_program_clone_index).remove();
        $(new_clone_form).find('[name="about_courier_ar[]"]').attr('id', 'about_courier_ar' + (course_program_clone_index + 1));
        $(new_clone_form).find('[name="about_courier_ar[]"]').text('');
        $(new_clone_form).find('#cke_about_courier_ar' + course_program_clone_index).remove();
        $(new_clone_form).find('[name="program_cost[]"]').val('');
        $(new_clone_form).find('[name="program_duration_start[]"]').val('');
        $(new_clone_form).find('[name="program_duration_end[]"]').val('');
        $(new_clone_form).find('[name="program_start_date[]"]').val('');
        $(new_clone_form).find('[name="program_end_date[]"]').val('');
        $(new_clone_form).find('[name="available_date[]"]').val('start_day_every');
        $(new_clone_form).find('[name="select_day_week[]"]').val('Monday');
        $(new_clone_form).find('.select_day_week').show();
        $(new_clone_form).find('[name="available_days[]"]').val('');
        $(new_clone_form).find('[name="available_days[]"]').attr('id', '');
        $(new_clone_form).find('[name="available_days[]"]').data('index', (course_program_clone_index + 1));
        $(new_clone_form).find('.available_days').hide();
        yeardatepicker_days.push([]);
        yeardatepicker_months.push([]);
        $(new_clone_form).find('[name="discount_per_week[]"]').val('');
        $(new_clone_form).find('[name="discount_symbol[]"]').val('%');
        $(new_clone_form).find('[name="discount_start_date[]"]').val('');
        $(new_clone_form).find('[name="discount_end_date[]"]').val('');
        $(new_clone_form).find('[name="christmas_start_date[]"]').val('');
        $(new_clone_form).find('[name="christmas_end_date[]"]').val('');
        $(new_clone_form).find('[name="x_week_selected[]"]').val('');
        $(new_clone_form).find('[name="how_many_week_free[]"]').val('1');
        $(new_clone_form).find('[name="x_week_start_date[]"]').val('');
        $(new_clone_form).find('[name="x_week_end_date[]"]').val('');
        $(new_clone_form).find('[name="summer_fee_per_week[]"]').val('');
        $(new_clone_form).find('[name="summer_fee_start_date[]"]').val('');
        $(new_clone_form).find('[name="summer_fee_end_date[]"]').val('');
        $(new_clone_form).find('[name="peak_time_fee_per_week[]"]').val('');
        $(new_clone_form).find('[name="peak_time_start_date[]"]').val('');
        $(new_clone_form).find('[name="peak_time_end_date[]"]').val('');

        $(new_clone_form).find('[name="meal[]"]').val('');

        new_clone_form.insertAfter($(clone_course_program_form));

        initCkeditor('about_courier' + (course_program_clone_index + 1));
        initCkeditor('about_courier_ar' + (course_program_clone_index + 1));

        initYearDatePicker();
    }

    function removeCourseProgram(object) {
        var clone_course_program_form = object.closest(".clone");
        var course_program_clone_index = parseInt($(clone_course_program_form).attr('id').replace("course_program_clone", ""));
        $(clone_course_program_form).remove();
        var clone_course_program_forms = $(".course-program-clone");
        for (var course_program_index = 0; course_program_index < clone_course_program_forms.length; course_program_index++) {
            var clone_course_program_index = parseInt($(clone_course_program_forms[course_program_index]).attr('id').replace("course_program_clone", ""));
            if (clone_course_program_index > course_program_clone_index) {
                $(clone_course_program_forms[clone_course_program_index]).attr('id', 'course_program_clone' + (clone_course_program_index - 1));
                $(clone_course_program_forms[clone_course_program_index]).find('[name="age_range[' + clone_course_program_index + '][]"]').attr('name', 'age_range[' + (clone_course_program_index - 1) + '][]');
                $(clone_course_program_forms[clone_course_program_index]).find('[name="available_days[]"]').data('index', clone_course_program_index - 1);
                yeardatepicker_days.splice(clone_course_program_index, 1);
                yeardatepicker_months.splice(clone_course_program_index, 1);

                $(clone_course_program_forms[clone_course_program_index]).find$(new_clone_form).find('[name="about_courier[]"]').attr('id', 'about_courier' + (clone_course_program_index - 1));
                $(clone_course_program_forms[clone_course_program_index]).find$(new_clone_form).find('[name="about_courier_ar[]"]').attr('id', 'about_courier_ar' + (clone_course_program_index - 1));
            }
        }
        course_program_clone--;
        $('#program_increment').val(course_program_clone);

        initYearDatePicker();
    }

    /*
    * Function for Program Under Age
    * */
    var program_under_age_clone = 0;
    function addProgramUnderAgeFee(object) {
        program_under_age_clone++;
        var clone_program_under_age_form = object.closest(".clone");
        var program_under_age_clone_index = parseInt($(clone_program_under_age_form).attr('id').replace("under_age_fee_clone", ""));
        $('#underagefeeincrement').val(program_under_age_clone);

        var clone_course_program_under_age_forms = $(".under-age-fee-clone");
        for (var course_program_under_age_index = 0; course_program_under_age_index < clone_course_program_under_age_forms.length; course_program_under_age_index++) {
            var clone_course_program_under_age_index = parseInt($(clone_course_program_under_age_forms[course_program_under_age_index]).attr('id').replace("under_age_fee_clone", ""));
            if (clone_course_program_under_age_index > program_under_age_clone_index) {
                $(clone_course_program_under_age_forms[course_program_under_age_index]).attr('id', 'under_age_fee_clone' + (clone_course_program_under_age_index + 1));
                $(clone_course_program_under_age_forms[course_program_under_age_index]).find('[name="under_age[' + clone_course_program_under_age_index + '][]"]')
                    .attr('id', 'program_under_age_range_choose' + (clone_course_program_under_age_index + 1))
                    .attr('name', 'under_age[' + (clone_course_program_under_age_index + 1) + '][]');
            }
        }

        var new_clone_form = $(clone_program_under_age_form).clone(true);
        new_clone_form.attr('id', 'under_age_fee_clone' + program_under_age_clone);
        $(new_clone_form).find('[name="under_age_id[]"]').val('');
        var under_age_html = $(new_clone_form).find('[name="under_age[' + program_under_age_clone_index + '][]"]').html();
        under_age_html = '<select name="under_age[' + (program_under_age_clone_index + 1) + '][]" id="program_under_age_range_choose' + (program_under_age_clone_index + 1) + '" multiple="multiple" class="3col active">' + under_age_html + '</select>';
        $(new_clone_form).find('[name="under_age[' + program_under_age_clone_index + '][]"]').parent().remove();
        $(new_clone_form).find('.under_age').append(under_age_html);
        $(new_clone_form).find('[name="under_age[' + program_under_age_clone + '][]"]').val('');
        $(new_clone_form).find('[name="under_age[' + program_under_age_clone + '][]"]').multiselect({ includeSelectAllOption: true });
        $(new_clone_form).find('[name="under_age_fee_per_week[]"]').val('');

        new_clone_form.insertAfter($(clone_program_under_age_form));
    }

    function removeProgramUnderAgeFee(object) {
        var clone_course_program_under_age_form = object.closest(".clone");
        var program_under_age_clone_index = parseInt($(clone_program_under_age_form).attr('id').replace("under_age_fee_clone", ""));
        $(clone_course_program_under_age_form).remove();
        var clone_course_program_under_age_forms = $(".under-age-fee-clone");
        for (var course_program_under_age_index = 0; course_program_under_age_index < clone_course_program_under_age_forms.length; course_program_under_age_index++) {
            var clone_course_program_under_age_index = parseInt($(clone_course_program_under_age_forms[course_program_under_age_index]).attr('id').replace("under_age_fee_clone", ""));
            if (clone_course_program_under_age_index > program_under_age_clone_index) {
                $(clone_course_program_under_age_forms[course_program_under_age_index]).attr('id', 'under_age_fee_clone' + (clone_course_program_under_age_index - 1));
                $(clone_course_program_under_age_forms[course_program_under_age_index]).find('[name="under_age[' + clone_course_program_under_age_index + '][]"]')
                    .attr('id', 'program_under_age_range_choose' + (clone_course_program_under_age_index - 1))
                    .attr('name', 'under_age[' + (clone_course_program_under_age_index - 1) + '][]');
            }
        }
        program_under_age_clone--;
        $('#underagefeeincrement').val(program_under_age_clone);
    }
    
    /*
    * Function for Program Text Book
    * */
    var program_text_book_clone = 0;
    function addTextBookFee(object) {
        program_text_book_clone++;
        var clone_program_text_book_form = object.closest(".clone");
        var program_text_book_clone_index = parseInt($(clone_program_text_book_form).attr('id').replace("text_book_fee_clone", ""));
        $('#textbookfeeincrement').val(program_text_book_clone);
        
        var clone_course_program_text_book_forms = $(".text-book-fee-clone");
        for (var course_program_text_book_index = 0; course_program_text_book_index < clone_course_program_text_book_forms.length; course_program_text_book_index++) {
            var clone_course_program_text_book_index = parseInt($(clone_course_program_text_book_forms[course_program_text_book_index]).attr('id').replace("text_book_fee_clone", ""));
            if (clone_course_program_text_book_index > program_text_book_clone_index) {
                $(clone_course_program_text_book_forms[course_program_text_book_index]).attr('id', 'text_book_fee_clone' + (clone_course_program_text_book_index + 1));
                $(clone_course_program_text_book_forms[course_program_text_book_index]).find('[name="text_book_note[]"]').attr('id', 'text_book_note' + (clone_course_program_text_book_index + 1));
                $(clone_course_program_text_book_forms[course_program_text_book_index]).find('#cke_text_book_note' + clone_course_program_text_book_index).attr('id', 'cke_text_book_note' + (clone_course_program_text_book_index + 1));
                $(clone_course_program_text_book_forms[course_program_text_book_index]).find('[name="text_book_note_ar[]"]').attr('id', 'text_book_note_ar' + (clone_course_program_text_book_index + 1));
                $(clone_course_program_text_book_forms[course_program_text_book_index]).find('#cke_text_book_note_ar' + clone_course_program_text_book_index).attr('id', 'cke_text_book_note_ar' + (clone_course_program_text_book_index + 1));
            }
        }

        var new_clone_form = $(clone_program_text_book_form).clone(true);
        new_clone_form.attr('id', 'text_book_fee_clone' + (program_text_book_clone_index + 1));
        $(new_clone_form).find('[name="textbook_id[]"]').val('');
        $(new_clone_form).find('[name="text_book_fee[]"]').val('');
        $(new_clone_form).find('[name="text_book_fee_start_date[]"]').val('');
        $(new_clone_form).find('[name="text_book_fee_end_date[]"]').val('');
        $(new_clone_form).find('[name="text_book_fee_type[]"]').val('fixed_cost');
        $(new_clone_form).find('[name="text_book_note[]"]').attr('id', 'text_book_note' + (program_text_book_clone_index + 1));
        $(new_clone_form).find('[name="text_book_note[]"]').text('');
        $(new_clone_form).find('#cke_text_book_note' + program_text_book_clone_index).remove();
        $(new_clone_form).find('[name="text_book_note_ar[]"]').attr('id', 'text_book_note_ar' + (program_text_book_clone_index + 1));
        $(new_clone_form).find('[name="text_book_note_ar[]"]').text('');
        $(new_clone_form).find('#cke_text_book_note_ar' + program_text_book_clone_index).remove();

        new_clone_form.insertAfter($(clone_program_text_book_form));

        initCkeditor('text_book_note' + (program_text_book_clone_index + 1));
        initCkeditor('text_book_note_ar' + (program_text_book_clone_index + 1));
    }

    function removeTextBookFee(object) {
        var clone_course_program_text_book_form = object.closest(".clone");
        var program_text_book_clone_index = parseInt($(clone_course_program_text_book_form).attr('id').replace("text_book_fee_clone", ""));
        $(clone_course_program_text_book_form).remove();
        var clone_course_program_text_book_forms = $(".text-book-fee-clone");
        for (var course_program_text_book_index = 0; course_program_text_book_index < clone_course_program_text_book_forms.length; course_program_text_book_index++) {
            var clone_course_program_text_book_index = parseInt($(clone_course_program_text_book_forms[course_program_text_book_index]).attr('id').replace("text_book_fee_clone", ""));
            if (clone_course_program_text_book_index > program_text_book_clone_index) {
                $(clone_course_program_text_book_forms[course_program_text_book_index]).attr('id', 'text_book_fee_clone' + (clone_course_program_text_book_index - 1));
                $(clone_course_program_text_book_forms[course_program_text_book_index]).find('[name="text_book_note[]"]').attr('id', 'text_book_note' + (clone_course_program_text_book_index - 1));
                $(clone_course_program_text_book_forms[course_program_text_book_index]).find('[name="text_book_note_ar[]"]').attr('id', 'text_book_note_ar' + (clone_course_program_text_book_index - 1));
            }
        }
        program_text_book_clone--;
        $('#textbookfeeincrement').val(program_text_book_clone);
    }

    /*
    * Function for Accommodation
    * */
    var accommodation_clone = 0;
    function addAccommodation(object) {
        accommodation_clone++;
        var clone_accommodation_form = object.closest(".clone");
        var accommodation_clone_index = parseInt($(clone_accommodation_form).attr('id').replace("accommodation_clone", ""));

        var clone_accommodation_forms = $(".accommodation-clone");
        for (var accommodation_index = 0; accommodation_index < clone_accommodation_forms.length; accommodation_index++) {
            var clone_accommodation_index = parseInt($(clone_accommodation_forms[accommodation_index]).attr('id').replace("accommodation_clone", ""));
            if (clone_accommodation_index > accommodation_clone_index) {
                $(clone_accommodation_forms[accommodation_index]).attr('id', 'accommodation_clone' + (clone_accommodation_index + 1));
                $(clone_accommodation_forms[accommodation_index]).find('[name="age_range[' + clone_accommodation_index + '][]"]').attr('name', 'age_range[' + (clone_accommodation_index + 1) + '][]');
                $(clone_accommodation_forms[accommodation_index]).find('[name="available_days[]"]').data('index', clone_accommodation_index + 1);

                $(clone_accommodation_forms[accommodation_index]).find('[name="special_diet_note[]]').attr('id', 'special_diet_note' + (clone_accommodation_index + 1));
                $(clone_accommodation_forms[accommodation_index]).find('#cke_special_diet_note' + clone_accommodation_index).attr('id', 'cke_special_diet_note' + (clone_accommodation_index + 1));
                $(clone_accommodation_forms[accommodation_index]).find('[name="special_diet_note_ar[]]').attr('id', 'special_diet_note_ar' + (clone_accommodation_index + 1));
                $(clone_accommodation_forms[accommodation_index]).find('#cke_special_diet_note_ar' + clone_accommodation_index).attr('id', 'cke_special_diet_note_ar' + (clone_accommodation_index + 1));
            }
        }

        var new_clone_form = $(clone_accommodation_form).clone(true);
        new_clone_form.attr('id', 'accommodation_clone' + (accommodation_clone_index + 1));
        var accommodation_id = ((new Date()).getTime()).toString();
        $(new_clone_form).find('[name="accommodation_id[]"]').val(accommodation_id);
        $(new_clone_form).find('[name="type[]"]').val('');
        $(new_clone_form).find('[name="room_type[]"]').val('');
        $(new_clone_form).find('[name="meal[]"]').val('');
        var age_range_html = $(new_clone_form).find('[name="age_range[' + accommodation_clone_index + '][]"]').html();
        age_range_html = '<select name="age_range[' + (accommodation_clone_index + 1) + '][]" id="accom_age_choose' + (accommodation_clone_index + 1) + '" multiple="multiple" class="3col active">' + age_range_html + '</select>';
        $(new_clone_form).find('[name="age_range[' + accommodation_clone_index + '][]"]').parent().remove();
        $(new_clone_form).find('.age_range').append(age_range_html);
        $(new_clone_form).find('[name="age_range[' + (accommodation_clone_index + 1) + '][]"]').val('');
        $(new_clone_form).find('[name="age_range[' + (accommodation_clone_index + 1) + '][]"]').multiselect({ includeSelectAllOption: true });
        $(new_clone_form).find('[name="placement_fee[]"]').val('');
        $(new_clone_form).find('[name="program_duration[]"]').val('');
        $(new_clone_form).find('[name="deposit[]"]').val('');
        $(new_clone_form).find('[name="deposit_symbol[]"]').val('%');
        $(new_clone_form).find('[name="special_diet_note[]"]').attr('id', 'special_diet_note' + (accommodation_clone_index + 1));
        $(new_clone_form).find('[name="special_diet_note[]"]').text('');
        $(new_clone_form).find('#cke_special_diet_note' + accommodation_clone_index).remove();
        $(new_clone_form).find('[name="special_diet_note_ar[]"]').attr('id', 'special_diet_note_ar' + (accommodation_clone_index + 1));
        $(new_clone_form).find('[name="special_diet_note_ar[]"]').text('');
        $(new_clone_form).find('#cke_special_diet_note_ar' + accommodation_clone_index).remove();
        $(new_clone_form).find('[name="fee_per_week[]"]').val('');
        $(new_clone_form).find('[name="start_week[]"]').val('');
        $(new_clone_form).find('[name="end_week[]"]').val('');
        $(new_clone_form).find('[name="available_date[]"]').val('all_year_round');
        $(new_clone_form).find('[name="start_date[]"]').val('');
        $(new_clone_form).find('.start_date').show();
        $(new_clone_form).find('[name="end_date[]"]').val('');
        $(new_clone_form).find('.end_date').show();
        $(new_clone_form).find('[name="available_days[]"]').val('');
        $(new_clone_form).find('[name="available_days[]"]').attr('id', '');
        $(new_clone_form).find('[name="available_days[]"]').data('index', (accommodation_clone_index + 1));
        $(new_clone_form).find('.available_days').hide();
        yeardatepicker_days.push([]);
        yeardatepicker_months.push([]);
        $(new_clone_form).find('[name="discount_per_week[]"]').val('');
        $(new_clone_form).find('[name="discount_per_week_symbol[]"]').val('%');
        $(new_clone_form).find('[name="discount_start_date[]"]').val('');
        $(new_clone_form).find('[name="discount_end_date[]"]').val('');
        $(new_clone_form).find('[name="summer_fee_per_week[]"]').val('');
        $(new_clone_form).find('[name="summer_fee_start_date[]"]').val('');
        $(new_clone_form).find('[name="summer_fee_end_date[]"]').val('');
        $(new_clone_form).find('[name="accommodation_peak_time_fee_per_week[]"]').val('');
        $(new_clone_form).find('[name="accommodation_fee_start_date[]"]').val('');
        $(new_clone_form).find('[name="accommodation_fee_end_date[]"]').val('');
        $(new_clone_form).find('[name="christmas_fee_per_week[]"]').val('');
        $(new_clone_form).find('[name="christmas_fee_start_date[]"]').val('');
        $(new_clone_form).find('[name="christmas_fee_end_date[]"]').val('');
        $(new_clone_form).find('[name="x_week_selected[]"]').val('');
        $(new_clone_form).find('[name="how_many_week_free[]"]').val('1');
        $(new_clone_form).find('[name="x_week_start_date[]"]').val('');
        $(new_clone_form).find('[name="x_week_end_date[]"]').val('');

        new_clone_form.insertAfter($(clone_accommodation_form));

        initCkeditor('special_diet_note' + (accommodation_clone_index + 1));
        initCkeditor('special_diet_note_ar' + (accommodation_clone_index + 1));
        
        initYearDatePicker();
    }

    function deleteAccommodation(object) {
        var clone_accommodation_form = object.closest(".clone");
        var accommodation_clone_index = parseInt($(clone_accommodation_form).attr('id').replace("accommodation_clone", ""));
        $(clone_accommodation_form).remove();
        var clone_accommodation_forms = $(".accommodation-clone");
        for (var accommodation_index = 0; accommodation_index < clone_accommodation_forms.length; accommodation_index++) {
            var clone_accommodation_index = parseInt($(clone_accommodation_forms[accommodation_index]).attr('id').replace("accommodation_clone", ""));
            if (clone_accommodation_index > accommodation_clone_index) {
                $(clone_accommodation_forms[accommodation_index]).attr('id', 'accommodation_clone' + (clone_accommodation_index - 1));
                $(clone_accommodation_forms[accommodation_index]).find('[name="age_range[' + clone_accommodation_index + '][]"]').attr('name', 'age_range[' + (clone_accommodation_index - 1) + '][]');
                $(clone_accommodation_forms[accommodation_index]).find('[name="custodian_condition[' + clone_accommodation_index + ']"]').attr('name', 'custodian_condition[' + (clone_accommodation_index - 1) + ']');
                $(clone_accommodation_forms[accommodation_index]).find('[name="available_days[]"]').data('index', clone_accommodation_index - 1);
                yeardatepicker_days.splice(clone_accommodation_index, 1);
                yeardatepicker_months.splice(clone_accommodation_index, 1);

                $(clone_accommodation_forms[accommodation_index]).find('[name="special_diet_note[]]').attr('id', 'special_diet_note' + (clone_accommodation_index - 1));
                $(clone_accommodation_forms[accommodation_index]).find('[name="special_diet_note_ar[]]').attr('id', 'special_diet_note_ar' + (clone_accommodation_index - 1));
            }
        }
        accommodation_clone--;
        
        initYearDatePicker();
    }

    /*
    * Function for Accommodation Under Age
    * */
    var accommodation_under_age_clone = 0;
    function addAccommodationFormUnderAge(object) {
        accommodation_under_age_clone++;
        var clone_accommodation_under_age_form = object.closest(".clone");
        var accommodation_under_age_clone_index = parseInt($(clone_accommodation_under_age_form).attr('id').replace("accommodation_under_age_clone", ""));
        $('#accomunderageincrement').val(accommodation_under_age_clone);
        
        var clone_accommodation_under_age_forms = $(".accommodation-under-age-clone");
        for (var accommodation_under_age_index = 0; accommodation_under_age_index < clone_accommodation_under_age_forms.length; accommodation_under_age_index++) {
            var clone_accommodation_under_age_index = parseInt($(clone_accommodation_under_age_forms[accommodation_under_age_index]).attr('id').replace("accommodation_under_age_clone", ""));
            if (clone_accommodation_under_age_index > accommodation_under_age_clone_index) {
                $(clone_accommodation_under_age_forms[accommodation_under_age_index]).attr('id', 'accommodation_under_age_clone' + (clone_accommodation_under_age_index + 1));
                $(clone_accommodation_under_age_forms[accommodation_under_age_index]).find('[name="under_age[' + clone_accommodation_under_age_index + '][]"]')
                    .attr('id', 'under_age_choose' + (clone_accommodation_under_age_index + 1))
                    .attr('name', 'under_age[' + (clone_accommodation_under_age_index + 1) + '][]');
            }
        }

        var new_clone_form = $(clone_accommodation_under_age_form).clone(true);
        new_clone_form.attr('id', 'accommodation_under_age_clone' + (accommodation_under_age_clone_index + 1));
        $(new_clone_form).find('[name="accom_under_age_id[]"]').val('');
        var under_age_html = $(new_clone_form).find('[name="under_age[' + accommodation_under_age_clone_index + '][]"]').html();
        under_age_html = '<select name="under_age[' + (accommodation_under_age_clone_index + 1) + '][]" id="under_age_choose' + (accommodation_under_age_clone_index + 1) + '" multiple="multiple" class="3col active">' + under_age_html + '</select>';
        $(new_clone_form).find('[name="under_age[' + accommodation_under_age_clone_index + '][]"]').parent().remove();
        $(new_clone_form).find('.under_age').append(under_age_html);
        $(new_clone_form).find('[name="under_age[' + (accommodation_under_age_clone_index + 1) + '][]"]').val('');
        $(new_clone_form).find('[name="under_age[' + (accommodation_under_age_clone_index + 1) + '][]"]').multiselect({ includeSelectAllOption: true });
        $(new_clone_form).find('[name="under_age_fee_per_week[]"]').val('');

        new_clone_form.insertAfter($(clone_accommodation_under_age_form));
    }

    function deleteAccommodationUnderAge(object) {
        var clone_accommodation_under_age_form = object.closest(".clone");
        $(clone_accommodation_under_age_form).remove();
        var clone_accommodation_under_age_forms = $(".accommodation-under-age-clone");
        for (var accommodation_under_age_index = 0; accommodation_under_age_index < clone_accommodation_under_age_forms.length; accommodation_under_age_index++) {
            var clone_accommodation_under_age_index = parseInt($(clone_accommodation_under_age_forms[accommodation_index]).attr('id').replace("accommodation_under_age_clone", ""));
            if (clone_accommodation_under_age_index >= accommodation_under_age_clone) {
                $(clone_accommodation_under_age_forms[accommodation_under_age_index]).attr('id', 'accommodation_under_age_clone' + clone_accommodation_under_age_index - 1);
                $(clone_accommodation_under_age_forms[accommodation_under_age_index]).find('[name="under_age[' + clone_accommodation_under_age_index + '][]"]')
                    .attr('id', 'under_age_choose' + (clone_accommodation_under_age_index - 1))
                    .attr('name', 'under_age[' + (clone_accommodation_under_age_index - 1) + '][]');
            }
        }
        accommodation_under_age_clone--;
        $('#accomunderageincrement').val(accommodation_under_age_clone);
    }

    /*
    * Function for Airport
    * */
    var airport_clone = 0;
    function addAirportForm(object) {
        airport_clone++;
        var clone_airport_form = object.closest(".clone");
        var airport_clone_index = parseInt($(clone_airport_form).attr('id').replace("airport_clone", ""));
        $('#airportincrement').val(airport_clone);
        var new_clone_form = $(clone_airport_form).clone(true);
        new_clone_form.attr('id', 'airport_clone' + (airport_clone_index + 1));
        $(new_clone_form).find('[name="airportfeeincrement[]"]').val(0);
        $(new_clone_form).find('[name="airport_id[]"]').val('');
        var clone_airport_forms = $(".airport-clone");
        for (var airport_index = 0; airport_index < clone_airport_forms.length; airport_index++) {
            var clone_airport_index = parseInt($(clone_airport_forms[airport_index]).attr('id').replace("airport_clone", ""));
            if (clone_airport_index > airport_clone_index) {
                var airport_fee_forms = $(clone_airport_forms[airport_index]).find(".airport-fee-clone");
                for (var airport_fee_index = 0; airport_fee_index < airport_fee_forms.length; airport_fee_index++) {
                    $(airport_fee_forms[airport_fee_index]).attr('id', 'airport' + (clone_airport_index + 1) + '_fee_clone' + airport_fee_index);
                }
                $(clone_airport_forms[airport_index]).attr('id', 'airport_clone' + (clone_airport_index + 1));
                $(clone_airport_forms[airport_index]).find('[name="airport_fee_id[' + clone_airport_index + '][]"]').attr('name', 'airport_fee_id[' + (clone_airport_index + 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_name[' + clone_airport_index + '][]"]').attr('name', 'airport_name[' + (clone_airport_index + 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_name_ar[' + clone_airport_index + '][]"]').attr('name', 'airport_name_ar[' + (clone_airport_index + 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_service_name[' + clone_airport_index + '][]"]').attr('name', 'airport_service_name[' + (clone_airport_index + 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_service_name_ar[' + clone_airport_index + '][]"]').attr('name', 'airport_service_name_ar[' + (clone_airport_index + 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_service_fee[' + clone_airport_index + '][]"]').attr('name', 'airport_service_fee[' + (clone_airport_index + 1) + '][]');
                
                $(clone_airport_forms[airport_index]).find('[name="airport_note[]]').attr('id', 'airport_note' + (clone_airport_index + 1));
                $(clone_airport_forms[airport_index]).find('#cke_airport_note' + clone_airport_index).attr('id', 'cke_airport_note' + (clone_airport_index + 1));
                $(clone_airport_forms[airport_index]).find('[name="airport_note_ar[]]').attr('id', 'airport_note_ar' + (clone_airport_index + 1));
                $(clone_airport_forms[airport_index]).find('#cke_airport_note_ar' + clone_airport_index).attr('id', 'cke_airport_note_ar' + (clone_airport_index + 1));
            }
        }
        var airport_fees = $(new_clone_form).find('.airport-fee-clone');
        for (var airport_fee_index = 0; airport_fee_index < airport_fees.length; airport_fee_index++) {
            if (airport_fee_index == 0) {
                $(airport_fees[airport_fee_index]).attr('id', 'airport' + (airport_clone_index + 1) + '_fee_clone0');
                $(airport_fees[airport_fee_index]).find('[name="airport_fee_id[' + airport_clone_index + '][]"]').attr('name', 'airport_fee_id[' + (airport_clone_index + 1) + '][]').val('');
                $(airport_fees[airport_fee_index]).find('[name="airport_name[' + airport_clone_index + '][]"]').attr('name', 'airport_name[' + (airport_clone_index + 1) + '][]').val('');
                $(airport_fees[airport_fee_index]).find('[name="airport_name_ar[' + airport_clone_index + '][]"]').attr('name', 'airport_name_ar[' + (airport_clone_index + 1) + '][]').val('');
                $(airport_fees[airport_fee_index]).find('[name="airport_service_name[' + airport_clone_index + '][]"]').attr('name', 'airport_service_name[' + (airport_clone_index + 1) + '][]').val('');
                $(airport_fees[airport_fee_index]).find('[name="airport_service_name_ar[' + airport_clone_index + '][]"]').attr('name', 'airport_service_name_ar[' + (airport_clone_index + 1) + '][]').val('');
                $(airport_fees[airport_fee_index]).find('[name="airport_service_fee[' + airport_clone_index + '][]"]').attr('name', 'airport_service_fee[' + (airport_clone_index + 1) + '][]').val('');
            } else {
                $(airport_fees[airport_fee_index]).remove();
            }
        }

        $(new_clone_form).find('[name="airport_service_provider[]"]').val('');
        $(new_clone_form).find('[name="airport_service_provider_ar[]"]').val('');
        $(new_clone_form).find('[name="airport_week_selected_fee[]"]').val('');
        $(new_clone_form).find('[name="airport_note[]"]').attr('id', 'airport_note' + (airport_clone_index + 1));
        $(new_clone_form).find('[name="airport_note[]"]').text('');
        $(new_clone_form).find('#cke_airport_note' + airport_clone_index).remove();
        $(new_clone_form).find('[name="airport_note_ar[]"]').attr('id', 'airport_note_ar' + (airport_clone_index + 1));
        $(new_clone_form).find('[name="airport_note_ar[]"]').text('');
        $(new_clone_form).find('#cke_airport_note_ar' + airport_clone_index).remove();
        new_clone_form.insertAfter($(clone_airport_form));
        
        initCkeditor('airport_note' + (airport_clone_index + 1));
        initCkeditor('airport_note_ar' + (airport_clone_index + 1));
    }
    
    function deleteAirportForm(object) {
        var clone_airport_form = object.closest(".clone");
        var airport_clone_index = parseInt($(clone_airport_form).attr('id').replace("airport_clone", ""));
        $(clone_airport_form).remove();
        var clone_airport_forms = $(".airport-clone");
        for (var airport_index = 0; airport_index < clone_airport_forms.length; airport_index++) {
            var clone_airport_index = parseInt($(clone_airport_forms[airport_index]).attr('id').replace("airport_clone", ""));
            if (clone_airport_index > airport_clone_index) {
                $(clone_airport_forms[airport_index]).attr('id', 'airport_clone' + (clone_airport_index - 1));
                $(clone_airport_forms[airport_index]).find('[name="airport_fee_id[' + clone_airport_index + '][]"]').attr('name', 'airport_fee_id[' + (clone_airport_index - 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_name[' + clone_airport_index + '][]"]').attr('name', 'airport_name[' + (clone_airport_index - 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_name_ar[' + clone_airport_index + '][]"]').attr('name', 'airport_name_ar[' + (clone_airport_index - 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_service_name[' + clone_airport_index + '][]"]').attr('name', 'airport_service_name[' + (clone_airport_index - 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_service_name_ar[' + clone_airport_index + '][]"]').attr('name', 'airport_service_name_ar[' + (clone_airport_index - 1) + '][]');
                $(clone_airport_forms[airport_index]).find('[name="airport_service_fee[' + clone_airport_index + '][]"]').attr('name', 'airport_service_fee[' + (clone_airport_index - 1) + '][]');
                
                $(clone_airport_forms[airport_index]).find('[name="airport_note[]]').attr('id', 'airport_note' + (clone_airport_index - 1));
                $(clone_airport_forms[airport_index]).find('[name="airport_note_ar[]]').attr('id', 'airport_note_ar' + (clone_airport_index - 1));
            }
        }
        airport_clone--;
        $('#airportincrement').val(airport_clone);
    }

    function addAirportFeeForm(object) {
        var clone_airport_fee_form = object.closest(".clone");
        var clone_airport_form = $(clone_airport_fee_form).parent().closest(".clone");
        var airport_index = $(clone_airport_form).attr('id').replace("airport_clone", "");
        var airport_fee_clone = parseInt($(clone_airport_form).find('[name="airportfeeincrement[]"]').val());
        airport_fee_clone++;
        var new_clone_form = $(clone_airport_fee_form).clone(true);
        new_clone_form.attr('id', 'airport' + airport_index + '_fee_clone' + airport_fee_clone);
        $(clone_airport_form).find('[name="airportfeeincrement[]"]').val(airport_fee_clone);

        $(new_clone_form).find('[name="airport_fee_id[' + airport_index + '][]"]').val('');
        $(new_clone_form).find('[name="airport_name[' + airport_index + '][]"]').val('');
        $(new_clone_form).find('[name="airport_name_ar[' + airport_index + '][]"]').val('');
        $(new_clone_form).find('[name="airport_service_name[' + airport_index + '][]"]').val('');
        $(new_clone_form).find('[name="airport_service_name_ar[' + airport_index + '][]"]').val('');
        $(new_clone_form).find('[name="airport_service_fee[' + airport_index + '][]"]').val('');

        new_clone_form.insertAfter($(clone_airport_fee_form));
    }
    
    function deleteAirportFeeForm(object) {
        var clone_airport_fee_form = object.closest(".clone");
        var clone_airport_form = $(clone_airport_fee_form).parent().closest(".clone");
        var clone_airport_index = parseInt($(clone_airport_form).attr('id').replace("airport_clone", ""));
        var clone_airport_fee_index = parseInt($(clone_airport_fee_form).attr('id').replace("airport" + clone_airport_index + "_fee_clone", ""));

        $(clone_airport_fee_form).remove();

        var airport_fee_forms = $(clone_airport_form).find(".airport-fee-clone");
        for (var airport_fee_index = 0; airport_fee_index < airport_fee_forms.length; airport_fee_index++) {
            var airport_fee_clone_index = parseInt($(airport_fee_forms[airport_fee_index]).attr('id').replace("airport" + clone_airport_index + "_fee_clone", ""));
            if (airport_fee_clone_index > clone_airport_fee_index) {
                $(airport_fee_forms[airport_fee_index]).attr('id', 'airport' + clone_airport_index + '_fee_clone' + (airport_fee_clone_index - 1));
            }
        }
        var airport_fee_clone = parseInt($(clone_airport_form).find('[name="airportfeeincrement[]"]').val());
        airport_fee_clone--;
        $(clone_airport_form).find('[name="airportfeeincrement[]"]').val(airport_fee_clone);
    }

    /*
    * Function for Medical
    * */
    var medical_clone = 0;
    function addMedicalForm(object) {
        medical_clone++;
        var clone_medical_form = object.closest(".clone");
        var medical_clone_index = parseInt($(clone_medical_form).attr('id').replace("medical_clone", ""));
        $('#medicalincrement').val(medical_clone);
        var new_clone_form = $(clone_medical_form).clone(true);
        new_clone_form.attr('id', 'medical_clone' + (medical_clone_index + 1));
        $(new_clone_form).find('[name="medicalfeeincrement[]"]').val(0);
        $(new_clone_form).find('[name="medical_id[]"]').val('');
        var clone_medical_forms = $(".medical-clone");
        for (var medical_index = 0; medical_index < clone_medical_forms.length; medical_index++) {
            var clone_medical_index = parseInt($(clone_medical_forms[medical_index]).attr('id').replace("medical_clone", ""));
            if (clone_medical_index > medical_clone_index) {
                var medical_fee_forms = $(clone_medical_forms[medical_index]).find(".medical-fee-clone");
                for (var medical_fee_index = 0; medical_fee_index < medical_fee_forms.length; medical_fee_index++) {
                    $(medical_fee_forms[medical_fee_index]).attr('id', 'medical' + (clone_medical_index + 1) + '_fee_clone' + medical_fee_index);
                }
                $(clone_medical_forms[medical_index]).attr('id', 'medical_clone' + (clone_medical_index + 1));
                $(clone_medical_forms[medical_index]).find('[name="medical_fee_id[' + clone_medical_index + '][]"]').attr('name', 'medical_fee_id[' + (clone_medical_index + 1) + '][]');
                $(clone_medical_forms[medical_index]).find('[name="medical_fees_per_week[' + clone_medical_index + '][]"]').attr('name', 'medical_fees_per_week[' + (clone_medical_index + 1) + '][]');
                $(clone_medical_forms[medical_index]).find('[name="medical_start_date[' + clone_medical_index + '][]"]').attr('name', 'medical_start_date[' + (clone_medical_index + 1) + '][]');
                $(clone_medical_forms[medical_index]).find('[name="medical_end_date[' + clone_medical_index + '][]"]').attr('name', 'medical_end_date[' + (clone_medical_index + 1) + '][]');
                
                $(clone_medical_forms[medical_index]).find('[name="medical_note[]]').attr('id', 'medical_note' + (clone_medical_index + 1));
                $(clone_medical_forms[medical_index]).find('#cke_medical_note' + clone_medical_index).attr('id', 'cke_medical_note' + (clone_medical_index + 1));
                $(clone_medical_forms[medical_index]).find('[name="medical_note_ar[]]').attr('id', 'medical_note_ar' + (clone_medical_index + 1));
                $(clone_medical_forms[medical_index]).find('#cke_medical_note_ar' + clone_medical_index).attr('id', 'cke_medical_note_ar' + (clone_medical_index + 1));
            }
        }
        var medical_fees = $(new_clone_form).find('.medical-fee-clone');
        for (var medical_fee_index = 0; medical_fee_index < medical_fees.length; medical_fee_index++) {
            if (medical_fee_index == 0) {
                $(medical_fees[medical_fee_index]).attr('id', 'medical' + (medical_clone_index + 1) + '_fee_clone0');
                $(medical_fees[medical_fee_index]).find('[name="medical_fee_id[' + medical_clone_index + '][]"]').attr('name', 'medical_fee_id[' + (medical_clone_index + 1) + '][]').val('');
                $(medical_fees[medical_fee_index]).find('[name="medical_fees_per_week[' + medical_clone_index + '][]"]').attr('name', 'medical_fees_per_week[' + (medical_clone_index + 1) + '][]').val('');
                $(medical_fees[medical_fee_index]).find('[name="medical_start_date[' + medical_clone_index + '][]"]').attr('name', 'medical_start_date[' + (medical_clone_index + 1) + '][]').val('');
                $(medical_fees[medical_fee_index]).find('[name="medical_end_date[' + medical_clone_index + '][]"]').attr('name', 'medical_end_date[' + (medical_clone_index + 1) + '][]').val('');
            } else {
                $(medical_fees[medical_fee_index]).remove();
            }
        }

        $(new_clone_form).find('[name="medical_company_name[]"]').val('');
        $(new_clone_form).find('[name="medical_company_name_ar[]"]').val('');
        $(new_clone_form).find('[name="medical_deductible[]"]').val('');
        $(new_clone_form).find('[name="medical_week_selected_fee[]"]').val('');
        $(new_clone_form).find('[name="medical_note[]"]').attr('id', 'medical_note' + (medical_clone_index + 1));
        $(new_clone_form).find('[name="medical_note[]"]').text('');
        $(new_clone_form).find('#cke_medical_note' + medical_clone_index).remove();
        $(new_clone_form).find('[name="medical_note_ar[]"]').attr('id', 'medical_note_ar' + (medical_clone_index + 1));
        $(new_clone_form).find('[name="medical_note_ar[]"]').text('');
        $(new_clone_form).find('#cke_medical_note_ar' + medical_clone_index).remove();

        new_clone_form.insertAfter($(clone_medical_form));
        
        initCkeditor('medical_note' + (medical_clone_index + 1));
        initCkeditor('medical_note_ar' + (medical_clone_index + 1));
    }
    
    function deleteMedicalForm(object) {
        var clone_medical_form = object.closest(".clone");
        var medical_clone_index = parseInt($(clone_medical_form).attr('id').replace("medical_clone", ""));
        $(clone_medical_form).remove();
        var clone_medical_forms = $(".medical-clone");
        for (var medical_index = 0; medical_index < clone_medical_forms.length; medical_index++) {
            var clone_medical_index = parseInt($(clone_medical_forms[medical_index]).attr('id').replace("medical_clone", ""));
            if (clone_medical_index > medical_clone_index) {
                $(clone_medical_forms[medical_index]).attr('id', 'medical_clone' + (clone_medical_index - 1));
                $(clone_medical_forms[medical_index]).find('[name="medical_fee_id[' + clone_medical_index + '][]"]').attr('name', 'medical_fee_id[' + (clone_medical_index - 1) + '][]');
                $(clone_medical_forms[medical_index]).find('[name="medical_fees_per_week[' + clone_medical_index + '][]"]').attr('name', 'medical_fees_per_week[' + (clone_medical_index - 1) + '][]');
                $(clone_medical_forms[medical_index]).find('[name="medical_start_date[' + clone_medical_index + '][]"]').attr('name', 'medical_start_date[' + (clone_medical_index - 1) + '][]');
                $(clone_medical_forms[medical_index]).find('[name="medical_end_date[' + clone_medical_index + '][]"]').attr('name', 'medical_end_date[' + (clone_medical_index - 1) + '][]');
                
                $(clone_medical_forms[medical_index]).find('[name="medical_note[]]').attr('id', 'medical_note' + (clone_medical_index - 1));
                $(clone_medical_forms[medical_index]).find('[name="medical_note_ar[]]').attr('id', 'medical_note_ar' + (clone_medical_index - 1));
            }
        }
        medical_clone--;
        $('#medicalincrement').val(medical_clone);
    }

    function addMedicalFeeForm(object) {
        var clone_medical_fee_form = object.closest(".clone");
        var clone_medical_form = $(clone_medical_fee_form).parent().closest(".clone");
        var medical_index = $(clone_medical_form).attr('id').replace("medical_clone", "");
        var medical_fee_clone = parseInt($(clone_medical_form).find('[name="medicalfeeincrement[]"]').val());
        medical_fee_clone++;
        var new_clone_form = $(clone_medical_fee_form).clone(true);
        new_clone_form.attr('id', 'medical' + medical_index + '_fee_clone' + medical_fee_clone);
        $(clone_medical_form).find('[name="medicalfeeincrement[]"]').val(medical_fee_clone);

        $(new_clone_form).find('[name="medical_fee_id[' + medical_index + '][]"]').val('');
        $(new_clone_form).find('[name="medical_fees_per_week[' + medical_index + '][]"]').val('');
        $(new_clone_form).find('[name="medical_start_date[' + medical_index + '][]"]').val('');
        $(new_clone_form).find('[name="medical_end_date[' + medical_index + '][]"]').val('');

        new_clone_form.insertAfter($(clone_medical_fee_form));
    }
    
    function deleteMedicalFeeForm(object) {
        var clone_medical_fee_form = object.closest(".clone");
        var clone_medical_form = $(clone_medical_fee_form).parent().closest(".clone");
        var clone_medical_index = parseInt($(clone_medical_form).attr('id').replace("medical_clone", ""));
        var clone_medical_fee_index = parseInt($(clone_medical_fee_form).attr('id').replace("medical" + clone_medical_index + "_fee_clone", ""));

        $(clone_medical_fee_form).remove();

        var medical_fee_forms = $(clone_medical_form).find(".medical-fee-clone");
        for (var medical_fee_index = 0; medical_fee_index < medical_fee_forms.length; medical_fee_index++) {
            var medical_fee_clone_index = parseInt($(medical_fee_forms[medical_fee_index]).attr('id').replace("medical" + clone_medical_index + "_fee_clone", ""));
            if (medical_fee_clone_index >= clone_medical_fee_index) {
                $(medical_fee_forms[medical_fee_index]).attr('id', 'medical' + clone_medical_index + '_fee_clone' + (medical_fee_clone_index - 1));
            }
        }
        var medical_fee_clone = parseInt($(clone_medical_form).find('[name="medicalfeeincrement[]"]').val());
        medical_fee_clone--;
        $(clone_medical_form).find('[name="medicalfeeincrement[]"]').val(medical_fee_clone);
    }

    /*
    * Function for Custodian
    * */
    var custodian_clone = 0;
    function addCustodianForm(object) {
        custodian_clone++;
        var clone_custodian_form = object.closest(".clone");
        var custodian_clone_index = parseInt($(clone_custodian_form).attr('id').replace("custodian_clone", ""));
        $('#custodianincrement').val(custodian_clone);
        var new_clone_form = $(clone_custodian_form).clone(true);
        new_clone_form.attr('id', 'custodian_clone' + (custodian_clone_index + 1));
        $(new_clone_form).find('[name="custodian_id[]"]').val('');
        var clone_custodian_forms = $(".custodian-clone");
        for (var custodian_index = 0; custodian_index < clone_custodian_forms.length; custodian_index++) {
            var clone_custodian_index = parseInt($(clone_custodian_forms[custodian_index]).attr('id').replace("custodian_clone", ""));
            if (clone_custodian_index > custodian_clone_index) {
                $(clone_custodian_forms[custodian_index]).attr('id', 'custodian_clone' + (clone_custodian_index + 1));
                $(clone_custodian_forms[custodian_index]).find('[name="custodian_age_range[' + clone_custodian_index + '][]"]').attr('name', 'custodian_age_range[' + (clone_custodian_index + 1) + '][]');
                $(clone_custodian_forms[custodian_index]).find('[name="custodian_condition[' + clone_custodian_index + '][]"]').attr('name', 'custodian_condition[' + (clone_custodian_index + 1) + '][]');                  
            }
        }

        $(new_clone_form).find('[name="custodian_id[]"]').val('');
        $(new_clone_form).find('[name="custodian_fee[]"]').val('');
        var custodian_age_range_html = $(new_clone_form).find('[name="custodian_age_range[' + custodian_clone_index + '][]"]').html();
        custodian_age_range_html = '<select name="custodian_age_range[' + (custodian_clone_index + 1) + '][]" id="custodian_age_range_choose' + (custodian_clone_index + 1) + '" multiple="multiple" class="3col active">' + custodian_age_range_html + '</select>';
        $(new_clone_form).find('[name="custodian_age_range[' + custodian_clone_index + '][]"]').parent().remove();
        $(new_clone_form).find('.custodian_age_range').append(custodian_age_range_html);
        $(new_clone_form).find('[name="custodian_age_range[' + (custodian_clone_index + 1) + '][]"]').val('');
        $(new_clone_form).find('[name="custodian_age_range[' + (custodian_clone_index + 1) + '][]"]').multiselect({ includeSelectAllOption: true });
        $(new_clone_form).find('[name="custodian_condition[' + custodian_clone_index + ']"]').attr('name', 'custodian_condition[' + (custodian_clone_index + 1) + ']');
        $(new_clone_form).find('[name="custodian_condition[' + (custodian_clone_index + 1) + ']"][value="invisible"]').prop("checked", true);

        new_clone_form.insertAfter($(clone_custodian_form));
    }

    function deleteCustodianForm(object) {
        var clone_custodian_form = object.closest(".clone");
        var custodian_clone_index = parseInt($(clone_custodian_form).attr('id').replace("custodian_clone", ""));
        $(clone_custodian_form).remove();
        var clone_custodian_forms = $(".custodian-clone");
        for (var custodian_index = 0; custodian_index < clone_custodian_forms.length; custodian_index++) {
            var clone_custodian_index = parseInt($(clone_custodian_forms[custodian_index]).attr('id').replace("custodian_clone", ""));
            if (clone_custodian_index > custodian_clone_index) {
                $(clone_custodian_forms[custodian_index]).attr('id', 'custodian_clone' + (clone_custodian_index - 1));
                $(clone_custodian_forms[custodian_index]).find('[name="custodian_age_range[' + clone_custodian_index + '][]"]').attr('name', 'custodian_age_range[' + (clone_custodian_index - 1) + '][]');
                $(clone_custodian_forms[custodian_index]).find('[name="custodian_condition[' + clone_custodian_index + '][]"]').attr('name', 'custodian_condition[' + (clone_custodian_index - 1) + '][]');
            }
        }
        custodian_clone--;
        $('#custodianincrement').val(custodian_clone);
    }

    function toggleAllCheck(table_index, col_index) {
        var table_el = $($('table')[table_index]);
        var header_select_el = $(table_el.find('thead tr[class="filters"] th')[col_index]).find('input[type="checkbox"]');
        var body_row_els = table_el.find('tbody tr');

        for (var row_index = 0; row_index < body_row_els.length; row_index++) {
            if (header_select_el.is(':checked')) {
                if ($($($(body_row_els[row_index]).find('td')[col_index]).find('input[type="checkbox"]')).length) {
                    $($($(body_row_els[row_index]).find('td')[col_index]).find('input[type="checkbox"]')).prop('checked', true);
                }
            } else {
                if ($($($(body_row_els[row_index]).find('td')[col_index]).find('input[type="checkbox"]')).length) {
                    $($($(body_row_els[row_index]).find('td')[col_index]).find('input[type="checkbox"]')).prop('checked', false);
                }
            }
        }
    }
    
    var school_country_clone = 0;
    function addSchoolCountryForm(object) {
        school_country_clone++;
        var clone_country_form = object.closest(".clone");
        var country_clone_index = parseInt($(clone_country_form).attr('id').replace("country_clone", ""));
        $('#country_increment').val(school_country_clone);
        var new_clone_form = $(clone_country_form).clone(true);
        new_clone_form.attr('id', 'country_clone' + (country_clone_index + 1));
        $(new_clone_form).find('[name="city_increment[]"]').val(0);
        $(new_clone_form).find('[name="country_id[]"]').attr('id', 'country_id' + (country_clone_index + 1)).val('');
        var clone_country_forms = $(".country-clone");
        for (var country_index = 0; country_index < clone_country_forms.length; country_index++) {
            var clone_country_index = parseInt($(clone_country_forms[country_index]).attr('id').replace("country_clone", ""));
            if (clone_country_index > country_clone_index) {
                var city_forms = $(clone_country_forms[country_index]).find(".city-clone");
                for (var city_index = 0; city_index < city_forms.length; city_index++) {
                    $(city_forms[city_index]).attr('id', 'city' + (clone_country_index + 1) + '_clone' + city_index);
                }
                $(clone_country_forms[country_index]).attr('id', 'country_clone' + (clone_country_index + 1));
                $(clone_country_forms[country_index]).find('[name="city_name[' + clone_country_index + '][]"]').attr('name', 'city_name[' + (clone_country_index + 1) + '][]');
                $(clone_country_forms[country_index]).find('[name="city_name_ar[' + clone_country_index + '][]"]').attr('name', 'city_name_ar[' + (clone_country_index + 1) + '][]');
            }
        }
        var city_forms = $(new_clone_form).find('.city-clone');
        for (var city_index = 0; city_index < city_forms.length; city_index++) {
            if (city_index == 0) {
                $(city_forms[city_index]).attr('id', 'city' + (country_clone_index + 1) + '_clone0');
                $(city_forms[city_index]).find('[name="city_id[' + country_clone_index + '][]"]').attr('name', 'city_id[' + (country_clone_index + 1) + '][]').attr('id', 'city' + (country_clone_index + 1) + '_id' + city_index);
                $(city_forms[city_index]).find('[name="city_name[' + country_clone_index + '][]"]').attr('name', 'city_name[' + (country_clone_index + 1) + '][]').val('');
                $(city_forms[city_index]).find('[name="city_name_ar[' + country_clone_index + '][]"]').attr('name', 'city_name_ar[' + (country_clone_index + 1) + '][]').val('');
            } else {
                $(city_forms[city_index]).remove();
            }
        }

        $(new_clone_form).find('[name="name[]"]').val('');
        $(new_clone_form).find('[name="name_ar[]"]').val('');
        new_clone_form.insertAfter($(clone_country_form));
    }

    function deleteSchoolCountryForm(object) {
        var clone_country_form = object.closest(".clone");
        var country_clone_index = parseInt($(clone_country_form).attr('id').replace("country_clone", ""));
        $(clone_country_form).remove();
        var clone_country_forms = $(".country-clone");
        for (var country_index = 0; country_index < clone_country_forms.length; country_index++) {
            var clone_country_index = parseInt($(clone_country_forms[country_index]).attr('id').replace("country_clone", ""));
            if (clone_country_index > country_clone_index) {
                $(clone_country_forms[country_index]).attr('id', 'country_clone' + (clone_country_index - 1));
                $(clone_country_forms[country_index]).find('[name="country_id[]"]').attr('id', 'country_id' + (clone_country_index - 1));
                var clone_city_forms = $(clone_country_forms[country_index]).find(".city-clone");
                for (var city_index = 0; city_index < clone_city_forms.length; city_index++) {
                    $(clone_city_forms[city_index]).attr('id', 'city' + (clone_country_index - 1) + '_clone' + city_index);
                    $(clone_city_forms[city_index]).find('[name="city_id[' + clone_country_index + '][]"]').attr('name', 'city_id[' + (clone_country_index - 1) + '][]').attr('id', 'city' + (clone_country_index - 1) + '_id' + city_index);
                    $(clone_city_forms[city_index]).find('[name="city_name[' + clone_country_index + '][]"]').attr('name', 'city_name[' + (clone_country_index - 1) + '][]');
                    $(clone_city_forms[city_index]).find('[name="city_name_ar[' + clone_country_index + '][]"]').attr('name', 'city_name_ar[' + (clone_country_index - 1) + '][]');
                }
            }
        }
        school_country_clone--;
        $('#country_increment').val(school_country_clone);
    }

    function addSchoolCityForm(object) {
        var clone_city_form = object.closest(".clone");
        var clone_country_form = $(clone_city_form).parent().closest(".clone");
        var country_index = $(clone_country_form).attr('id').replace("country_clone", "");
        var city_clone = parseInt($(clone_country_form).find('[name="city_increment[]"]').val());
        city_clone++;
        var new_clone_form = $(clone_city_form).clone(true);
        new_clone_form.attr('id', 'city' + country_index + '_clone' + city_clone);
        $(clone_country_form).find('[name="city_increment[]"]').val(city_clone);

        $(new_clone_form).find('[name="city_id[' + country_index + '][]"]').val('');
        $(new_clone_form).find('[name="city_name[' + country_index + '][]"]').val('');
        $(new_clone_form).find('[name="city_name_ar[' + country_index + '][]"]').val('');

        new_clone_form.insertAfter($(clone_city_form));
    }

    function deleteSchoolCityForm(object) {
        var clone_city_form = object.closest(".clone");
        var clone_country_form = $(clone_city_form).parent().closest(".clone");
        var clone_country_index = parseInt($(clone_country_form).attr('id').replace("country_clone", ""));
        var clone_city_index = parseInt($(clone_city_form).attr('id').replace("city" + clone_country_index + "_clone", ""));

        $(clone_city_form).remove();

        var city_forms = $(clone_country_form).find(".city-clone");
        for (var city_index = 0; city_index < city_forms.length; city_index++) {
            var city_clone_index = parseInt($(city_forms[city_index]).attr('id').replace("city" + clone_country_index + "_clone", ""));
            if (city_clone_index > clone_city_index) {
                $(city_forms[city_index]).attr('id', 'city' + clone_country_index + '_clone' + (city_clone_index - 1));
            }
        }
        var city_clone = parseInt($(clone_country_form).find('[name="city_increment[]"]').val());
        city_clone--;
        $(clone_country_form).find('[name="city_increment[]"]').val(city_clone);
    }
    
    var school_name_clone = 0;
    function addSchoolNameForm(object) {
        school_name_clone++;
        var clone_school_name_form = object.closest(".clone");
        var school_name_clone_index = parseInt($(clone_school_name_form).attr('id').replace("school_name_clone", ""));
        $('#school_name_increment').val(school_name_clone);
        var new_clone_form = $(clone_school_name_form).clone(true);
        new_clone_form.attr('id', 'school_name_clone' + (school_name_clone_index + 1));
        $(new_clone_form).find('[name="school_name_id[]"]').val('');
        var clone_school_name_forms = $(".school-name-clone");
        for (var school_name_index = 0; school_name_index < clone_school_name_forms.length; school_name_index++) {
            var clone_school_name_index = parseInt($(clone_school_name_forms[school_name_index]).attr('id').replace("school_name_clone", ""));
            if (clone_school_name_index > school_name_clone_index) {
                $(clone_school_name_forms[school_name_index]).attr('id', 'school_name_clone' + (clone_school_name_index + 1));
                $(clone_school_name_forms[school_name_index]).find('[name="name[' + clone_school_name_index + '][]"]').attr('name', 'name[' + (clone_school_name_index + 1) + '][]');
                $(clone_school_name_forms[school_name_index]).find('[name="name_ar[' + clone_school_name_index + '][]"]').attr('name', 'name_ar[' + (clone_school_name_index + 1) + '][]');
            }
        }

        $(new_clone_form).find('[name="name[]"]').val('');
        $(new_clone_form).find('[name="name_ar[]"]').val('');
        new_clone_form.insertAfter($(clone_school_name_form));
    }

    function deleteSchoolNameForm(object) {
        var clone_school_name_form = object.closest(".clone");
        var school_name_clone_index = parseInt($(clone_school_name_form).attr('id').replace("school_name_clone", ""));
        $(clone_school_name_form).remove();
        var clone_school_name_forms = $(".school-name-clone");
        for (var school_name_index = 0; school_name_index < clone_school_name_forms.length; school_name_index++) {
            var clone_school_name_index = parseInt($(clone_school_name_forms[school_name_index]).attr('id').replace("school_name_clone", ""));
            if (clone_school_name_index > school_name_clone_index) {
                $(clone_school_name_forms[school_name_index]).attr('id', 'school_name_clone' + (clone_school_name_index - 1));
                $(clone_school_name_forms[school_name_index]).find('[name="school_name_id[' + clone_school_name_index + '][]"]').attr('id', 'school_name_id' + (clone_school_name_index - 1));
            }
        }
        school_name_clone--;
        $('#school_name_increment').val(school_name_clone);
    }
    
    var school_nationality_clone = 0;
    function addSchoolNationalityForm(object) {
        if (school_nationality_clone >= 9) return;
        school_nationality_clone++;
        var clone_nationality_form = object.closest(".clone");
        var nationality_clone_index = parseInt($(clone_nationality_form).attr('id').replace("nationality_clone", ""));
        $('#nationality_increment').val(school_nationality_clone);
        var new_clone_form = $(clone_nationality_form).clone(true);
        new_clone_form.attr('id', 'nationality_clone' + (nationality_clone_index  + 1));
        $(new_clone_form).find('[name="nationality[]"]').val('');
        var clone_nationality_forms = $(".nationality-clone");
        for (var nationality_index = 0; nationality_index < clone_nationality_forms.length; nationality_index++) {
            var clone_nationality_index = parseInt($(clone_nationality_forms[nationality_index]).attr('id').replace("nationality_clone", ""));
            if (clone_nationality_index > nationality_clone_index) {
                $(clone_nationality_forms[nationality_index]).attr('id', 'nationality_clone' + (clone_nationality_index + 1));                
                $(clone_nationality_forms[nationality_index]).find('[name="nationality[]"]').attr('id', 'school_nationality_choose' + (clone_nationality_index + 1));
                $(clone_nationality_forms[nationality_index]).find('[name="nationality_mix[]"]').attr('id', 'nationality_mix' + (clone_nationality_index + 1));
            }
        }

        $(new_clone_form).find('[name="nationality_id[]"]').val('');
        $(new_clone_form).find('[name="nationality[]"]').attr('id', 'school_nationality_choose' + (nationality_clone_index + 1)).val('');
        $(new_clone_form).find('[name="nationality_mix[]"]').attr('id', 'nationality_mix' + (nationality_clone_index + 1)).val('');
        new_clone_form.insertAfter($(clone_nationality_form));
    }

    function deleteSchoolNationalityForm(object) {
        var clone_nationality_form = object.closest(".clone");
        var nationality_clone_index = parseInt($(clone_nationality_form).attr('id').replace("nationality_clone", ""));
        $(clone_nationality_form).remove();
        var clone_nationality_forms = $(".nationality-clone");
        for (var nationality_index = 0; nationality_index < clone_nationality_forms.length; nationality_index++) {
            var clone_nationality_index = parseInt($(clone_nationality_forms[nationality_index]).attr('id').replace("nationality_clone", ""));
            if (clone_nationality_index > nationality_clone_index) {
                $(clone_nationality_forms[nationality_index]).attr('id', 'nationality_clone' + (clone_nationality_index - 1));
                $(clone_nationality_forms[nationality_index]).find('[name="nationality[]"]').attr('id', 'school_nationality_choose' + (clone_nationality_index - 1));
                $(clone_nationality_forms[nationality_index]).find('[name="nationality_mix[]"]').attr('id', 'nationality_mix' + (clone_nationality_index - 1));
            }
        }
        school_nationality_clone--;
        $('#nationality_increment').val(school_nationality_clone);
    }

    function changeSchoolNationality(object) {
        var school_form = object.closest("form");
        var nationality_form = object.closest(".clone");
        var nationality_form_index = parseInt($(nationality_form).attr('id').replace("nationality_clone", ""));
        var nationality_form_option_value = $(nationality_form).find('select[name="nationality[]"]').val();
        var nationality_forms = $(school_form).find(".nationality-clone");
        var nationality_index, clone_nationality_form_index, nationality_form_options, nationality_form_option_index;
        for (nationality_index = 0; nationality_index < nationality_forms.length; nationality_index++) {
            clone_nationality_form_index = parseInt($(nationality_forms[nationality_index]).attr('id').replace("nationality_clone", ""));
            if (nationality_form_index != clone_nationality_form_index) {
                nationality_form_options = $(nationality_forms[nationality_index]).find('select[name="nationality[]"] option');
                for (nationality_form_option_index = 0; nationality_form_option_index < nationality_form_options.length; nationality_form_option_index++) {
                    if (nationality_form_option_value == $(nationality_form_options[nationality_form_option_index]).val()) {
                        $(nationality_form_options[nationality_form_option_index]).hide();
                    }
                }
            }
        }
        var selected_nationality_values = [];
        for (nationality_index = 0; nationality_index < nationality_forms.length; nationality_index++) {
            selected_nationality_values.push($(nationality_forms[nationality_index]).find('select[name="nationality[]"]').val());
        }
        for (nationality_index = 0; nationality_index < nationality_forms.length; nationality_index++) {
            nationality_form_options = $(nationality_forms[nationality_index]).find('select[name="nationality[]"] option');
            for (nationality_form_option_index = 0; nationality_form_option_index < nationality_form_options.length; nationality_form_option_index++) {
                if ($(nationality_form_options[nationality_form_option_index]).val()) {
                    if (selected_nationality_values.includes($(nationality_form_options[nationality_form_option_index]).val())) {
                        $(nationality_form_options[nationality_form_option_index]).hide();
                    } else {
                        $(nationality_form_options[nationality_form_option_index]).show();
                    }
                }
            }
        }
    }

    function changeShcoolNationalityMix(object) {
        var school_form = object.closest("form");
        var nationality_form = object.closest(".clone");
        if ($(nationality_form).find('[name="nationality[]"]').val()) {
            var nationality_mixes = 0;
            var nationality_forms = $(school_form).find(".nationality-clone");
            for (var nationality_index = 0; nationality_index < nationality_forms.length; nationality_index++) {
                if ($(nationality_form).find('[name="nationality[]"]').val()) {
                    nationality_mixes += parseFloat($(nationality_forms[nationality_index]).find('[name="nationality_mix[]"]').val());
                }
            }
            if (nationality_mixes > 100) {
                object.val($(object).val() - nationality_mixes + 100);
            }
        }
    }

    var home_hero_clone = 0;
    function addHomeHero(object) {
        home_hero_clone++;
        var clone_home_hero_form = object.closest(".clone");
        var home_hero_clone_index = parseInt($(clone_home_hero_form).attr('id').replace("home_hero_clone", ""));
        $('#home_hero_increment').val(home_hero_clone);
        var new_clone_form = $(clone_home_hero_form).clone(true);
        new_clone_form.attr('id', 'home_hero_clone' + (home_hero_clone_index  + 1));
        $(new_clone_form).find('[name="home_hero[]"]').val('');
        $(new_clone_form).find('[name="hero_title[]"]').attr('id', 'hero_title' + (home_hero_clone_index + 1));
        $(new_clone_form).find('[name="hero_title[]"]').text('');
        $(new_clone_form).find('#cke_hero_title' + home_hero_clone_index).remove();
        $(new_clone_form).find('[name="hero_title_ar[]"]').attr('id', 'hero_title_ar' + (home_hero_clone_index + 1));
        $(new_clone_form).find('[name="hero_title_ar[]"]').text('');
        $(new_clone_form).find('#cke_hero_title_ar' + home_hero_clone_index).remove();
        $(new_clone_form).find('[name="hero_text[]"]').attr('id', 'hero_text' + (home_hero_clone_index + 1));
        $(new_clone_form).find('[name="hero_text[]"]').text('');
        $(new_clone_form).find('#cke_hero_text' + home_hero_clone_index).remove();
        $(new_clone_form).find('[name="hero_text_ar[]"]').attr('id', 'hero_text_ar' + (home_hero_clone_index + 1));
        $(new_clone_form).find('[name="hero_text_ar[]"]').text('');
        $(new_clone_form).find('#cke_hero_text_ar' + home_hero_clone_index).remove();

        new_clone_form.insertAfter($(clone_home_hero_form));
        
        initCkeditor('hero_title' + (home_hero_clone_index + 1));
        initCkeditor('hero_title_ar' + (home_hero_clone_index + 1));
        initCkeditor('hero_text' + (home_hero_clone_index + 1));
        initCkeditor('hero_text_ar' + (home_hero_clone_index + 1));
    }

    function removeHomeHero(object) {
        var clone_home_hero_form = object.closest(".clone");
        var home_hero_clone_index = parseInt($(clone_home_hero_form).attr('id').replace("home_hero_clone", ""));
        $(clone_home_hero_form).remove();
        var clone_home_hero_forms = $(".home-hero-clone");
        for (var home_hero_index = 0; home_hero_index < clone_home_hero_forms.length; home_hero_index++) {
            var clone_home_hero_index = parseInt($(clone_home_hero_forms[home_hero_index]).attr('id').replace("home_hero_clone", ""));
            if (clone_home_hero_index > home_hero_clone_index) {
                $(clone_home_hero_forms[home_hero_index]).attr('id', 'home_hero_clone' + (clone_home_hero_index - 1));
                $(clone_home_hero_forms[home_hero_index]).find('[name="hero_title[]]').attr('id', 'hero_title' + (clone_home_hero_index - 1));
                $(clone_home_hero_forms[home_hero_index]).find('[name="hero_title_ar[]]').attr('id', 'hero_title_ar' + (clone_home_hero_index - 1));
                $(clone_home_hero_forms[home_hero_index]).find('[name="hero_text[]]').attr('id', 'hero_text' + (clone_home_hero_index - 1));
                $(clone_home_hero_forms[home_hero_index]).find('[name="hero_text_ar[]]').attr('id', 'hero_text_ar' + (clone_home_hero_index - 1));
            }
        }
        school_home_hero_clone--;
        $('#home_hero_increment').val(school_home_hero_clone);
    }

    function toggleSchoolPromotion(object) {
        if (object.is(':checked')) {
            object.parent().find('input[name="school_id[]"]').val(object.data('id'));
        } else {
            object.parent().find('input[name="school_id[]"]').val('');
        }
    }

    function togglePopularCountry(object) {
        if (object.is(':checked')) {
            object.parent().find('input[name="country_id[]"]').val(object.data('id'));
        } else {
            object.parent().find('input[name="country_id[]"]').val('');
        }
    }

    var header_menu_clone = 0;
    function addHeaderMenuForm(object) {
        header_menu_clone++;
        var clone_header_menu_form = object.closest(".clone");
        var header_menu_clone_index = parseInt($(clone_header_menu_form).attr('id').replace("header_menu_clone", ""));
        $('#header_menu_increment').val(header_menu_clone);
        var new_clone_form = $(clone_header_menu_form).clone(true);
        new_clone_form.attr('id', 'header_menu_clone' + (header_menu_clone_index  + 1));
        var clone_header_menu_forms = $(".header-menu-clone");
        for (var header_menu_index = 0; header_menu_index < clone_header_menu_forms.length; header_menu_index++) {
            var clone_header_menu_index = parseInt($(clone_header_menu_forms[header_menu_index]).attr('id').replace("header_menu_clone", ""));
            if (clone_header_menu_index > header_menu_clone_index) {
                var header_menu_sub_forms = $(clone_header_menu_forms[header_menu_index]).find(".header-menu-sub-clone");
                for (var header_menu_sub_index = 0; header_menu_sub_index < header_menu_sub_forms.length; header_menu_sub_index++) {
                    $(header_menu_sub_forms[header_menu_sub_index]).attr('id', 'header_menu' + (clone_header_menu_index + 1) + '_sub_clone' + header_menu_sub_index);
                    $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_type[' + clone_header_menu_index + '][]"]').attr('name', 'header_menu_sub_type[' + (clone_header_menu_index + 1) + '][]');
                    $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_page[' + clone_header_menu_index + '][]"]').attr('name', 'header_menu_sub_page[' + (clone_header_menu_index + 1) + '][]');
                    $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_label[' + clone_header_menu_index + '][]"]').attr('name', 'header_menu_sub_label[' + (clone_header_menu_index + 1) + '][]');
                    $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_label_ar[' + clone_header_menu_index + '][]"]').attr('name', 'header_menu_sub_label_ar[' + (clone_header_menu_index + 1) + '][]');
                }
                $(clone_header_menu_forms[header_menu_index]).attr('id', 'header_menu_clone' + (clone_header_menu_index + 1));
                $(clone_header_menu_forms[header_menu_index]).find('[name="headermenusubincrement[]"]').attr('id', 'header_menu_sub_increment' + (clone_header_menu_index + 1));
            }
        }
        var header_menu_sub_forms = $(new_clone_form).find('.header-menu-sub-clone');
        for (var header_menu_sub_index = 0; header_menu_sub_index < header_menu_sub_forms.length; header_menu_sub_index++) {
            if (header_menu_sub_index == 0) {
                $(header_menu_sub_forms[header_menu_sub_index]).attr('id', 'header_menu' + (header_menu_sub_index + 1) + '_sub_clone0');
                $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_type[' + header_menu_clone_index + '][]"]').attr('name', 'header_menu_sub_type[' + (header_menu_clone_index + 1) + '][]').val('page');
                $(header_menu_sub_forms[header_menu_sub_index]).find('.menu-page-label .menu-page').show();
                $(header_menu_sub_forms[header_menu_sub_index]).find('.menu-page-label .menu-label').hide();
                $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_page[' + header_menu_clone_index + '][]"]').attr('name', 'header_menu_sub_page[' + (header_menu_clone_index + 1) + '][]').val('');
                $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_label[' + header_menu_clone_index + '][]"]').attr('name', 'header_menu_sub_label[' + (header_menu_clone_index + 1) + '][]').val('');
                $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_label_ar[' + header_menu_clone_index + '][]"]').attr('name', 'header_menu_sub_label_ar[' + (header_menu_clone_index + 1) + '][]').val('');
            } else {
                $(header_menu_sub_forms[header_menu_sub_index]).remove();
            }
        }
        
        $(new_clone_form).find('[name="header_menu_type[]"]').val('page');
        $(new_clone_form).find('.menu-page-label .menu-page').show();
        $(new_clone_form).find('.menu-page-label .menu-label').hide();
        $(new_clone_form).find('[name="header_menu_page[]"]').val('');
        $(new_clone_form).find('[name="header_menu_label[]"]').val('');
        $(new_clone_form).find('[name="header_menu_label_ar[]"]').val('');

        new_clone_form.insertAfter($(clone_header_menu_form));
    }

    function removeHeaderMenuForm(object) {
        if (header_menu_clone > 0) {
            var clone_header_menu_form = object.closest(".clone");
            var header_menu_clone_index = parseInt($(clone_header_menu_form).attr('id').replace("header_menu_clone", ""));
            $(clone_header_menu_form).remove();
            var clone_header_menu_forms = $(".header-menu-clone");
            for (var header_menu_index = 0; header_menu_index < clone_header_menu_forms.length; header_menu_index++) {
                var clone_header_menu_index = parseInt($(clone_header_menu_forms[header_menu_index]).attr('id').replace("header_menu_clone", ""));
                if (clone_header_menu_index > header_menu_clone_index) {
                    var header_menu_sub_forms = $(clone_header_menu_forms[header_menu_index]).find(".header-menu-sub-clone");
                    for (var header_menu_sub_index = 0; header_menu_sub_index < header_menu_sub_forms.length; header_menu_sub_index++) {
                        $(header_menu_sub_forms[header_menu_sub_index]).attr('id', 'header_menu' + (clone_header_menu_index - 1) + '_sub_clone' + header_menu_sub_index);
                        $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_type[' + clone_header_menu_index + '][]"]').attr('name', 'header_menu_sub_type[' + (clone_header_menu_index - 1) + '][]');
                        $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_page[' + clone_header_menu_index + '][]"]').attr('name', 'header_menu_sub_page[' + (clone_header_menu_index - 1) + '][]');
                        $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_label[' + clone_header_menu_index + '][]"]').attr('name', 'header_menu_sub_label[' + (clone_header_menu_index - 1) + '][]');
                        $(header_menu_sub_forms[header_menu_sub_index]).find('[name="header_menu_sub_label_ar[' + clone_header_menu_index + '][]"]').attr('name', 'header_menu_sub_label_ar[' + (clone_header_menu_index - 1) + '][]');
                    }
                    $(clone_header_menu_forms[header_menu_index]).attr('id', 'header_menu_clone' + (clone_header_menu_index - 1));
                    $(clone_header_menu_forms[header_menu_index]).find('[name="headermenusubincrement[]"]').attr('id', 'header_menu_sub_increment' + (clone_header_menu_index - 1));
                }
            }
            header_menu_clone--;
            $('#header_menu_increment').val(header_menu_clone);
        }
    }

    function addHeaderMenuSubForm(object) {
        var clone_header_menu_sub_form = object.closest(".clone");
        var clone_header_menu_form = $(clone_header_menu_sub_form).parent().closest(".clone");
        var header_menu_index = $(clone_header_menu_form).attr('id').replace("header_menu_clone", "");
        var header_menu_sub_clone = parseInt($(clone_header_menu_form).find('[name="headermenusubincrement[]"]').val());
        header_menu_sub_clone++;
        var new_clone_form = $(clone_header_menu_sub_form).clone(true);
        new_clone_form.attr('id', 'header_menu' + header_menu_index + '_sub_clone' + header_menu_sub_clone);
        $(clone_header_menu_form).find('[name="headermenusubincrement[]"]').val(header_menu_sub_clone);

        $(new_clone_form).find('[name="header_menu_sub_type[' + header_menu_index + '][]"]').val('page');
        $(new_clone_form).find('.menu-sub-page-label .menu-page').show();
        $(new_clone_form).find('.menu-sub-page-label .menu-label').hide();
        $(new_clone_form).find('[name="header_menu_sub_page[' + header_menu_index + '][]"]').val('');
        $(new_clone_form).find('[name="header_menu_sub_label[' + header_menu_index + '][]"]').val('');
        $(new_clone_form).find('[name="header_menu_sub_label_ar[' + header_menu_index + '][]"]').val('');

        new_clone_form.insertAfter($(clone_header_menu_sub_form));
    }
    
    function deleteHeaderMenuSubForm(object) {
        var clone_header_menu_sub_form = object.closest(".clone");
        var clone_header_menu_form = $(clone_header_menu_sub_form).parent().closest(".clone");
        var clone_header_menu_index = parseInt($(clone_header_menu_form).attr('id').replace("header_menu_clone", ""));
        var clone_header_menu_sub_index = parseInt($(clone_header_menu_sub_form).attr('id').replace("header_menu" + clone_header_menu_index + "_sub_clone", ""));
        var header_menu_sub_clone = parseInt($(clone_header_menu_form).find('[name="headermenusubincrement[]"]').val());

        if (header_menu_sub_clone > 0) {
            $(clone_header_menu_sub_form).remove();

            var header_menu_sub_forms = $(clone_header_menu_form).find(".header-menu-sub-clone");
            for (var header_menu_sub_index = 0; header_menu_sub_index < header_menu_sub_forms.length; header_menu_sub_index++) {
                var header_menu_sub_clone_index = parseInt($(header_menu_sub_forms[header_menu_sub_index]).attr('id').replace("header_menu" + clone_header_menu_index + "_sub_clone", ""));
                if (header_menu_sub_clone_index >= clone_header_menu_sub_index) {
                    $(header_menu_sub_forms[header_menu_sub_index]).attr('id', 'header_menu' + clone_header_menu_index + '_sub_clone' + (header_menu_sub_clone_index - 1));
                }
            }
            header_menu_sub_clone--;
            $(clone_header_menu_form).find('[name="headermenusubincrement[]"]').val(header_menu_sub_clone);
        }
    }

    var footer_menu_section_clone = 0;
    function addFooterMenuSectionForm(object) {
        footer_menu_section_clone++;
        var clone_footer_menu_section_form = object.closest(".clone");
        var footer_menu_section_clone_index = parseInt($(clone_footer_menu_section_form).attr('id').replace("footer_menu_section_clone", ""));
        $('#footer_menu_section_increment').val(footer_menu_section_clone);
        var new_clone_form = $(clone_footer_menu_section_form).clone(true);
        new_clone_form.attr('id', 'footer_menu_section_clone' + (footer_menu_section_clone_index + 1));

        var clone_footer_menu_section_forms = $(".footer-menu-section-clone");
        for (var footer_menu_section_index = 0; footer_menu_section_index < clone_footer_menu_section_forms.length; footer_menu_section_index++) {
            var clone_footer_menu_section_index = parseInt($(clone_footer_menu_section_forms[footer_menu_section_index]).attr('id').replace("footer_menu_section_clone", ""));
            if (clone_footer_menu_section_index > footer_menu_section_clone_index) {
                var footer_menu_forms = $(clone_footer_menu_section_forms[footer_menu_section_index]).find(".footer-menu-clone");
                for (var footer_menu_index = 0; footer_menu_index < footer_menu_forms.length; footer_menu_index++) {
                    $(footer_menu_forms[footer_menu_index]).attr('id', 'footer_menu' + (clone_footer_menu_section_index + 1) + '_clone' + footer_menu_index);
                    $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_type[' + clone_footer_menu_section_index + '][]"]').attr('name', 'footer_menu_type[' + (clone_footer_menu_section_index + 1) + '][]');
                    $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_page[' + clone_footer_menu_section_index + '][]"]').attr('name', 'footer_menu_page[' + (clone_footer_menu_section_index + 1) + '][]');
                    $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_label[' + clone_footer_menu_section_index + '][]"]').attr('name', 'footer_menu_label[' + (clone_footer_menu_section_index + 1) + '][]');
                    $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_label_ar[' + clone_footer_menu_section_index + '][]"]').attr('name', 'footer_menu_label_ar[' + (clone_footer_menu_section_index + 1) + '][]');
                    $(footer_menu_forms[footer_menu_index]).find('#footer_menu' + clone_footer_menu_section_index + '_sub_increment' + footer_menu_index).attr('id', 'footer_menu' + (clone_footer_menu_section_index + 1) + '_sub_increment' + footer_menu_index).attr('name', 'footermenusubincrement[' + (clone_footer_menu_section_index + 1) + '][]');
                    
                    var footer_menu_sub_forms = $(footer_menu_forms[footer_menu_index]).find(".footer-menu-sub-clone");
                    for (var footer_menu_sub_index = 0; footer_menu_sub_index < footer_menu_sub_forms.length; footer_menu_sub_index++) {
                        $(footer_menu_sub_forms[footer_menu_sub_index]).attr('id', 'footer_menu' + (clone_footer_menu_section_index + 1) + '_sub' + footer_menu_index + '_clone' + footer_menu_sub_index);
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_type[' + clone_footer_menu_section_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_type[' + (clone_footer_menu_section_index + 1) + '][' + footer_menu_index + '][]');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_page[' + clone_footer_menu_section_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_page[' + (clone_footer_menu_section_index + 1) + '][' + footer_menu_index + '][]');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label[' + clone_footer_menu_section_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label[' + (clone_footer_menu_section_index + 1) + '][' + footer_menu_index + '][]');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label_ar[' + clone_footer_menu_section_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label_ar[' + (clone_footer_menu_section_index + 1) + '][' + footer_menu_index + '][]');
                    }
                }
                $(clone_footer_menu_section_forms[footer_menu_section_index]).attr('id', 'footer_menu_section_clone' + (clone_footer_menu_section_index + 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('[name="footermenuincrement[]"]').attr('id', 'footer_menu_increment' + (clone_footer_menu_section_index + 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('[name="footer_menu_title[]"]').attr('id', 'footer_menu_title' + (clone_footer_menu_section_index + 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('#cke_footer_menu_title' + clone_footer_menu_section_index).attr('id', 'cke_footer_menu_title' + (clone_footer_menu_section_index + 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('[name="footer_menu_title_ar[]"]').attr('id', 'footer_menu_title_ar' + (clone_footer_menu_section_index + 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('#cke_footer_menu_title_ar' + clone_footer_menu_section_index).attr('id', 'cke_footer_menu_title_ar' + (clone_footer_menu_section_index + 1));
            }
        }

        var footer_menu_forms = $(new_clone_form).find('.footer-menu-clone');
        for (var footer_menu_index = 0; footer_menu_index < footer_menu_forms.length; footer_menu_index++) {
            if (footer_menu_index == 0) {
                $(footer_menu_forms[footer_menu_index]).attr('id', 'footer_menu' + (footer_menu_section_clone_index + 1) + '_clone' + footer_menu_index);
                $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_type[' + footer_menu_section_clone_index + '][]"]').attr('name', 'footer_menu_type[' + (footer_menu_section_clone_index + 1) + '][]').val('page');
                $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_page[' + footer_menu_section_clone_index + '][]"]').attr('name', 'footer_menu_page[' + (footer_menu_section_clone_index + 1) + '][]').val('');
                $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_label[' + footer_menu_section_clone_index + '][]"]').attr('name', 'footer_menu_label[' + (footer_menu_section_clone_index + 1) + '][]').val('');
                $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_label_ar[' + footer_menu_section_clone_index + '][]"]').attr('name', 'footer_menu_label_ar[' + (footer_menu_section_clone_index + 1) + '][]').val('');
                $(footer_menu_forms[footer_menu_index]).find('> .row > .menu-page-label .menu-page').show();
                $(footer_menu_forms[footer_menu_index]).find('> .row > .menu-page-label .menu-label').hide();
                $(footer_menu_forms[footer_menu_index]).find('[name="footermenusubincrement[' + footer_menu_section_clone_index + ']"]').attr('name', 'footermenusubincrement[' + (footer_menu_section_clone_index + 1) + '][]').val(0);
                
                var footer_menu_sub_forms = $(footer_menu_forms[footer_menu_index]).find(".footer-menu-sub-clone");
                for (var footer_menu_sub_index = 0; footer_menu_sub_index < footer_menu_sub_forms.length; footer_menu_sub_index++) {
                    if (footer_menu_sub_index == 0) {
                        $(footer_menu_sub_forms[footer_menu_sub_index]).attr('id', 'footer_menu' + (footer_menu_section_clone_index + 1) + '_sub' + footer_menu_index + '_clone' + footer_menu_sub_index);
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_type[' + footer_menu_section_clone_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_type[' + (footer_menu_section_clone_index + 1) + '][' + footer_menu_index + '][]').val('page');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_page[' + footer_menu_section_clone_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_page[' + (footer_menu_section_clone_index + 1) + '][' + footer_menu_index + '][]').val('');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label[' + footer_menu_section_clone_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label[' + (footer_menu_section_clone_index + 1) + '][' + footer_menu_index + '][]').val('');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label_ar[' + footer_menu_section_clone_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label_ar[' + (footer_menu_section_clone_index + 1) + '][' + footer_menu_index + '][]').val('');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('> .row > .menu-page-label .menu-page').show();
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('> .row > .menu-page-label .menu-label').hide();
                    } else {
                        $(footer_menu_sub_forms[footer_menu_sub_index]).remove();
                    }
                }
            } else {
                $(footer_menu_forms[footer_menu_index]).remove();
            }
        }

        $(new_clone_form).find('[name="footer_menu_title[]"]').attr('id', 'footer_menu_title' + (footer_menu_section_clone_index + 1));
        $(new_clone_form).find('[name="footer_menu_title[]"]').text('');
        $(new_clone_form).find('#cke_footer_menu_title' + footer_menu_section_clone_index).remove();
        $(new_clone_form).find('[name="footer_menu_title_ar[]"]').attr('id', 'footer_menu_title_ar' + (footer_menu_section_clone_index + 1));
        $(new_clone_form).find('[name="footer_menu_title_ar[]"]').text('');
        $(new_clone_form).find('#cke_footer_menu_title_ar' + footer_menu_section_clone_index).remove();
        $(new_clone_form).find('[name="footermenuincrement[]"]').attr('id', 'footer_menu_increment' + (footer_menu_section_clone_index + 1)).val(0);
        new_clone_form.insertAfter($(clone_footer_menu_section_form));

        initCkeditor('footer_menu_title' + (footer_menu_section_clone_index + 1));
        initCkeditor('footer_menu_title_ar' + (footer_menu_section_clone_index + 1));
    }

    function removeFooterMenuSectionForm(object) {
        var clone_footer_menu_section_form = object.closest(".clone");
        var footer_menu_section_clone_index = parseInt($(clone_footer_menu_section_form).attr('id').replace("footer_menu_section_clone", ""));
        $(clone_footer_menu_section_form).remove();
        var clone_footer_menu_section_forms = $(".footer-menu-section-clone");
        for (var footer_menu_section_index = 0; footer_menu_section_index < clone_footer_menu_section_forms.length; footer_menu_section_index++) {
            var clone_footer_menu_section_index = parseInt($(clone_footer_menu_section_forms[footer_menu_section_index]).attr('id').replace("footer_menu_section_clone", ""));
            if (clone_footer_menu_section_index > footer_menu_section_clone_index) {
                var footer_menu_forms = $(clone_footer_menu_section_forms[footer_menu_section_index]).find(".footer-menu-clone");
                for (var footer_menu_index = 0; footer_menu_index < footer_menu_forms.length; footer_menu_index++) {
                    $(footer_menu_forms[footer_menu_index]).attr('id', 'footer_menu' + (clone_footer_menu_section_index - 1) + '_clone' + footer_menu_index);
                    $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_type[' + clone_footer_menu_section_index + '][]"]').attr('name', 'footer_menu_type[' + (clone_footer_menu_section_index - 1) + '][]');
                    $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_page[' + clone_footer_menu_section_index + '][]"]').attr('name', 'footer_menu_page[' + (clone_footer_menu_section_index - 1) + '][]');
                    $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_label[' + clone_footer_menu_section_index + '][]"]').attr('name', 'footer_menu_label[' + (clone_footer_menu_section_index - 1) + '][]');
                    $(footer_menu_forms[footer_menu_index]).find('[name="footer_menu_label_ar[' + clone_footer_menu_section_index + '][]"]').attr('name', 'footer_menu_label_ar[' + (clone_footer_menu_section_index - 1) + '][]');
                    $(footer_menu_forms[footer_menu_index]).find('#footer_menu' + clone_footer_menu_section_index + '_sub_increment' + footer_menu_index).attr('id', 'footer_menu' + (clone_footer_menu_section_index - 1) + '_sub_increment' + footer_menu_index).attr('name', 'footermenusubincrement[' + (clone_footer_menu_section_index - 1) + '][]');
                    
                    var footer_menu_sub_forms = $(footer_menu_forms[footer_menu_index]).find(".footer-menu-sub-clone");
                    for (var footer_menu_sub_index = 0; footer_menu_sub_index < footer_menu_sub_forms.length; footer_menu_sub_index++) {
                        $(footer_menu_sub_forms[footer_menu_sub_index]).attr('id', 'footer_menu' + (clone_footer_menu_section_index - 1) + '_sub' + footer_menu_index + '_clone' + footer_menu_sub_index);
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_type[' + clone_footer_menu_section_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_type[' + (clone_footer_menu_section_index - 1) + '][' + footer_menu_index + '][]');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_page[' + clone_footer_menu_section_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_page[' + (clone_footer_menu_section_index - 1) + '][' + footer_menu_index + '][]');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label[' + clone_footer_menu_section_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label[' + (clone_footer_menu_section_index - 1) + '][' + footer_menu_index + '][]');
                        $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label_ar[' + clone_footer_menu_section_index + '][' + footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label_ar[' + (clone_footer_menu_section_index - 1) + '][' + footer_menu_index + '][]');
                    }
                }
                $(clone_footer_menu_section_forms[footer_menu_section_index]).attr('id', 'footer_menu_section_clone' + (clone_footer_menu_section_index - 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('[name="footermenuincrement[]"]').attr('id', 'footer_menu_increment' + (clone_footer_menu_section_index - 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('[name="footer_menu_title[]"]').attr('id', 'footer_menu_title' + (clone_footer_menu_section_index - 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('#cke_footer_menu_title' + clone_footer_menu_section_index).attr('id', 'cke_footer_menu_title' + (clone_footer_menu_section_index - 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('[name="footer_menu_title_ar[]"]').attr('id', 'footer_menu_title_ar' + (clone_footer_menu_section_index - 1));
                $(clone_footer_menu_section_forms[footer_menu_section_index]).find('#cke_footer_menu_title_ar' + clone_footer_menu_section_index).attr('id', 'cke_footer_menu_title_ar' + (clone_footer_menu_section_index - 1));
            }
        }
        footer_menu_section_clone--;
        $('#footer_menu_section_increment').val(footer_menu_section_clone);
    }

    function addFooterMenuForm(object) {
        var clone_footer_menu_form = object.closest(".clone");
        var footer_menu_section_form = $(clone_footer_menu_form).parent().closest(".clone");
        var footer_menu_clone = parseInt($(footer_menu_section_form).find('[name="footermenuincrement[]"]').val());
        var footer_menu_section_index = parseInt($(footer_menu_section_form).attr('id').replace("footer_menu_section_clone", ""));
        var footer_menu_clone_index = parseInt($(clone_footer_menu_form).attr('id').replace("footer_menu" + footer_menu_section_index + "_clone", ""));
        var new_clone_form = $(clone_footer_menu_form).clone(true);

        var clone_footer_menu_forms = $(footer_menu_section_form).find(".footer-menu-clone");
        for (var footer_menu_index = 0; footer_menu_index < clone_footer_menu_forms.length; footer_menu_index++) {
            var clone_footer_menu_index = parseInt($(clone_footer_menu_forms[footer_menu_index]).attr('id').replace("footer_menu" + footer_menu_section_index + "_clone", ""));
            if (clone_footer_menu_index > footer_menu_clone_index) {
                var footer_menu_sub_forms = $(footer_menu_forms[footer_menu_index]).find(".footer-menu-sub-clone");
                for (var footer_menu_sub_index = 0; footer_menu_sub_index < footer_menu_sub_forms.length; footer_menu_sub_index++) {
                    $(footer_menu_sub_forms[footer_menu_sub_index]).attr('id', 'footer_menu' + footer_menu_section_index + '_sub' + (clone_footer_menu_index + 1) + '_clone' + footer_menu_sub_index);
                    $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_type[' + footer_menu_section_index + '][' + clone_footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_type[' + footer_menu_section_index + '][' + (clone_footer_menu_index + 1) + '][]');
                    $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_page[' + footer_menu_section_index + '][' + clone_footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_page[' + footer_menu_section_index + '][' + (clone_footer_menu_index + 1) + '][]');
                    $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label[' + footer_menu_section_index + '][' + clone_footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label[' + footer_menu_section_index + '][' + (clone_footer_menu_index + 1) + '][]');
                    $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label_ar[' + footer_menu_section_index + '][' + clone_footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label_ar[' + footer_menu_section_index + '][' + (clone_footer_menu_index + 1) + '][]');
                }
                $(clone_footer_menu_forms[footer_menu_index]).attr('id', 'footer_menu' + footer_menu_section_index + '_clone' + (clone_footer_menu_index + 1));
                $(clone_footer_menu_forms[footer_menu_index]).find('[name="footermenusubincrement[' + footer_menu_section_index + ']"]').attr('id', 'footer_menu' + footer_menu_section_index + '_sub_increment' + (clone_footer_menu_index + 1));
            }
        }

        var footer_menu_sub_forms = $(new_clone_form).find(".footer-menu-sub-clone");
        for (var footer_menu_sub_index = 0; footer_menu_sub_index < footer_menu_sub_forms.length; footer_menu_sub_index++) {
            if (footer_menu_sub_index == 0) {
                $(footer_menu_sub_forms[footer_menu_sub_index]).attr('id', 'footer_menu' + footer_menu_section_index + '_sub' + (footer_menu_clone_index + 1) + '_clone' + footer_menu_sub_index);
                $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_type[' + footer_menu_section_index + '][' + footer_menu_clone_index + '][]"]').attr('name', 'footer_menu_sub_type[' + footer_menu_section_index + '][' + (footer_menu_clone_index + 1) + '][]').val('page');
                $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_page[' + footer_menu_section_index + '][' + footer_menu_clone_index + '][]"]').attr('name', 'footer_menu_sub_page[' + footer_menu_section_index + '][' + (footer_menu_clone_index + 1) + '][]').val('');
                $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label[' + footer_menu_section_index + '][' + footer_menu_clone_index + '][]"]').attr('name', 'footer_menu_sub_label[' + footer_menu_section_index + '][' + (footer_menu_clone_index + 1) + '][]').val('');
                $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label_ar[' + footer_menu_section_index + '][' + footer_menu_clone_index + '][]"]').attr('name', 'footer_menu_sub_label_ar[' + footer_menu_section_index + '][' + (footer_menu_clone_index + 1) + '][]').val('');
                $(footer_menu_sub_forms[footer_menu_sub_index]).find('> .row > .menu-page-label .menu-page').show();
                $(footer_menu_sub_forms[footer_menu_sub_index]).find('> .row > .menu-page-label .menu-label').hide();
            } else {
                $(footer_menu_sub_forms[footer_menu_sub_index]).remove();
            }
        }

        new_clone_form.attr('id', 'footer_menu' + footer_menu_section_index + '_clone' + (footer_menu_clone_index + 1));
        $(new_clone_form).find('[name="footermenusubincrement[' + footer_menu_section_index + ']"]').attr('id', 'footer_menu' + footer_menu_section_index + '_sub_increment' + (footer_menu_clone_index + 1)).val(0);
        $(new_clone_form).find('[name="footer_menu_type[' + footer_menu_section_index + '][]"]').val('page');
        $(new_clone_form).find('[name="footer_menu_page[' + footer_menu_section_index + '][]"]').val('');
        $(new_clone_form).find('[name="footer_menu_label[' + footer_menu_section_index + '][]"]').val('');
        $(new_clone_form).find('[name="footer_menu_label_ar[' + footer_menu_section_index + '][]"]').val('');
        $(new_clone_form).find('> .row > .menu-page-label .menu-page').show();
        $(new_clone_form).find('> .row > .menu-page-label .menu-label').hide();
        
        $(footer_menu_section_form).find('[name="footermenuincrement[]"]').val(footer_menu_clone + 1);
        new_clone_form.insertAfter($(clone_footer_menu_form));
    }

    function removeFooterMenuForm(object) {
        var clone_footer_menu_form = object.closest(".clone");
        var footer_menu_section_form = $(clone_footer_menu_form).parent().closest(".clone");
        var footer_menu_clone = parseInt($(footer_menu_section_form).find('[name="footermenuincrement[]"]').val());
        var footer_menu_section_index = parseInt($(footer_menu_section_form).attr('id').replace("footer_menu_section_clone", ""));
        var footer_menu_clone_index = parseInt($(clone_footer_menu_form).attr('id').replace("footer_menu" + footer_menu_section_index + "_clone", ""));
        $(clone_footer_menu_form).remove();
        var footer_menu_forms = $(footer_menu_section_form).find(".footer-menu-clone");
        for (var footer_menu_index = 0; footer_menu_index < footer_menu_forms.length; footer_menu_index++) {
            var clone_footer_menu_index = parseInt($(footer_menu_forms[footer_menu_index]).attr('id').replace("footer_menu" + footer_menu_section_index + "_clone", ""));
            if (clone_footer_menu_index > footer_menu_clone_index) {
                $(footer_menu_forms[footer_menu_index]).attr('id', 'footer_menu' + footer_menu_section_index + '_clone' + (clone_footer_menu_index - 1));
                $(footer_menu_forms[footer_menu_index]).find('#footer_menu' + footer_menu_section_index + '_sub_increment' + clone_footer_menu_index).attr('id', 'footer_menu' + footer_menu_section_index + '_sub_increment' + (clone_footer_menu_index - 1));
                
                var footer_menu_sub_forms = $(footer_menu_forms[footer_menu_index]).find(".footer-menu-sub-clone");
                for (var footer_menu_sub_index = 0; footer_menu_sub_index < footer_menu_sub_forms.length; footer_menu_sub_index++) {
                    $(footer_menu_sub_forms[footer_menu_sub_index]).attr('id', 'footer_menu' + footer_menu_section_index + '_sub' + (clone_footer_menu_index - 1) + '_clone' + footer_menu_sub_index);
                    $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_type[' + footer_menu_section_index + '][' + clone_footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_type[' + footer_menu_section_index + '][' + (clone_footer_menu_index - 1) + '][]');
                    $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_page[' + footer_menu_section_index + '][' + clone_footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_page[' + footer_menu_section_index + '][' + (clone_footer_menu_index - 1) + '][]');
                    $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label[' + footer_menu_section_index + '][' + clone_footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label[' + footer_menu_section_index + '][' + (clone_footer_menu_index - 1) + '][]');
                    $(footer_menu_sub_forms[footer_menu_sub_index]).find('[name="footer_menu_sub_label_ar[' + footer_menu_section_index + '][' + clone_footer_menu_index + '][]"]').attr('name', 'footer_menu_sub_label_ar[' + footer_menu_section_index + '][' + (clone_footer_menu_index - 1) + '][]');
                }
            }
        }
        $(footer_menu_section_form).find('[name="footermenuincrement[]"]').val(footer_menu_clone - 1);
    }

    function addFooterMenuSubForm(object) {
        var clone_footer_menu_sub_form = object.closest(".clone");
        var footer_menu_form = $(clone_footer_menu_sub_form).parent().closest(".clone");
        var footer_menu_section_form = $(footer_menu_form).parent().closest(".clone");
        var footer_menu_section_index = parseInt($(footer_menu_section_form).attr('id').replace("footer_menu_section_clone", ""));
        var footer_menu_sub_clone = parseInt($(footer_menu_form).find('[name="footermenusubincrement[' + footer_menu_section_index + ']"]').val());
        var footer_menu_index = parseInt($(footer_menu_form).attr('id').replace("footer_menu" + footer_menu_section_index + "_clone", ""));
        var footer_menu_sub_clone_index = parseInt($(clone_footer_menu_sub_form).attr('id').replace("footer_menu" + footer_menu_section_index + "_sub" + footer_menu_index + "_clone", ""));
        var new_clone_form = $(clone_footer_menu_sub_form).clone(true);
        
        var clone_footer_menu_sub_forms = $(footer_menu_section_form).find(".footer-menu-sub-clone");
        for (var footer_menu_sub_index = 0; footer_menu_sub_index < clone_footer_menu_sub_forms.length; footer_menu_sub_index++) {
            var clone_footer_menu_sub_index = parseInt($(clone_footer_menu_sub_forms[footer_menu_sub_index]).attr('id').replace("footer_menu" + footer_menu_section_index + "_sub" + footer_menu_index + "_clone", ""));
            if (clone_footer_menu_sub_index > footer_menu_sub_clone_index) {
                $(clone_footer_menu_sub_forms[footer_menu_sub_index]).attr('id', 'footer_menu' + footer_menu_section_index + '_sub' + footer_menu_index + '_clone' + (clone_footer_menu_sub_index + 1));
            }
        }

        new_clone_form.attr('id', 'footer_menu' + footer_menu_section_index + '_sub' + footer_menu_index + '_clone' + (footer_menu_sub_clone_index + 1));
        $(new_clone_form).find('[name="footer_menu_sub_type[' + footer_menu_section_index + '][' + footer_menu_index + '][]"]').val('page');
        $(new_clone_form).find('[name="footer_menu_sub_page[' + footer_menu_section_index + '][' + footer_menu_index + '][]"]').val('');
        $(new_clone_form).find('[name="footer_menu_sub_label[' + footer_menu_section_index + '][' + footer_menu_index + '][]"]').val('');
        $(new_clone_form).find('[name="footer_menu_sub_label_ar[' + footer_menu_section_index + '][' + footer_menu_index + '][]"]').val('');
        $(new_clone_form).find('> .row > .menu-page-label .menu-page').show();
        $(new_clone_form).find('> .row > .menu-page-label .menu-label').hide();

        $(footer_menu_form).find('[name="footermenusubincrement[' + footer_menu_section_index + ']"]').val(footer_menu_sub_clone + 1);
        new_clone_form.insertAfter($(clone_footer_menu_sub_form));
    }
    
    function deleteFooterMenuSubForm(object) {
        var clone_footer_menu_sub_form = object.closest(".clone");
        var footer_menu_form = $(clone_footer_menu_sub_form).parent().closest(".clone");
        var footer_menu_section_form = $(footer_menu_form).parent().closest(".clone");
        var footer_menu_section_index = parseInt($(footer_menu_section_form).attr('id').replace("footer_menu_section_clone", ""));
        var footer_menu_sub_clone = parseInt($(footer_menu_form).find('[name="footermenusubincrement[' + footer_menu_section_index + ']"]').val());
        var footer_menu_index = parseInt($(footer_menu_form).attr('id').replace("footer_menu" + footer_menu_section_index + "_clone", ""));
        var footer_menu_sub_clone_index = parseInt($(clone_footer_menu_sub_form).attr('id').replace("footer_menu" + footer_menu_section_index + "_sub" + footer_menu_index + "_clone", ""));
        $(clone_footer_menu_sub_form).remove();
        var footer_menu_sub_forms = $(footer_menu_form).find(".footer-menu-sub-clone");
        for (var footer_menu_sub_index = 0; footer_menu_sub_index < footer_menu_sub_forms.length; footer_menu_sub_index++) {
            var clone_footer_menu_sub_index = parseInt($(footer_menu_sub_forms[footer_menu_sub_index]).attr('id').replace("footer_menu" + footer_menu_section_index + "_sub" + footer_menu_index + "_clone", ""));
            if (clone_footer_menu_sub_index > footer_menu_sub_clone_index) {
                $(footer_menu_sub_forms[footer_menu_sub_index]).attr('id', 'footer_menu' + footer_menu_section_index + '_sub' + footer_menu_index + '_clone' + (clone_footer_menu_sub_index - 1));
            }
        }
        $(footer_menu_form).find('[name="footermenusubincrement[' + footer_menu_section_index + ']"]').val(footer_menu_sub_clone - 1);
    }
    
    function changeHeaderFooterMenuType(object) {
        if (object.val() == 'page') {
            object.closest('.row').find('.menu-page').show();
            object.closest('.row').find('.menu-label').hide();
        } else {
            object.closest('.row').find('.menu-page').hide();
            object.closest('.row').find('.menu-label').show();
        }
    }

    $('#blog_permission').change(function() {
        if ($('#blog_permission').val() == 'subscriber') {
            $('.blog-permissions').show();
        } else {
            $('.blog-permissions').hide();
        }
    });

    $('#school_permission').change(function() {
        if ($('#school_permission').val() == 'subscriber') {
            $('.school-permissions').show();
        } else {
            $('.school-permissions').hide();
        }
    });

    $('#course_permission').change(function() {
        if ($('#course_permission').val() == 'subscriber') {
            $('.course-permissions').show();
        } else {
            $('.course-permissions').hide();
        }
    });

    $('#currency_permission').change(function() {
        if ($('#currency_permission').val() == 'subscriber') {
            $('.currency-permissions').show();
        } else {
            $('.currency-permissions').hide();
        }
    });

    $('#course_application_permission').change(function() {
        if ($('#course_application_permission').val() == 'subscriber') {
            $('.course-application-permissions').show();
        } else {
            $('.course-application-permissions').hide();
        }
    });

    $('#user_permission').change(function() {
        if ($('#user_permission').val() == 'subscriber') {
            $('.user-permissions').show();
        } else {
            $('.user-permissions').hide();
        }
    });

    $('#review_permission').change(function() {
        if ($('#review_permission').val() == 'subscriber') {
            $('.review-permissions').show();
        } else {
            $('.review-permissions').hide();
        }
    });
    
    $('#enquiry_permission').change(function() {
        if ($('#enquiry_permission').val() == 'subscriber') {
            $('.enquiry-permissions').show();
        } else {
            $('.enquiry-permissions').hide();
        }
    });
    
    $('#form_builder_permission').change(function() {
        if ($('#form_builder_permission').val() == 'subscriber') {
            $('.form-builde-permissions').show();
        } else {
            $('.form-builde-permissions').hide();
        }
    });
    
    $('#visa_application_permission').change(function() {
        if ($('#visa_application_permission').val() == 'subscriber') {
            $('.visa-application-permissions').show();
        } else {
            $('.visa-application-permissions').hide();
        }
    });

    $(document).ready(function () {
        airport_clone = $('#airportincrement').val();
        medical_clone = $('#medicalincrement').val();
        custodian_clone = $('#custodianincrement').val();

        $('select[multiple].active2.3col').multiselect({
            includeSelectAllOption: true
        });
        $('select[multiple].active.3col').multiselect({
            includeSelectAllOption: true
        });

        if ($('table') && $('table').length) {
            for (var table_index = 0; table_index < $('table').length; table_index++) {
                var table_el = $($('table')[table_index]);
                if (!table_el.hasClass('table-no-drawable')) {
                    if (table_el.hasClass('table-filtered') && table_el.find('tbody tr').length) {
                        table_el.find('thead tr').clone(true).addClass('filters').appendTo(table_el.find('thead'));
                        table_el.DataTable({
                            orderCellsTop: true,
                            fixedHeader: true,
                            initComplete: function () {
                                var api = this.api();
                    
                                // For each column
                                api.columns().eq(0).each(function (colIdx) {
                                    // Set the header cell to contain the input element
                                    var cell = $('.filters th').eq(
                                        $(api.column(colIdx).header()).index()
                                    );
                                    var title = $(cell).text();
                                    if (typeof $(cell).data('filter') != 'undefined') {
                                        if ($(cell).data('filter') == 'input') {
                                            $(cell).html('<input type="text" placeholder="' + title + '" />');
                
                                            // On every keypress in this input
                                            $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                                            .off('keyup change')
                                            .on('keyup change', function (e) {
                                                e.stopPropagation();

                                                // Get the search value
                                                $(this).attr('title', $(this).val());
                                                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                                var cursorPosition = this.selectionStart;
                                                // Search the column for that value
                                                api.column(colIdx).search(
                                                    this.value != ''
                                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                        : '',
                                                    this.value != '',
                                                    this.value == ''
                                                ).draw();

                                                $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                                            });
                                        } else if ($(cell).data('filter') == 'select' && typeof $(cell).data('select') != 'undefined' && $(cell).data('select')) {
                                            var select_html = '<select>';
                                            var selects = $(cell).data('select').toString().split(",");
                                            select_html += '<option value=""></option>';
                                            for (var select_index = 0; select_index < selects.length; select_index++) {
                                                select_html += '<option value="' + selects[select_index] + '">' + selects[select_index] + '</option>';
                                            }
                                            select_html += '</select>';
                                            $(cell).html(select_html);

                                            // On every keypress in this input
                                            $('select', $('.filters th').eq($(api.column(colIdx).header()).index()))
                                            .off('change')
                                            .on('change', function (e) {
                                                e.stopPropagation();

                                                // Get the search value
                                                $(this).attr('title', $(this).val());
                                                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                                var cursorPosition = this.selectionStart;
                                                // Search the column for that value
                                                api.column(colIdx).search(
                                                    this.value != ''
                                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                                        : '',
                                                    this.value != '',
                                                    this.value == ''
                                                ).draw();
                                            });
                                        } else if ($(cell).data('filter') == 'checkbox') {
                                            $(cell).html('<input type="checkbox" onclick="toggleAllCheck(' + table_index + ', ' + colIdx + ')"/>');
                                        } else {
                                            $(cell).html('<p></p>');
                                        }
                                    } else {
                                        $(cell).html('<p></p>');
                                    }
                                });
                            },
                            lengthMenu: table_el.data('length') ? [
                                table_el.data('length').split(":")[0].split(","),
                                table_el.data('length').split(":")[1].split(","),
                            ] : [
                                [10, 25, 50, 100, -1],
                                [10, 25, 50, 100, 'All']
                            ]
                        });
                    } else {
                        if (table_el.data('length')) {
                            table_el.DataTable({
                                lengthMenu: [
                                    table_el.data('length').split(":")[0].split(","),
                                    table_el.data('length').split(":")[1].split(","),
                                ]
                            });
                        } else {
                            table_el.DataTable();
                        }
                    }
                }
            }
        }

        $('#menu ul li a').click(function (ev) {
            $('#menu ul li').removeClass('selected');
            $(ev.currentTarget).parent('li').addClass('selected');
        });
        $("#myTags").tagit({
            fieldName: "video_url[]"
        });

        /*
        * Clone program form
        * */
        $("#clone_program_form" + formnum).find('.btn-primary').click(function () {
        });

        @if (app()->getLocale() == 'en')
            $('.arabic').hide();
        @else
            $('.english').hide();
        @endif

        if ($('.page-body-wrapper .content-wrapper').length) {
            handleResizePageContent();
        }
    });

    function handleResizePageContent() {
        $('.page-body-wrapper .content-wrapper .page-content').css('margin-top', ($('.page-body-wrapper .content-wrapper .page-header').outerHeight() + 15) + 'px');
    }

    function DoBulkAction() {
        var bulk_ids = [];
        $("table tr td input[type='checkbox']").each(function() {
            if ($(this).is(':checked')) {
                bulk_ids.push($(this).data("id"));
            }
        });
        $("input[name='ids']").val(bulk_ids.join(","));
        return true;
    }

    function generateSlug(title) {
        return title.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, "") //remove diacritics
            .toLowerCase()
            .replace(/\s+/g, '-') //spaces to dashes
            .replace(/&/g, '-and-') //ampersand to and
            .replace(/[^\w\-]+/g, '') //remove non-words
            .replace(/\-\-+/g, '-') //collapse multiple dashes
            .replace(/^-+/, '') //trim starting dash
            .replace(/-+$/, ''); //trim ending dash
    }

    /*
    * Add and remove editor on click event
    * */
    if (typeof (tinymce) !== "undefined") {
        tinymceInit();
    }
</script>
<!-- End custom js for this page -->
@yield('js')