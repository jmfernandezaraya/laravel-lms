@section('js')
    <script>        
        var course_list_page = "{{route('superadmin.course.index')}}";
        var course_url_store = "{{route('superadmin.course.store')}}";

        var program_under_age_url = "{{route('superadmin.course.program_under_age')}}";
        var edit_program_under_age_url = "{{route('superadmin.course.program_under_age.edit')}}";  
        var accommodation_url = "{{route('superadmin.course.accommodation')}}";
        var edit_accommodation_url = "{{route('superadmin.course.accommodation.edit')}}";
        var accomm_under_age_url = "{{route('superadmin.course.accomm_under_age')}}";
        var edit_accomm_under_age_url = "{{route('superadmin.course.accomm_under_age.edit')}}";

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

        var url_school_country_list = "{{route('superadmin.school.country.list')}}";
        var url_school_city_list = "{{route('superadmin.school.city.list')}}";
        var url_school_branch_list = "{{route('superadmin.school.branch.list')}}";
        var select_option = "{{__('SuperAdmin/backend.select_option')}}";
        var search = "{{__('SuperAdmin/backend.search')}}";

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
        * program text field clone function
        *
        * */
        $('#clone_program_text_book_fee' + (textbooknum - 1)).find('.fa-plus-circle').click(function () {
            textbooknum++;

            $($(this).parent().parent()).find('#textbookfeeincrement').attr('value', textbooknum);
            var copied = $($(this).parent().parent()).clone(true);
            copied.insertAfter($(this).parent().parent());
        });

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

        var course_program_clone = 0;
        function addCourseProgram(object) {
            course_program_clone++;
            var clone_course_program_form = object.closest(".clone");

            var course_program_index = $(clone_course_program_form).attr('id').replace("course_program_clone", "");

            var new_clone_form = $(clone_course_program_form).clone(true);
            new_clone_form.attr('id', 'course_program_clone' + course_program_clone);
            $('#program_increment').val(course_program_clone);

            var course_program_id = ((new Date()).getTime()).toString();
            $(new_clone_form).find('[name="program_id[]"]').val(course_program_id);
            $(new_clone_form).find('[name="program_id[]"]').attr('id', 'program_id' + course_program_clone);

            $(new_clone_form).find('[name="program_registration_fee[]"]').val('');
            $(new_clone_form).find('[name="program_duration[]"]').val('');
            $(new_clone_form).find('[name="deposit[]"]').val('');
            var age_range_html = $(new_clone_form).find('[name="age_range[' + course_program_index + '][]"]').html();
            age_range_html = '<select name="age_range[' + course_program_clone + '][]" id="program_age_range_choose' + course_program_clone + '" multiple="multiple" class="3col active">' + age_range_html + '</select>';
            $(new_clone_form).find('[name="age_range[' + course_program_index + '][]"]').parent().remove();
            $(new_clone_form).find('.age_range').append(age_range_html);
            $(new_clone_form).find('[name="age_range[' + course_program_clone + '][]"]').val('');
            $(new_clone_form).find('[name="age_range[' + course_program_clone + '][]"]').multiselect({ includeSelectAllOption: true });
            $(new_clone_form).find('[name="courier_fee[]"]').val('');
            $(new_clone_form).find('#about_courier' + course_program_index).attr('id', 'about_courier' + course_program_clone);
            $(new_clone_form).find('#about_courier' + course_program_clone).text('');
            $(new_clone_form).find('[name="about_courier[]"]').attr('id', 'about_courier' + course_program_clone);
            $(new_clone_form).find('[name="about_courier[]"]').text('');
            $(new_clone_form).find('[name="about_courier_ar[]"]').attr('id', 'about_courier_ar' + course_program_clone);
            $(new_clone_form).find('[name="about_courier_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();
            $(new_clone_form).find('[name="program_cost[]"]').val('');
            $(new_clone_form).find('[name="program_duration_start[]"]').val('');
            $(new_clone_form).find('[name="program_duration_end[]"]').val('');
            $(new_clone_form).find('[name="program_start_date[]"]').val('');
            $(new_clone_form).find('[name="program_end_date[]"]').val('');
            $(new_clone_form).find('[name="available_date[]"]').val('');
            $(new_clone_form).find('[name="select_day_week[]"]').val('Monday');
            $(new_clone_form).find('[name="available_days[]"]').val('');
            $(new_clone_form).find('[name="available_days[]"]').data('index', course_program_clone);
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

            tinymce.init({ selector: '#about_courier' + course_program_clone });
            tinymce.get('about_courier' + course_program_clone).show();
            tinymce.init({ selector: '#about_courier_ar' + course_program_clone });
            tinymce.get('about_courier_ar' + course_program_clone).show();
        }

        /*
        * function for removing program cost
        * */
        function removeCourseProgram(object) {
            var clone_course_program_form = object.closest(".clone");
            $(clone_course_program_form).remove();
            var clone_course_program_forms = $(".course-program-clone");
            for (var course_program_index = 0; course_program_index < clone_course_program_forms.length; course_program_index++) {
                var clone_course_program_index = parseInt($(clone_course_program_forms[course_program_index]).attr('id').replace("course_program_clone", ""));
                if (clone_course_program_index >= course_program_clone) {
                    $(clone_course_program_forms[clone_course_program_index]).attr('id', 'course_program_clone' + clone_course_program_index - 1);
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
        }

        function getCourseProgramContents() {
            if (typeof (tinymce) !== 'undefined') {
                var program_information = $('[name="program_information"]');
                if (tinymce.get('program_information')) {
                    var program_information_content = tinymce.get('program_information').getContent();
                    program_information.text(program_information_content);
                }
                var program_information = $('[name="program_information_ar"]');
                if (tinymce.get('program_information_ar')) {
                    var program_information_content = tinymce.get('program_information_ar').getContent();
                    program_information.text(program_information_content);
                }
                var about_couriers = $('[name="about_courier[]"]');
                for (var about_courier_index = 0; about_courier_index < about_couriers.length; about_courier_index++) {
                    var about_courier_id = $(about_couriers[about_courier_index]).attr('id');
                    if (tinymce.get(about_courier_id)) {
                        var about_courier_content = tinymce.get(about_courier_id).getContent();
                        $(about_couriers[about_courier_index]).text(about_courier_content);
                    }
                }
                var about_couriers = $('[name="about_courier_ar[]"]');
                for (var about_courier_index = 0; about_courier_index < about_couriers.length; about_courier_index++) {
                    var about_courier_id = $(about_couriers[about_courier_index]).attr('id');
                    if (tinymce.get(about_courier_id)) {
                        var about_courier_content = tinymce.get(about_courier_id).getContent();
                        $(about_couriers[about_courier_index]).text(about_courier_content);
                    }
                }
            }
        }

        var program_under_age_clone = 0;
        function addProgramUnderAgeFee(object) {
            program_under_age_clone++;
            var clone_program_under_age_form = object.closest(".clone");
            var program_under_age_index = $(clone_program_under_age_form).attr('id').replace("under_age_fee_clone", "");
            $('#underagefeeincrement').val(program_under_age_clone);
            var new_clone_form = $(clone_program_under_age_form).clone(true);
            new_clone_form.attr('id', 'under_age_fee_clone' + program_under_age_clone);
            $(new_clone_form).find('[name="under_age_id[]"]').val('');
            var under_age_html = $(new_clone_form).find('[name="under_age[' + program_under_age_index + '][]"]').html();
            under_age_html = '<select name="under_age[' + program_under_age_clone + '][]" id="program_under_age_range_choose' + program_under_age_clone + '" multiple="multiple" class="3col active">' + under_age_html + '</select>';
            $(new_clone_form).find('[name="under_age[' + program_under_age_index + '][]"]').parent().remove();
            $(new_clone_form).find('.under_age').append(under_age_html);
            $(new_clone_form).find('[name="under_age[' + program_under_age_clone + '][]"]').val('');
            $(new_clone_form).find('[name="under_age[' + program_under_age_clone + '][]"]').multiselect({ includeSelectAllOption: true });
            $(new_clone_form).find('[name="under_age_fee_per_week[]"]').val('');

            new_clone_form.insertAfter($(clone_program_under_age_form));
        }

        function removeProgramUnderAgeFee(object) {
            var clone_course_program_under_age_form = object.closest(".clone");
            $(clone_course_program_under_age_form).remove();
            var clone_course_program_under_age_forms = $(".under-age-fee-clone");
            for (var course_program_under_age_index = 0; course_program_under_age_index < clone_course_program_under_age_forms.length; course_program_under_age_index++) {
                var clone_course_program_under_age_index = parseInt($(clone_course_program_under_age_forms[course_program_index]).attr('id').replace("under_age_fee_clone", ""));
                if (clone_course_program_under_age_index >= program_under_age_clone) {
                    $(clone_course_program_under_age_forms[course_program_under_age_index]).attr('id', 'under_age_fee_clone' + clone_course_program_under_age_index - 1);
                    $(clone_course_program_under_age_forms[course_program_under_age_index]).find('[name="under_age[' + clone_course_program_under_age_index + '][]"]')
                        .attr('id', 'program_under_age_range_choose' + (clone_course_program_under_age_index - 1))
                        .attr('name', 'under_age[' + (clone_course_program_under_age_index - 1) + '][]');
                }
            }
            program_under_age_clone--;
            $('#underagefeeincrement').val(program_under_age_clone);
        }

        
        var program_text_book_clone = 0;
        function addTextBookFee(object) {
            program_text_book_clone++;
            var clone_program_text_book_form = object.closest(".clone");
            var program_text_book_index = $(clone_program_text_book_form).attr('id').replace("text_book_fee_clone", "");
            $('#textbookfeeincrement').val(program_text_book_clone);
            var new_clone_form = $(clone_program_text_book_form).clone(true);
            new_clone_form.attr('id', 'text_book_fee_clone' + medical_clone);
            $(new_clone_form).find('[name="textbook_id[]"]').val('');
            $(new_clone_form).find('[name="text_book_fee[]"]').val('');
            $(new_clone_form).find('[name="text_book_fee_start_date[]"]').val('');
            $(new_clone_form).find('[name="text_book_fee_end_date[]"]').val('');
            $(new_clone_form).find('[name="text_book_note[]"]').attr('id', 'text_book_note' + program_text_book_clone);
            $(new_clone_form).find('[name="text_book_note[]"]').text('');
            $(new_clone_form).find('[name="text_book_note_ar[]"]').attr('id', 'text_book_note_ar' + program_text_book_clone);
            $(new_clone_form).find('[name="text_book_note_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();

            new_clone_form.insertAfter($(clone_program_text_book_form));

            tinymce.init({ selector: '#text_book_note' + program_text_book_clone });
            tinymce.get('text_book_note' + program_text_book_clone).show();
            tinymce.init({ selector: '#text_book_note_ar' + program_text_book_clone });
            tinymce.get('text_book_note_ar' + program_text_book_clone).show();
        }

        function removeTextBookFee(object) {
            var clone_course_program_text_book_form = object.closest(".clone");
            $(clone_course_program_text_book_form).remove();
            var clone_course_program_text_book_forms = $(".text-book-fee-clone");
            for (var course_program_text_book_index = 0; course_program_text_book_index < clone_course_program_text_book_forms.length; course_program_text_book_index++) {
                var clone_course_program_text_book_index = parseInt($(clone_course_program_text_book_forms[course_program_index]).attr('id').replace("text_book_fee_clone", ""));
                if (clone_course_program_text_book_index >= program_text_book_clone) {
                    $(clone_course_program_text_book_forms[course_program_text_book_index]).attr('id', 'text_book_fee_clone' + clone_course_program_text_book_index - 1);
                    $(clone_course_program_text_book_forms[course_program_text_book_index]).find('[name="text_book_note[]"]').attr('id', 'text_book_note' + (clone_course_program_text_book_index - 1));
                    $(clone_course_program_text_book_forms[course_program_text_book_index]).find('[name="text_book_note_ar[]"]').attr('id', 'text_book_note_ar' + (clone_course_program_text_book_index - 1));
                }
            }
            program_text_book_clone--;
            $('#textbookfeeincrement').val(program_text_book_clone);
        }

        function getProgramTextBookContents() {
            if (typeof (tinymce) !== 'undefined') {
                var program_text_book_notes = $('[name="text_book_note[]"]');
                for (var program_text_book_note_index = 0; program_text_book_note_index < program_text_book_notes.length; program_text_book_note_index++) {
                    var program_text_book_note_id = $(program_text_book_notes[program_text_book_note_index]).attr('id');
                    if (tinymce.get(program_text_book_note_id)) {
                        var program_text_book_note_content = tinymce.get(program_text_book_note_id).getContent();
                        $(program_text_book_notes[program_text_book_note_index]).text(program_text_book_note_content);
                    }
                }
                var program_text_book_notes = $('[name="text_book_note_ar[]"]');
                for (var program_text_book_note_index = 0; program_text_book_note_index < program_text_book_notes.length; program_text_book_note_index++) {
                    var program_text_book_note_id = $(program_text_book_notes[program_text_book_note_index]).attr('id');
                    if (tinymce.get(program_text_book_note_id)) {
                        var program_text_book_note_content = tinymce.get(program_text_book_note_id).getContent();
                        $(program_text_book_notes[program_text_book_note_index]).text(program_text_book_note_content);
                    }
                }
            }
        }

        /*
        * function for Accommodation
        * */
        var accommodation_clone = 0;
        function addAccommodation(object) {
            accommodation_clone++;
            var clone_accommodation_form = object.closest(".clone");
            var accommodation_index = $(clone_accommodation_form).attr('id').replace("accommodation_clone", "");

            var new_clone_form = $(clone_accommodation_form).clone(true);
            new_clone_form.attr('id', 'accommodation_clone' + accommodation_clone);

            var accommodation_id = ((new Date()).getTime()).toString();
            $(new_clone_form).find('[name="accommodation_id[]"]').val(accommodation_id);
            $(new_clone_form).find('[name="type[]"]').val('');
            $(new_clone_form).find('[name="room_type[]"]').val('');
            $(new_clone_form).find('[name="meal[]"]').val('');
            var age_range_html = $(new_clone_form).find('[name="age_range[' + accommodation_index + '][]"]').html();
            age_range_html = '<select name="age_range[' + accommodation_clone + '][]" id="accom_age_choose' + accommodation_clone + '" multiple="multiple" class="3col active">' + age_range_html + '</select>';
            $(new_clone_form).find('[name="age_range[' + accommodation_index + '][]"]').parent().remove();
            $(new_clone_form).find('.age_range').append(age_range_html);
            $(new_clone_form).find('[name="age_range[' + accommodation_clone + '][]"]').val('');
            $(new_clone_form).find('[name="age_range[' + accommodation_clone + '][]"]').multiselect({ includeSelectAllOption: true });
            $(new_clone_form).find('[name="placement_fee[]"]').val('');
            $(new_clone_form).find('[name="program_duration[]"]').val('');
            $(new_clone_form).find('[name="deposit_fee[]"]').val('');
            $(new_clone_form).find('[name="custodian_fee[][]"]').val('');
            var age_range_for_custodian_html = $(new_clone_form).find('[name="age_range_for_custodian[' + accommodation_index + '][]"]').html();
            age_range_for_custodian_html = '<select name="age_range_for_custodian[' + accommodation_clone + '][]" id="custodian_age_range_choose' + accommodation_clone + '" multiple="multiple" class="3col active">' + age_range_for_custodian_html + '</select>';
            $(new_clone_form).find('[name="age_range_for_custodian[' + accommodation_index + '][]"]').parent().remove();
            $(new_clone_form).find('.age_range_for_custodian').append(age_range_for_custodian_html);
            $(new_clone_form).find('[name="age_range_for_custodian[' + accommodation_clone + '][]"]').val('');
            $(new_clone_form).find('[name="age_range_for_custodian[' + accommodation_clone + '][]"]').multiselect({ includeSelectAllOption: true });
            $(new_clone_form).find('[name="custodian_condition[' + accommodation_index + ']"]').attr('name', 'custodian_condition[' + accommodation_clone + ']');
            $(new_clone_form).find('[name="special_diet_note[]"]').attr('id', 'special_diet_note' + accommodation_clone);
            $(new_clone_form).find('[name="special_diet_note[]"]').text('');
            $(new_clone_form).find('[name="special_diet_note_ar[]"]').attr('id', 'special_diet_note_ar' + accommodation_clone);
            $(new_clone_form).find('[name="special_diet_note_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();
            $(new_clone_form).find('[name="fee_per_week[]"]').val('');
            $(new_clone_form).find('[name="start_week[]"]').val('');
            $(new_clone_form).find('[name="end_week[]"]').val('');
            $(new_clone_form).find('[name="start_date[]"]').val('');
            $(new_clone_form).find('[name="end_date[]"]').val('');
            $(new_clone_form).find('[name="available_days[]"]').val('');
            $(new_clone_form).find('[name="available_days[]"]').data('index', accommodation_clone);
            yeardatepicker_days.push([]);
            yeardatepicker_months.push([]);
            $(new_clone_form).find('[name="discount_per_week[]"]').val('');
            $(new_clone_form).find('[name="discount_per_week_symbol[]"]').val('');
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
            $(new_clone_form).find('[name="how_many_week_free[]"]').val('');
            $(new_clone_form).find('[name="x_week_start_date[]"]').val('');
            $(new_clone_form).find('[name="x_week_end_date[]"]').val('');

            new_clone_form.insertAfter($(clone_accommodation_form));

            tinymce.init({ selector: '#special_diet_note' + accommodation_clone });
            tinymce.get('special_diet_note' + accommodation_clone).show();
            tinymce.init({ selector: '#special_diet_note_ar' + accommodation_clone });
            tinymce.get('special_diet_note_ar' + accommodation_clone).show();
        }

        function deleteAccommodation(object) {
            var clone_accommodation_form = object.closest(".clone");
            $(clone_accommodation_form).remove();
            var clone_accommodation_forms = $(".accommodation-clone");
            for (var accommodation_index = 0; accommodation_index < clone_accommodation_forms.length; accommodation_index++) {
                var clone_accommodation_index = parseInt($(clone_accommodation_forms[accommodation_index]).attr('id').replace("accommodation_clone", ""));
                if (clone_accommodation_index >= accommodation_clone) {
                    $(clone_accommodation_forms[accommodation_index]).attr('id', 'accommodation_clone' + clone_accommodation_index - 1);
                    $(clone_accommodation_forms[accommodation_index]).find('[name="age_range[' + clone_accommodation_index + '][]"]').attr('name', 'age_range[' + (clone_accommodation_index - 1) + '][]');
                    $(clone_accommodation_forms[accommodation_index]).find('[name="age_range_for_custodian[' + clone_accommodation_index + '][]"]').attr('name', 'age_range_for_custodian[' + (clone_accommodation_index - 1) + '][]');
                    $(clone_accommodation_forms[accommodation_index]).find('[name="custodian_condition[' + clone_accommodation_index + ']"]').attr('name', 'custodian_condition[' + (clone_accommodation_index - 1) + ']');
                    $(clone_accommodation_forms[accommodation_index]).find('[name="available_days[]"]').data('index', clone_accommodation_index - 1);
                    yeardatepicker_days.splice(clone_accommodation_index, 1);
                    yeardatepicker_months.splice(clone_accommodation_index, 1);

                    $(clone_accommodation_forms[accommodation_index]).find('[name="special_diet_note[]]').attr('id', 'special_diet_note' + (clone_accommodation_index - 1));
                    $(clone_accommodation_forms[accommodation_index]).find('[name="special_diet_note_ar[]]').attr('id', 'special_diet_note_ar' + (clone_accommodation_index - 1));
                }
            }
            accommodation_clone--;
        }

        function getAccommodationContents() {
            if (typeof (tinymce) !== 'undefined') {
                var special_diet_notes = $('[name="special_diet_note[]"]');
                for (var special_diet_note_index = 0; special_diet_note_index < special_diet_notes.length; special_diet_note_index++) {
                    var special_diet_note_id = $(special_diet_notes[special_diet_note_index]).attr('id');
                    if (tinymce.get(special_diet_note_id)) {
                        var special_diet_note_content = tinymce.get(special_diet_note_index).getContent();
                        $(special_diet_notes[special_diet_note_index]).text(special_diet_note_content);
                    }
                }
                var special_diet_notes = $('[name="special_diet_note_ar[]"]');
                for (var special_diet_note_index = 0; special_diet_note_index < special_diet_notes.length; special_diet_note_index++) {
                    var special_diet_note_id = $(special_diet_notes[special_diet_note_index]).attr('id');
                    if (tinymce.get(special_diet_note_id)) {
                        var special_diet_note_content = tinymce.get(special_diet_note_index).getContent();
                        $(special_diet_notes[special_diet_note_index]).text(special_diet_note_content);
                    }
                }
            }
        }

        var accommodation_under_age_clone = 0;
        function addAccommodationFormUnderAge(object) {
            accommodation_under_age_clone++;
            var clone_accommodation_under_age_form = object.closest(".clone");
            var accommodation_under_age_index = $(clone_accommodation_under_age_form).attr('id').replace("accommodation_under_age_clone", "");
            $('#accomunderageincrement').val(accommodation_under_age_clone);
            var new_clone_form = $(clone_accommodation_under_age_form).clone(true);
            new_clone_form.attr('id', 'accommodation_under_age_clone' + accommodation_under_age_clone);
            $(new_clone_form).find('[name="accom_under_age_id[]"]').val('');

            var under_age_html = $(new_clone_form).find('[name="under_age[' + accommodation_under_age_index + '][]"]').html();
            under_age_html = '<select name="under_age[' + accommodation_under_age_clone + '][]" id="under_age_choose' + accommodation_under_age_clone + '" multiple="multiple" class="3col active">' + under_age_html + '</select>';
            $(new_clone_form).find('[name="under_age[' + accommodation_under_age_index + '][]"]').parent().remove();
            $(new_clone_form).find('.under_age').append(under_age_html);
            $(new_clone_form).find('[name="under_age[' + accommodation_under_age_clone + '][]"]').val('');
            $(new_clone_form).find('[name="under_age[' + accommodation_under_age_clone + '][]"]').multiselect({ includeSelectAllOption: true });
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
        * function for Airport
        * */
        var airport_clone = 0;
        function addAirportForm(object) {
            airport_clone++;
            var clone_airport_form = object.closest(".clone");
            var airport_index = $(clone_airport_form).attr('id').replace("airport_clone", "");
            $('#airportincrement').val(airport_clone);
            var new_clone_form = $(clone_airport_form).clone(true);
            new_clone_form.attr('id', 'airport_clone' + airport_clone);
            $(new_clone_form).find('[name="airportfeeincrement[]"]').val(0);
            $(new_clone_form).find('[name="airport_id[]"]').val('');
            var airport_fees = $(new_clone_form).find('.airport-fee-clone');
            for (var airport_fee_index = 0; airport_fee_index < airport_fees.length; airport_fee_index++) {
                if (airport_fee_index == 0) {
                    $(airport_fees[airport_fee_index]).attr('id', 'airport' + airport_clone + '_fee_clone0');
                    $(airport_fees[airport_fee_index]).find('[name="airport_fee_id[' + airport_index + '][]"]').attr('name', 'airport_fee_id[' + airport_clone + '][]').val('');
                    $(airport_fees[airport_fee_index]).find('[name="airport_name[' + airport_index + '][]"]').attr('name', 'airport_name[' + airport_clone + '][]').val('');
                    $(airport_fees[airport_fee_index]).find('[name="airport_service_name[' + airport_index + '][]"]').attr('name', 'airport_service_name[' + airport_clone + '][]').val('');
                    $(airport_fees[airport_fee_index]).find('[name="airport_service_fee[' + airport_index + '][]"]').attr('name', 'airport_service_fee[' + airport_clone + '][]').val('');
                } else {
                    $(airport_fees[airport_fee_index]).remove();
                }
            }

            $(new_clone_form).find('[name="airport_service_provider[]"]').val('');
            $(new_clone_form).find('[name="airport_week_selected_fee[]"]').val('');
            $(new_clone_form).find('[name="airport_note[]"]').attr('id', 'airport_note' + airport_clone);
            $(new_clone_form).find('[name="airport_note[]"]').text('');
            $(new_clone_form).find('[name="airport_note_ar[]"]').attr('id', 'airport_note_ar' + airport_clone);
            $(new_clone_form).find('[name="airport_note_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();
            new_clone_form.insertAfter($(clone_airport_form));

            tinymce.init({ selector: '#airport_note' + airport_clone });
            tinymce.get('airport_note' + airport_clone).show();
            tinymce.init({ selector: '#airport_note_ar' + airport_clone });
            tinymce.get('airport_note_ar' + airport_clone).show();
        }
        
        function deleteAirportForm(object) {
            var clone_airport_form = object.closest(".clone");
            $(clone_airport_form).remove();
            var clone_airport_forms = $(".airport-clone");
            for (var airport_index = 0; airport_index < clone_airport_forms.length; airport_index++) {
                var clone_airport_index = parseInt($(clone_airport_forms[airport_index]).attr('id').replace("airport_clone", ""));
                if (clone_airport_index >= airport_clone) {
                    $(clone_airport_forms[airport_index]).attr('id', 'airport_clone' + clone_airport_index - 1);
                    $(clone_airport_forms[airport_index]).find('[name="airport_fee_id[' + clone_airport_index + '][]"]').attr('name', 'airport_fee_id[' + (clone_airport_index - 1) + '][]');
                    $(clone_airport_forms[airport_index]).find('[name="airport_name[' + clone_airport_index + '][]"]').attr('name', 'airport_name[' + (clone_airport_index - 1) + '][]');
                    $(clone_airport_forms[airport_index]).find('[name="airport_service_name[' + clone_airport_index + '][]"]').attr('name', 'airport_service_name[' + (clone_airport_index - 1) + '][]');
                    $(clone_airport_forms[airport_index]).find('[name="airport_service_fee[' + clone_airport_index + '][]"]').attr('name', 'airport_service_fee[' + (clone_airport_index - 1) + '][]');
                    
                    $(clone_airport_forms[airport_index]).find('[name="airport_note[]]').attr('id', 'airport_note' + (clone_airport_index - 1));
                    $(clone_airport_forms[airport_index]).find('textarea').attr('id', 'airport_note' + (clone_airport_index - 1));
                    $(clone_airport_forms[airport_index]).find('[name="airport_note_ar[]]').attr('id', 'airport_note_ar' + (clone_airport_index - 1));
                    $(clone_airport_forms[airport_index]).find('textarea').attr('id', 'airport_note_ar' + (clone_airport_index - 1));
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
            $(new_clone_form).find('[name="airport_service_name[' + airport_index + '][]"]').val('');
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
                if (airport_fee_clone_index >= clone_airport_fee_index) {
                    $(airport_fee_forms[airport_fee_index]).attr('id', 'airport' + clone_airport_index + '_fee_clone' + (airport_fee_clone_index - 1));
                }
            }
            var airport_fee_clone = parseInt($(clone_airport_form).find('[name="airportfeeincrement[]"]').val());
            airport_fee_clone--;
            $(clone_airport_form).find('[name="airportfeeincrement[]"]').val(airport_fee_clone);
        }

        /*
        * function for Medical
        * */
        var medical_clone = 0;
        function addMedicalForm(object) {
            medical_clone++;
            var clone_medical_form = object.closest(".clone");
            var medical_index = $(clone_medical_form).attr('id').replace("medical_clone", "");
            $('#medicalincrement').val(medical_clone);
            var new_clone_form = $(clone_medical_form).clone(true);
            new_clone_form.attr('id', 'medical_clone' + medical_clone);
            $(new_clone_form).find('[name="medicalfeeincrement[]"]').val(0);
            $(new_clone_form).find('[name="medical_id[]"]').val('');
            var medical_fees = $(new_clone_form).find('.medical-fee-clone');
            for (var medical_fee_index = 0; medical_fee_index < medical_fees.length; medical_fee_index++) {
                if (medical_fee_index == 0) {
                    $(medical_fees[medical_fee_index]).attr('id', 'medical' + medical_clone + '_fee_clone0');
                    $(medical_fees[medical_fee_index]).find('[name="medical_fee_id[' + medical_index + '][]"]').attr('name', 'medical_fee_id[' + medical_clone + '][]').val('');
                    $(medical_fees[medical_fee_index]).find('[name="medical_fees_per_week[' + medical_index + '][]"]').attr('name', 'medical_fees_per_week[' + medical_clone + '][]').val('');
                    $(medical_fees[medical_fee_index]).find('[name="medical_start_date[' + medical_index + '][]"]').attr('name', 'medical_start_date[' + medical_clone + '][]').val('');
                    $(medical_fees[medical_fee_index]).find('[name="medical_end_date[' + medical_index + '][]"]').attr('name', 'medical_end_date[' + medical_clone + '][]').val('');
                } else {
                    $(medical_fees[medical_fee_index]).remove();
                }
            }

            $(new_clone_form).find('[name="medical_company_name[]"]').val('');
            $(new_clone_form).find('[name="medical_deductible[]"]').val('');
            $(new_clone_form).find('[name="medical_week_selected_fee[]"]').val('');
            $(new_clone_form).find('[name="medical_note[]"]').attr('id', 'medical_note' + medical_clone);
            $(new_clone_form).find('[name="medical_note[]"]').text('');
            $(new_clone_form).find('[name="medical_note_ar[]"]').attr('id', 'medical_note_ar' + medical_clone);
            $(new_clone_form).find('[name="medical_note_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();

            new_clone_form.insertAfter($(clone_medical_form));

            tinymce.init({ selector: '#medical_note' + medical_clone });
            tinymce.get('medical_note' + medical_clone).show();
            tinymce.init({ selector: '#medical_note_ar' + medical_clone });
            tinymce.get('medical_note_ar' + medical_clone).show();
        }
        
        function deleteMedicalForm(object) {
            var clone_medical_form = object.closest(".clone");
            $(clone_medical_form).remove();
            var clone_medical_forms = $(".medical-clone");
            for (var medical_index = 0; medical_index < clone_medical_forms.length; medical_index++) {
                var clone_medical_index = parseInt($(clone_medical_forms[medical_index]).attr('id').replace("medical_clone", ""));
                if (clone_medical_index >= medical_clone) {
                    $(clone_medical_forms[medical_index]).attr('id', 'medical_clone' + clone_medical_index - 1);
                    $(clone_medical_forms[medical_index]).find('[name="medical_fee_id[' + clone_medical_index + '][]"]').attr('name', 'medical_fee_id[' + (clone_medical_index - 1) + '][]');
                    $(clone_medical_forms[medical_index]).find('[name="medical_fees_per_week[' + clone_medical_index + '][]"]').attr('name', 'medical_fees_per_week[' + (clone_medical_index - 1) + '][]');
                    $(clone_medical_forms[medical_index]).find('[name="medical_start_date[' + clone_medical_index + '][]"]').attr('name', 'medical_start_date[' + (clone_medical_index - 1) + '][]');
                    $(clone_medical_forms[medical_index]).find('[name="medical_end_date[' + clone_medical_index + '][]"]').attr('name', 'medical_end_date[' + (clone_medical_index - 1) + '][]');
                    
                    $(clone_medical_forms[medical_index]).find('[name="medical_note[]]').attr('id', 'medical_note' + (clone_medical_index - 1));
                    $(clone_medical_forms[medical_index]).find('textarea').attr('id', 'medical_note' + (clone_medical_index - 1));
                    $(clone_medical_forms[medical_index]).find('[name="medical_note_ar[]]').attr('id', 'medical_note_ar' + (clone_medical_index - 1));
                    $(clone_medical_forms[medical_index]).find('textarea').attr('id', 'medical_note_ar' + (clone_medical_index - 1));
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

        function getAirpotMedicalContents() {
            if (typeof (tinymce) !== 'undefined') {
                var airport_notes = $('[name="airport_note[]"]');
                for (var airport_note_index = 0; airport_note_index < airport_notes.length; airport_note_index++) {
                    var airport_note_id = $(airport_notes[airport_note_index]).attr('id');
                    if (tinymce.get(airport_note_id)) {
                        var airport_note_content = tinymce.get(airport_note_id).getContent();
                        $(airport_notes[airport_note_index]).text(airport_note_content);
                    }
                }
                var airport_notes = $('[name="airport_note_ar[]"]');
                for (var airport_note_index = 0; airport_note_index < airport_notes.length; airport_note_index++) {
                    var airport_note_id = $(airport_notes[airport_note_index]).attr('id');
                    if (tinymce.get(airport_note_id)) {
                        var airport_note_content = tinymce.get(airport_note_id).getContent();
                        $(airport_notes[airport_note_index]).text(airport_note_content);
                    }
                }
                var medical_notes = $('[name="medical_note[]"]');
                for (var mecial_note_index = 0; mecial_note_index < medical_notes.length; mecial_note_index++) {
                    var medical_note_id = $(medical_notes[mecial_note_index]).attr('id');
                    if (tinymce.get(medical_note_id)) {
                        var medical_note_content = tinymce.get(medical_note_id).getContent();
                        $(medical_notes[mecial_note_index]).text(medical_note_content);
                    }
                }
                var medical_notes = $('[name="medical_note_ar[]"]');
                for (var mecial_note_index = 0; mecial_note_index < medical_notes.length; mecial_note_index++) {
                    var medical_note_id = $(medical_notes[mecial_note_index]).attr('id');
                    if (tinymce.get(medical_note_id)) {
                        var medical_note_content = tinymce.get(medical_note_id).getContent();
                        $(medical_notes[mecial_note_index]).text(medical_note_content);
                    }
                }
            }
        }

        $(document).ready(function () {
            airport_clone = $('#airportincrement').val();
            medical_clone = $('#medicalincrement').val();

            $('select[multiple].active2.3col').multiselect({
                includeSelectAllOption: true
            });
            $('select[multiple].active.3col').multiselect({
                includeSelectAllOption: true
            });

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
        });

        var addschoolurl = "{{route('superadmin.school.store')}}";
        var in_arabic = "{{__('SuperAdmin/backend.in_arabic')}}";
        var in_english = "{{__('SuperAdmin/backend.in_english')}}";
    </script>

    <script>
        /*
        * Add and remove editor on click event
        *
        * */
        if (typeof (tinymce) !== "undefined") {
            tinymceInit();
        }
    </script>
@endsection