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
        * function for Text Book
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
        * function for Course Program
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
                var loop_course_program_clone_index = parseInt($(clone_course_program_forms[course_program_index]).attr('id').replace("course_program_clone", ""));
                if (loop_course_program_clone_index > course_program_clone_index) {
                    $(clone_course_program_forms[clone_course_program_index]).attr('id', 'course_program_clone' + (loop_course_program_clone_index + 1));
                    $(clone_course_program_forms[clone_course_program_index]).find('[name="age_range[' + loop_course_program_clone_index + '][]"]').attr('name', 'age_range[' + (loop_course_program_clone_index + 1) + '][]');
                    $(clone_course_program_forms[clone_course_program_index]).find('[name="available_days[]"]').data('index', loop_course_program_clone_index + 1);

                    $(clone_course_program_forms[clone_course_program_index]).find$(new_clone_form).find('[name="about_courier[]"]').attr('id', 'about_courier' + (loop_course_program_clone_index + 1));
                    $(clone_course_program_forms[clone_course_program_index]).find$(new_clone_form).find('[name="about_courier_ar[]"]').attr('id', 'about_courier_ar' + (loop_course_program_clone_index + 1));
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
            $(new_clone_form).find('#about_courier' + course_program_clone_index).attr('id', 'about_courier' + (course_program_clone_index + 1));
            $(new_clone_form).find('#about_courier' + (course_program_clone_index + 1)).text('');
            $(new_clone_form).find('[name="about_courier[]"]').attr('id', 'about_courier' + (course_program_clone_index + 1));
            $(new_clone_form).find('[name="about_courier[]"]').text('');
            $(new_clone_form).find('[name="about_courier_ar[]"]').attr('id', 'about_courier_ar' + (course_program_clone_index + 1));
            $(new_clone_form).find('[name="about_courier_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();
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

            tinymce.init({ selector: '#about_courier' + (course_program_clone_index + 1) });
            tinymce.get('about_courier' + (course_program_clone_index + 1)).show();
            tinymce.init({ selector: '#about_courier_ar' + (course_program_clone_index + 1) });
            tinymce.get('about_courier_ar' + (course_program_clone_index + 1)).show();

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
        * function for Program Under Age
        * */
        var program_under_age_clone = 0;
        function addProgramUnderAgeFee(object) {
            program_under_age_clone++;
            var clone_program_under_age_form = object.closest(".clone");
            var program_under_age_clone_index = parseInt($(clone_program_under_age_form).attr('id').replace("under_age_fee_clone", ""));
            $('#underagefeeincrement').val(program_under_age_clone);

            var clone_course_program_under_age_forms = $(".under-age-fee-clone");
            for (var course_program_under_age_index = 0; course_program_under_age_index < clone_course_program_under_age_forms.length; course_program_under_age_index++) {
                var loop_course_program_under_age_clone_index = parseInt($(clone_course_program_under_age_forms[course_program_under_age_index]).attr('id').replace("under_age_fee_clone", ""));
                if (loop_course_program_under_age_clone_index > program_under_age_clone_index) {
                    $(clone_course_program_under_age_forms[course_program_under_age_index]).attr('id', 'under_age_fee_clone' + (loop_course_program_under_age_clone_index + 1));
                    $(clone_course_program_under_age_forms[course_program_under_age_index]).find('[name="under_age[' + loop_course_program_under_age_clone_index + '][]"]')
                        .attr('id', 'program_under_age_range_choose' + (loop_course_program_under_age_clone_index + 1))
                        .attr('name', 'under_age[' + (loop_course_program_under_age_clone_index + 1) + '][]');
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
        * function for Program Text Book
        * */
        var program_text_book_clone = 0;
        function addTextBookFee(object) {
            program_text_book_clone++;
            var clone_program_text_book_form = object.closest(".clone");
            var program_text_book_clone_index = parseInt($(clone_program_text_book_form).attr('id').replace("text_book_fee_clone", ""));
            $('#textbookfeeincrement').val(program_text_book_clone);
            
            var clone_course_program_text_book_forms = $(".text-book-fee-clone");
            for (var course_program_text_book_index = 0; course_program_text_book_index < clone_course_program_text_book_forms.length; course_program_text_book_index++) {
                var loop_course_program_text_book_clone_index = parseInt($(clone_course_program_text_book_forms[course_program_text_book_index]).attr('id').replace("text_book_fee_clone", ""));
                if (loop_course_program_text_book_clone_index > program_text_book_clone_index) {
                    $(clone_course_program_text_book_forms[course_program_text_book_index]).attr('id', 'text_book_fee_clone' + (loop_course_program_text_book_clone_index + 1));
                    $(clone_course_program_text_book_forms[course_program_text_book_index]).find('[name="text_book_note[]"]').attr('id', 'text_book_note' + (loop_course_program_text_book_clone_index + 1));
                    $(clone_course_program_text_book_forms[course_program_text_book_index]).find('[name="text_book_note_ar[]"]').attr('id', 'text_book_note_ar' + (loop_course_program_text_book_clone_index + 1));
                }
            }

            var new_clone_form = $(clone_program_text_book_form).clone(true);
            new_clone_form.attr('id', 'text_book_fee_clone' + (program_text_book_clone_index + 1));
            $(new_clone_form).find('[name="textbook_id[]"]').val('');
            $(new_clone_form).find('[name="text_book_fee[]"]').val('');
            $(new_clone_form).find('[name="text_book_fee_start_date[]"]').val('');
            $(new_clone_form).find('[name="text_book_fee_end_date[]"]').val('');
            $(new_clone_form).find('[name="text_book_note[]"]').attr('id', 'text_book_note' + (program_text_book_clone_index + 1));
            $(new_clone_form).find('[name="text_book_note[]"]').text('');
            $(new_clone_form).find('[name="text_book_note_ar[]"]').attr('id', 'text_book_note_ar' + (program_text_book_clone_index + 1));
            $(new_clone_form).find('[name="text_book_note_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();

            new_clone_form.insertAfter($(clone_program_text_book_form));

            tinymce.init({ selector: '#text_book_note' + (program_text_book_clone_index + 1) });
            tinymce.get('text_book_note' + (program_text_book_clone_index + 1)).show();
            tinymce.init({ selector: '#text_book_note_ar' + (program_text_book_clone_index + 1) });
            tinymce.get('text_book_note_ar' + (program_text_book_clone_index + 1)).show();
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
        * function for Accommodation
        * */
        var accommodation_clone = 0;
        function addAccommodation(object) {
            accommodation_clone++;
            var clone_accommodation_form = object.closest(".clone");
            var accommodation_clone_index = parseInt($(clone_accommodation_form).attr('id').replace("accommodation_clone", ""));

            var clone_accommodation_forms = $(".accommodation-clone");
            for (var accommodation_index = 0; accommodation_index < clone_accommodation_forms.length; accommodation_index++) {
                var loop_accommodation_clone_index = parseInt($(clone_accommodation_forms[accommodation_index]).attr('id').replace("accommodation_clone", ""));
                if (loop_accommodation_clone_index > accommodation_clone_index) {
                    $(clone_accommodation_forms[accommodation_index]).attr('id', 'accommodation_clone' + (loop_accommodation_clone_index + 1));
                    $(clone_accommodation_forms[accommodation_index]).find('[name="age_range[' + loop_accommodation_clone_index + '][]"]').attr('name', 'age_range[' + (loop_accommodation_clone_index + 1) + '][]');
                    $(clone_accommodation_forms[accommodation_index]).find('[name="age_range_for_custodian[' + loop_accommodation_clone_index + '][]"]').attr('name', 'age_range_for_custodian[' + (loop_accommodation_clone_index + 1) + '][]');
                    $(clone_accommodation_forms[accommodation_index]).find('[name="custodian_condition[' + loop_accommodation_clone_index + ']"]').attr('name', 'custodian_condition[' + (loop_accommodation_clone_index + 1) + ']');
                    $(clone_accommodation_forms[accommodation_index]).find('[name="available_days[]"]').data('index', loop_accommodation_clone_index + 1);

                    $(clone_accommodation_forms[accommodation_index]).find('[name="special_diet_note[]]').attr('id', 'special_diet_note' + (loop_accommodation_clone_index + 1));
                    $(clone_accommodation_forms[accommodation_index]).find('[name="special_diet_note_ar[]]').attr('id', 'special_diet_note_ar' + (loop_accommodation_clone_index + 1));
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
            $(new_clone_form).find('[name="custodian_fee[]"]').val('');
            var age_range_for_custodian_html = $(new_clone_form).find('[name="age_range_for_custodian[' + accommodation_clone_index + '][]"]').html();
            age_range_for_custodian_html = '<select name="age_range_for_custodian[' + (accommodation_clone_index + 1) + '][]" id="custodian_age_range_choose' + (accommodation_clone_index + 1) + '" multiple="multiple" class="3col active">' + age_range_for_custodian_html + '</select>';
            $(new_clone_form).find('[name="age_range_for_custodian[' + accommodation_clone_index + '][]"]').parent().remove();
            $(new_clone_form).find('.age_range_for_custodian').append(age_range_for_custodian_html);
            $(new_clone_form).find('[name="age_range_for_custodian[' + (accommodation_clone_index + 1) + '][]"]').val('');
            $(new_clone_form).find('[name="age_range_for_custodian[' + (accommodation_clone_index + 1) + '][]"]').multiselect({ includeSelectAllOption: true });
            $(new_clone_form).find('[name="custodian_condition[' + accommodation_clone_index + ']"]').attr('name', 'custodian_condition[' + (accommodation_clone_index + 1) + ']');
            $(new_clone_form).find('[name="custodian_condition[' + (accommodation_clone_index + 1) + ']"]').val('invisible');
            $(new_clone_form).find('[name="special_diet_note[]"]').attr('id', 'special_diet_note' + (accommodation_clone_index + 1));
            $(new_clone_form).find('[name="special_diet_note[]"]').text('');
            $(new_clone_form).find('[name="special_diet_note_ar[]"]').attr('id', 'special_diet_note_ar' + (accommodation_clone_index + 1));
            $(new_clone_form).find('[name="special_diet_note_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();
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
            
            initYearDatePicker();
        }

        /*
        * function for Accommodation Under Age
        * */
        var accommodation_under_age_clone = 0;
        function addAccommodationFormUnderAge(object) {
            accommodation_under_age_clone++;
            var clone_accommodation_under_age_form = object.closest(".clone");
            var accommodation_under_age_clone_index = parseInt($(clone_accommodation_under_age_form).attr('id').replace("accommodation_under_age_clone", ""));
            $('#accomunderageincrement').val(accommodation_under_age_clone);
            
            var clone_accommodation_under_age_forms = $(".accommodation-under-age-clone");
            for (var accommodation_under_age_index = 0; accommodation_under_age_index < clone_accommodation_under_age_forms.length; accommodation_under_age_index++) {
                var loop_accommodation_under_age_clone_index = parseInt($(clone_accommodation_under_age_forms[accommodation_under_age_index]).attr('id').replace("accommodation_under_age_clone", ""));
                if (loop_accommodation_under_age_clone_index > accommodation_under_age_clone_index) {
                    $(clone_accommodation_under_age_forms[accommodation_under_age_index]).attr('id', 'accommodation_under_age_clone' + (loop_accommodation_under_age_clone_index + 1));
                    $(clone_accommodation_under_age_forms[accommodation_under_age_index]).find('[name="under_age[' + loop_accommodation_under_age_clone_index + '][]"]')
                        .attr('id', 'under_age_choose' + (loop_accommodation_under_age_clone_index + 1))
                        .attr('name', 'under_age[' + (loop_accommodation_under_age_clone_index + 1) + '][]');
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
        * function for Airport
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
                var loop_airport_clone_index = parseInt($(clone_airport_forms[airport_index]).attr('id').replace("airport_clone", ""));
                if (loop_airport_clone_index > airport_clone_index) {
                    var airport_fee_forms = $(clone_airport_forms[airport_index]).find(".airport-fee-clone");
                    for (var airport_fee_index = 0; airport_fee_index < airport_fee_forms.length; airport_fee_index++) {
                        $(airport_fee_forms[airport_fee_index]).attr('id', 'airport' + (loop_airport_clone_index + 1) + '_fee_clone' + airport_fee_index);
                    }
                    $(clone_airport_forms[airport_index]).attr('id', 'airport_clone' + (loop_airport_clone_index + 1));
                    $(clone_airport_forms[airport_index]).find('[name="airport_fee_id[' + loop_airport_clone_index + '][]"]').attr('name', 'airport_fee_id[' + (loop_airport_clone_index + 1) + '][]');
                    $(clone_airport_forms[airport_index]).find('[name="airport_name[' + loop_airport_clone_index + '][]"]').attr('name', 'airport_name[' + (loop_airport_clone_index + 1) + '][]');
                    $(clone_airport_forms[airport_index]).find('[name="airport_service_name[' + loop_airport_clone_index + '][]"]').attr('name', 'airport_service_name[' + (loop_airport_clone_index + 1) + '][]');
                    $(clone_airport_forms[airport_index]).find('[name="airport_service_fee[' + loop_airport_clone_index + '][]"]').attr('name', 'airport_service_fee[' + (loop_airport_clone_index + 1) + '][]');
                    
                    $(clone_airport_forms[airport_index]).find('[name="airport_note[]]').attr('id', 'airport_note' + (loop_airport_clone_index + 1));
                    $(clone_airport_forms[airport_index]).find('textarea').attr('id', 'airport_note' + (loop_airport_clone_index + 1));
                    $(clone_airport_forms[airport_index]).find('[name="airport_note_ar[]]').attr('id', 'airport_note_ar' + (loop_airport_clone_index + 1));
                    $(clone_airport_forms[airport_index]).find('textarea').attr('id', 'airport_note_ar' + (loop_airport_clone_index + 1));
                }
            }
            var airport_fees = $(new_clone_form).find('.airport-fee-clone');
            for (var airport_fee_index = 0; airport_fee_index < airport_fees.length; airport_fee_index++) {
                if (airport_fee_index == 0) {
                    $(airport_fees[airport_fee_index]).attr('id', 'airport' + (airport_clone_index + 1) + '_fee_clone0');
                    $(airport_fees[airport_fee_index]).find('[name="airport_fee_id[' + airport_clone_index + '][]"]').attr('name', 'airport_fee_id[' + (airport_clone_index + 1) + '][]').val('');
                    $(airport_fees[airport_fee_index]).find('[name="airport_name[' + airport_clone_index + '][]"]').attr('name', 'airport_name[' + (airport_clone_index + 1) + '][]').val('');
                    $(airport_fees[airport_fee_index]).find('[name="airport_service_name[' + airport_clone_index + '][]"]').attr('name', 'airport_service_name[' + (airport_clone_index + 1) + '][]').val('');
                    $(airport_fees[airport_fee_index]).find('[name="airport_service_fee[' + airport_clone_index + '][]"]').attr('name', 'airport_service_fee[' + (airport_clone_index + 1) + '][]').val('');
                } else {
                    $(airport_fees[airport_fee_index]).remove();
                }
            }

            $(new_clone_form).find('[name="airport_service_provider[]"]').val('');
            $(new_clone_form).find('[name="airport_week_selected_fee[]"]').val('');
            $(new_clone_form).find('[name="airport_note[]"]').attr('id', 'airport_note' + (airport_clone_index + 1));
            $(new_clone_form).find('[name="airport_note[]"]').text('');
            $(new_clone_form).find('[name="airport_note_ar[]"]').attr('id', 'airport_note_ar' + (airport_clone_index + 1));
            $(new_clone_form).find('[name="airport_note_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();
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
                if (airport_fee_clone_index > clone_airport_fee_index) {
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
            var medical_clone_index = parseInt($(clone_medical_form).attr('id').replace("medical_clone", ""));
            $('#medicalincrement').val(medical_clone);
            var new_clone_form = $(clone_medical_form).clone(true);
            new_clone_form.attr('id', 'medical_clone' + (medical_clone_index + 1));
            $(new_clone_form).find('[name="medicalfeeincrement[]"]').val(0);
            $(new_clone_form).find('[name="medical_id[]"]').val('');
            var clone_medical_forms = $(".medical-clone");
            for (var medical_index = 0; medical_index < clone_medical_forms.length; medical_index++) {
                var loop_medical_clone_index = parseInt($(clone_medical_forms[medical_index]).attr('id').replace("medical_clone", ""));
                if (loop_medical_clone_index > medical_clone_index) {
                    var medical_fee_forms = $(clone_medical_forms[medical_index]).find(".medical-fee-clone");
                    for (var medical_fee_index = 0; medical_fee_index < medical_fee_forms.length; medical_fee_index++) {
                        $(medical_fee_forms[medical_fee_index]).attr('id', 'medical' + (loop_medical_clone_index + 1) + '_fee_clone' + medical_fee_index);
                    }
                    $(clone_medical_forms[medical_index]).attr('id', 'medical_clone' + (loop_medical_clone_index + 1));
                    $(clone_medical_forms[medical_index]).find('[name="medical_fee_id[' + loop_medical_clone_index + '][]"]').attr('name', 'medical_fee_id[' + (loop_medical_clone_index + 1) + '][]');
                    $(clone_medical_forms[medical_index]).find('[name="medical_fees_per_week[' + loop_medical_clone_index + '][]"]').attr('name', 'medical_fees_per_week[' + (loop_medical_clone_index + 1) + '][]');
                    $(clone_medical_forms[medical_index]).find('[name="medical_start_date[' + loop_medical_clone_index + '][]"]').attr('name', 'medical_start_date[' + (loop_medical_clone_index + 1) + '][]');
                    $(clone_medical_forms[medical_index]).find('[name="medical_end_date[' + loop_medical_clone_index + '][]"]').attr('name', 'medical_end_date[' + (loop_medical_clone_index + 1) + '][]');
                    
                    $(clone_medical_forms[medical_index]).find('[name="medical_note[]]').attr('id', 'medical_note' + (loop_medical_clone_index + 1));
                    $(clone_medical_forms[medical_index]).find('textarea').attr('id', 'medical_note' + (loop_medical_clone_index + 1));
                    $(clone_medical_forms[medical_index]).find('[name="medical_note_ar[]]').attr('id', 'medical_note_ar' + (loop_medical_clone_index + 1));
                    $(clone_medical_forms[medical_index]).find('textarea').attr('id', 'medical_note_ar' + (loop_medical_clone_index + 1));
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
            $(new_clone_form).find('[name="medical_deductible[]"]').val('');
            $(new_clone_form).find('[name="medical_week_selected_fee[]"]').val('');
            $(new_clone_form).find('[name="medical_note[]"]').attr('id', 'medical_note' + (medical_clone_index + 1));
            $(new_clone_form).find('[name="medical_note[]"]').text('');
            $(new_clone_form).find('[name="medical_note_ar[]"]').attr('id', 'medical_note_ar' + (medical_clone_index + 1));
            $(new_clone_form).find('[name="medical_note_ar[]"]').text('');
            $(new_clone_form).find('.tox.tox-tinymce').remove();

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