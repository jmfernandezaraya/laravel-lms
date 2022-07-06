@section('js')
    <script>
        var age_range_url_is = "{{route('superadmin.add_program_under_age_page')}}";        
        var program_under_age_range_choose_number = 0;
        var accomunderageclone = 0;
        var program_number_add = 0;
        var add_program_button = 0;
        
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
        var select_option = "{{__('Admin/backend.select_option')}}";
        var search = "{{__('Admin/backend.search')}}";

        var formnum = 0;
        var rowNum = 0;
        var textbooknum = 1;
        var rowNum1 = 1;
        var rowNum2 = 1;
        var rowNum3 = 1;
        var rowNum4 = 1;
        var rowNum5 = 1;

        var remove_program_button = 0;
        var i = 1;

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

        var program_age_range = 0;
        function addAnotherProgramCost(this_value) {
            var clone_program_form = this_value.parents()[3];
            var clone_under_age = $(clone_program_form).find('#clone_under_age0');

            add_program_button++;
            program_age_range++;
            remove_program_button++;
            program_under_age_range_choose_number++;
            formnum++;
            var clone = $(clone_program_form).append("<br>").clone(true);
            clone.find('.clonoe' + (add_program_button - 1)).attr('class', 'clonoe' + add_program_button);
            var prog_val = $(clone).find('#program_id').val();

            $(clone).find('#program_id').val((parseInt(prog_val) + 1));
            clone.attr('id', 'clone_program_form' + formnum);
            clone.find('#program_unique_id').attr('value' + formnum);

            clone.find('#add_program-dost-d' + (formnum -1)).attr('id', 'add_program-dost-d' + formnum);
            clone.find('#remove_program_button' + (formnum -1)).attr('id', 'remove_program_button' + formnum);
            $('#add_program-dost-d' + (formnum - 1)).hide();
            $('#remove_program_button' + (formnum - 1)).hide();
            clone.find('#clone_under_age0').attr('id', 'clone_under_age' + rowNum + add_program_button);
            clone.find('#program_age_range_choose' + (program_age_range - 1)).attr('name', "age_range[" + program_age_range + "][]" );
            clone.find('#program_age_range_choose' + (program_age_range - 1)).attr('id', "program_age_range_choose" + program_age_range);
            clone.find('#to_be_inserted_age' + (formnum - 1)).attr('id', 'to_be_inserted_age' + formnum);
            clone.find('#program_under_age_remove' + (formnum - 1)).attr('id', 'program_under_age_remove' + remove_program_button);
            // clone.find('#program_under_age_range_choose' + (formnum - 1)).attr('id', 'program_under_age_range_choose' + program_under_age_range_choose_number);
            clone.find("#increment_program").attr('value', add_program_button);
            // clone.find('select').attr('name', 'program_under_age[' + rowNum + '][' + add_program_button + '][age][]');
            clone.find('#fees_under_age').attr('name', 'program_under_age[' + rowNum + '][' + add_program_button + '][fees][]');

            var textareas = $(this_value).parent().parent().parent().find('textarea').attr('id');
            var textarea = $(this_value).parent().parent().parent().find('#about_courier').attr('id', 'about_courier' + add_program_button);

            var tineyeditor = clone.find('textarea').parent().remove();
            clone.find('textarea').remove();

            clone.insertAfter($(clone_program_form));
            var remove_program_clone = 0;
            removeExtraAge();
        }

        /*
        * function for removing program cost
        * */
        function removeAnotherProgramCost(this_value) {
            if(formnum > 0){
                var clone_program_form = this_value.parents().find('#clone_program_form' + formnum);
                $(clone_program_form).find('#add_program-dost-d' + (formnum)).attr('id', 'add_program-dost-d' + (formnum -1));
                $(clone_program_form).find('#remove_program_button' + (formnum)).attr('id', 'remove_program_button' + (formnum -1));
                $('#add_program-dost-d' + (formnum - 1 )).show();
                $('#remove_program_button' + (formnum - 1 )).show();

                $(clone_program_form).remove();

                add_program_button--;
                program_age_range--;
                remove_program_button--;
                program_under_age_range_choose_number--;
                formnum--;
            }
        }

        var remove_program_clone= 0;
        /*
        *
        * function for adding program age multiselect
        * */
        function removeExtraAge() {
            remove_program_clone++;
            $('#clone_program_form' + (remove_program_clone) + " .multiselect-native-select").remove();
            var select_form = $('#clone_program_form0 #program_age_range_choose0').html();
            select_form_full = '<select name="age_range[' + remove_program_clone + '][]" id="program_age_range_choose' + (remove_program_clone) + '" multiple="multiple" class="3col active tobehided">' + select_form + '</select>';
            $(select_form_full).insertAfter($("#to_be_inserted_age" + remove_program_clone));
            $("#program_age_range_choose" + (remove_program_clone)).multiselect({
                includeSelectAllOption: true
            });
        }

        var delete_program_multi = 1;
        function addProgramUnderAge(t) {
            var id = $(t).attr('data-id');
            delete_program_multi++;

            var var1 = $("#program_under_age_range_choose" + (rowNum)).val();
            var fees = $(var1).next().next().find('#fees_under_age').val();
            rowNum++;

            $.post("{{route('superadmin.course.store')}}", {
                _token: "{{csrf_token()}}",
                yes: 'yes',
                under_age: var1,
                program_under_age_range_choose_number: fees
            }, function (data) {
                console.log(data);
            });

            var t = $(t).parents().find('.clonoe' + add_program_button).append('<div id="clone_under_age' + (rowNum) + '"></div>');
            $('#clone_under_age' + (rowNum)).html($('#clone_under_age' + id).html());
            $('#clone_under_age' + (rowNum) + " .multiselect-native-select").remove();
            var select_form = $('#clone_under_age0 #program_under_age_range_choose0').html();

            select_form_full = '<select name="program_under_age[age][' + rowNum + '][]" id="program_under_age_range_choose' + (rowNum) + '" multiple="multiple" class="3col active tobehided">' + select_form + '</select>';
            $(select_form_full).insertBefore('#clone_under_age' + (rowNum) + ' #under_age_program_increment');

            $("#program_under_age_range_choose" + (rowNum)).multiselect({
                includeSelectAllOption: true
            });
            $('#clone_under_age' + (rowNum - 1)).find('#program_under_age_add').attr('data-id', (rowNum));
            $('#clone_under_age' + (rowNum - 1)).find('#clone_under_age_increment').attr('value', (rowNum + 1));
        }

        $(document).ready(function () {
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
                /*    add_program_button++;
                remove_program_button++;
                program_under_age_range_choose_number++;
                formnum++;
                var clone = $("#clone_program_form"+ (formnum -1)).append("<br>").clone(true);
                clone.attr('id', 'clone_program_form' + formnum);
                //var clclc = clone.find('#program_under_age_add' + (formnum - 1)).attr('id', 'program_under_age_add' + add_program_button);
                clone.find('#program_under_age_remove' + (formnum - 1)).attr('id', 'program_under_age_remove' + remove_program_button);
                clone.find('#program_under_age_range_choose' + (formnum - 1)).attr('id', 'program_under_age_range_choose' + program_under_age_range_choose_number);
                clone.find('#clone_under_age' + (formnum - 1)).attr('id', 'clone_under_age' + program_under_age_range_choose_number);
                clone.insertAfter('#clone_program_form' + (formnum -1));*/
            });

            /*
            * Clone Accommodation Form
            * */
            $("#clone_accommodation_form" + accom_button).find('#add_another_accomodation' + accom_button).click(function () {
                accom_button++;

                var clone = $("#clone_accommodation_form" + (accom_button - 1)).append("<br>").clone(true);
                // $(clone).find("#accom_age_choose" + (accom_button -1)).attr('id', 'accom_age_choose' + accom_button);
                clone.find('#custodian_age_range_choose' + (accom_button - 1)).attr('id', 'custodian_age_range_choose' + accom_button);
                var consoles = clone_custodianfind = clone.find('#custodian_age_range_choose' + (accom_button));
                    var consoles1 = clone_custodianfind = clone.find('#custodian_age_range_choose' + (accom_button - 1));
                clone.find('#add_another_accomodation' + (accom_button - 1)).attr('id', 'add_another_accomodation'+ accom_button);
                clone.find('#remove_another_accomodation' + (accom_button -1)).attr('id', 'remove_another_accomodation'+ accom_button);
                $("#remove_another_accomodation" + (accom_button -1)).hide();
                $("#add_another_accomodation" + (accom_button -1)).hide();

                var accom_val = parseInt(clone.find('#accommodation_id').val());
                accom_val++;
                $(clone).find('#accommodation_id').val(accom_val);
                $(clone).find("#remove_custodian" + (accom_button - 1)).attr('id', 'remove_custodian' + accom_button);
                $(clone).find("#remove_accom_accom" + (accom_button - 1)).attr('id', 'remove_accom_accom' + accom_button);
                clone.insertAfter('#clone_accommodation_form' + (accom_button - 1));

                clone.find('textarea').parent().remove();
                clone.find('textarea').remove();
                clone.attr('id', 'clone_accommodation_form' + accom_button);
                $('#custodian_age_range_choose' + (accom_button - 1)).html($('#custodian_age_range_choose' + accom_button).html());
                $('#clone_accommodation_form' + (accom_button) + " .multiselect-native-select").remove();

                var select_form = $('#clone_accommodation_form0 #custodian_age_range_choose0').html();
                var select_form_accom = $('#clone_accommodation_form0 #accom_age_choose0').html();

                select_form_full = '<select name="age_range_for_custodian[' + accom_button + '][]" id="custodian_age_range_choose' + (accom_button) + '" multiple="multiple" class="3col active tobehided">' + select_form + '</select>';
                var inserted = clone.find("#custodian_age_range_choose" + accom_button);

                $(select_form_full).appendTo($("#remove_custodian" + accom_button));
                $('#custodian_age_range_choose' + accom_button).multiselect({
                    includeSelectAllOption: true
                });

                select_form_accom_full = '<select name="age_range[' + accom_button + '][]" id="accom_age_choose' + (accom_button) + '" multiple="multiple" class="3col active tobehided">' + select_form_accom + '</select>';
                var inserted = clone.find("#accom_age_choose" + accom_button);
                var beforeInsert = $("#remove_accom_accom" + accom_button);
                $(select_form_accom_full).insertBefore(beforeInsert);
                $('#accom_age_choose' + accom_button).multiselect({
                    includeSelectAllOption: true
                });
            });
        });

        var addschoolurl = "{{route('superadmin.school.store')}}";
        var in_arabic = "{{__('Admin/backend.in_arabic')}}";
        var in_english = "{{__('Admin/backend.in_english')}}";
    </script>

    <script>
        function get_content()
            $("#about_program_value").val(about_program);
            $("#about_courier_value").val(about_courier);
            $("#text_book_note_value").val(text_book_note);
            $("#medical_insurance_note_value").val(medical_insurance_note);
            $("#special_diet_note_value").val(special_diet_note);
        }

        function addAccommodationFormUnderAge(value) {
            accom_button1++;
            var id = $(value).attr('data-id');
            var t = $(value).parents().find('.accomoe0').append('<div class="row" id="accom_under_age_clone' + (accom_button1) + '"></div>');

            $('#accom_under_age_clone' + (accom_button1)).html($('#accom_under_age_clone' + id).html());
            $('#accom_under_age_clone'  + (accom_button1) + " .multiselect-native-select").remove();
            $("input[name='accom_increment']").attr('value', accom_button1 + 1);
            var select_form = $('#accom_under_age_clone0 #under_age_choose0').html();
            select_form_full = '<select name="under_age[age]['+ accom_button1 + '][]" id="under_age_choose' +(accom_button1) + '" multiple="multiple" class="3col active">' + select_form + '</select>';
            var inserted = $('#accom_under_age_clone' + accom_button1);
            $(select_form_full).insertAfter(inserted);
            $("#under_age_choose" + (accom_button1)).multiselect({
                includeSelectAllOption: true
            });
            $('#accom_under_age_clone' +  (accom_button1)).find('#accom_plus_button').attr('data-id', (accom_button1));
        }

       function removeTextBookFee(object) {
            if (!(textbooknum <= 1)) {
                textbooknum--;
                $(object).parent().parent().remove();
            }
        }

        /*
        * function for removing another accomodation
        * */
        function remove_another_accomodation(object){
            if(accom_button > 0){
                var clone = $("#clone_accommodation_form" + (accom_button));
                $(clone).remove();
                $(clone).find('#add_another_accomodation' + (accom_button)).attr('id', 'add_program-dost-d' + (formnum -1));
                $(clone).find('#remove_another_accomodation' + (accom_button)).attr('id', 'remove_program_button' + (formnum -1));
                $('#add_another_accomodation' + (accom_button - 1 )).show();
                $('#remove_another_accomodation' + (accom_button - 1 )).show();
                accom_button--;
            }
        }
    </script>
@endsection