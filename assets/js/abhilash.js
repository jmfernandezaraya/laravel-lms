/*
* Init tinymce
*/
function initCkeditor(editor_id) {
    if (editor_id) {
        var option = {};
        if (typeof uploadFileOption != 'undefined') {
            option = {
                filebrowserUploadUrl: uploadFileOption,
                filebrowserUploadMethod: 'form',
            };
        }
        CKEDITOR.replace(editor_id, option);
    }
}

function initCkeditors() {
    var option = {};
    if (typeof uploadFileOption != 'undefined') {
        option = {
            filebrowserUploadUrl: uploadFileOption,
            filebrowserUploadMethod: 'form',
        };
    }
    var textareas = $('textarea.ckeditor-input');
    for (var textarea_index = 0; textarea_index < textareas.length; textarea_index++) {
        if ($(textareas[textarea_index]).attr('id')) {
            CKEDITOR.replace($(textareas[textarea_index]).attr('id'), option);
        }
    }
}

function getCkEditorData(textareaid, value) {
    var text = CKEDITOR.instances.textareaid.getData();
    $("#" + value).val(text);
}

function getCkEditorsData() {
    var textareas = $('textarea.ckeditor-input');
    for (var textarea_index = 0; textarea_index < textareas.length; textarea_index++) {
        if ($(textareas[textarea_index]).attr('id')) {
            $("#" + $(textareas[textarea_index]).attr('id')).val(CKEDITOR.instances[$(textareas[textarea_index]).attr('id')].getData());
        }
    }
}

function getCKEDITORdataSchool(textareaid, value) {
    var text = CKEDITOR.instances.textareaid.getData();
    $("#" + value).val(text);
}

function getCKEDITORdataCustomer(textareaid, value) {
    var text = CKEDITOR.instances.textareaid.getData();
    $("#" + value).val(text);
}

function tinymceInit(id = null) {
    if (id == null) {
        tinymce.init({
            selector: 'textarea.tinymce'
        });
    } else {
        tinymce.init({
            selector: 'textarea#' + id
        });
    }
}

function reloadTinymceEditor() {
    if (typeof (tinymce) != "undefined") {
        tinymce.remove('textarea');
        tinymceInit();
    }
}

var datepicker_available_days = [];
var datepicker_format = 'dd-mm-yy';

var yeardatepicker_days = [];
var yeardatepicker_months = [];

function detectDatePickerMonthClick(datepickerEl) {
    var datepicker_index = $(datepickerEl).data('index');
    var datepickerObj = $($(datepickerEl).data('datepicker').dpDiv);
    datepickerObj.find('.ui-datepicker-group .ui-datepicker-header .ui-datepicker-title').click(function() {
        var click_year = $(this).find('.ui-datepicker-year').html();
        var click_month_str = $(this).find('.ui-datepicker-month').html();
        var click_month = 1;
        if (click_month_str == 'January') click_month = '01';
        else if (click_month_str == 'February') click_month = '02';
        else if (click_month_str == 'March') click_month = '03';
        else if (click_month_str == 'April') click_month = '04';
        else if (click_month_str == 'May') click_month = '05';
        else if (click_month_str == 'June') click_month = '06';
        else if (click_month_str == 'July') click_month = '07';
        else if (click_month_str == 'August') click_month = '08';
        else if (click_month_str == 'September') click_month = '09';
        else if (click_month_str == 'October') click_month = '10';
        else if (click_month_str == 'November') click_month = '11';
        else if (click_month_str == 'December') click_month = '12';
        var month_days = $(this).parent().parent().find('.ui-datepicker-calendar td');
        var month_index = $.inArray(click_month + "/" + click_year, yeardatepicker_months[datepicker_index]);        
        if (month_index == -1) {
            if (click_year && click_month) yeardatepicker_months[datepicker_index].push(click_month + "/" + click_year);
        } else {
            yeardatepicker_months[datepicker_index].splice(month_index, 1);
        }
        for (var month_day_index = 0; month_day_index < month_days.length; month_day_index++) {
            if (!$(month_days[month_day_index]).hasClass('ui-datepicker-other-month')) {
                var click_day = $(month_days[month_day_index]).find('a').html();
                if (click_day) {
                    if (parseInt(click_day) < 10) click_day = '0' + click_day;
                    var click_date = click_month + "/" + click_day + "/" + click_year;
                    if (click_date) {
                        if (month_index == -1) {
                            var date_index = $.inArray(click_date, yeardatepicker_days[datepicker_index]);
                            if (date_index == -1) {
                                yeardatepicker_days[datepicker_index].push(click_date);
                            }
                        } else {
                            var date_index = $.inArray(click_date, yeardatepicker_days[datepicker_index]);
                            if (date_index != -1) {
                                yeardatepicker_days[datepicker_index].splice(date_index, 1);
                            }
                        }
                    }
                }
            }
        }
        
        $(datepickerEl).val(yeardatepicker_days[datepicker_index].join(","));
        datepickerObj.find('.ui-datepicker-today').click();            
        setTimeout(function() {
            datepickerObj.find('.ui-datepicker-today').click();
        }, 300);
    });
}

function initYearDatePicker() {
    $('.yeardatepicker').each(function() {
        var datepicker_index = $(this).data('index');
        var todayDate = new Date();
        $(this).datepicker({
            dateFormat: 'mm/dd/yy',
            showCurrentAtPos: todayDate.getMonth(),
            showOtherMonths: true,
            selectOtherMonths: true,
            numberOfMonths: [4,3],
            yearRange: (todayDate.getYear() + 1900) + ":" + (todayDate.getYear() + 1901),
            changeYear: true,
            selectMultiple: true,
            showButtonPanel: true,
            onSelect: function(d) {
                var i = $.inArray(d, yeardatepicker_days[datepicker_index]);
                if (i == -1) {
                    yeardatepicker_days[datepicker_index].push(d);
                } else {
                    yeardatepicker_days[datepicker_index].splice(i, 1);
                }
                $(this).data('datepicker').inline = true;
                $(this).data('datepicker').settings.showCurrentAtPos = 0;
                yeardatepicker_days[datepicker_index].sort(function (first, second) {
                    var firstDates = first.split('/');
                    var secondDates = second.split('/');
                    if (parseInt(firstDates[2]) > parseInt(secondDates[2])) {
                    return 1;
                    } else if (parseInt(firstDates[2]) < parseInt(secondDates[2])) {
                        return -1;
                    } else {
                        if (parseInt(firstDates[0]) > parseInt(secondDates[0])) {
                            return 1;
                        } else if (parseInt(firstDates[0]) < parseInt(secondDates[0])) {
                            return -1;
                        } else {
                            if (parseInt(firstDates[1]) > parseInt(secondDates[1])) {
                                return 1;
                            } else if (parseInt(firstDates[1]) < parseInt(secondDates[1])) {
                                return -1;
                            }
                        }
                    }
                    return 0;
                });
                $(this).val(yeardatepicker_days[datepicker_index].join(","));
                $($(this).data('datepicker').dpDiv).addClass('ui-datepicker-selected');
            },
            onClose: function() {
                $(this).data('datepicker').inline = false;
                $(this).data('datepicker').settings.showCurrentAtPos = todayDate.getMonth();
            },
            beforeShow: function() {
                var datepickerEl = this;
                setTimeout(function() {
                    detectDatePickerMonthClick(datepickerEl);
                }, 300);
            },
            beforeShowDay: function(d) {
                var datepickerEl = this;
                var datepickerObj = $($(datepickerEl).data('datepicker').dpDiv);
                if (datepickerObj.hasClass('ui-datepicker-selected')) {
                    datepickerObj.removeClass('ui-datepicker-selected');
                    setTimeout(function() {
                        detectDatePickerMonthClick(datepickerEl);
                    }, 300);
                }
                
                var dateavailable = true;
                if ($.datepicker.formatDate('yymmdd', d) < $.datepicker.formatDate('yymmdd', todayDate)) dateavailable = false;
                return ([dateavailable, $.inArray($.datepicker.formatDate('mm/dd/yy', d), yeardatepicker_days[datepicker_index]) == -1 ? 'ui-state-free' : 'ui-state-busy']);
            }
        });
    });
}

$(document).ready(function () {
    $('.available_date').change(function (e) {
        if ($(this).val() == 'selected_dates') {
            $(this).parent().parent().find('.available_days').show();
            $(this).parent().parent().find('.select_day_week').hide();
            $(this).parent().parent().find('.start_date').hide();
            $(this).parent().parent().find('.end_date').hide();
        } else {
            $(this).parent().parent().find('.available_days').hide();
            $(this).parent().parent().find('.select_day_week').show();
            $(this).parent().parent().find('.start_date').show();
            $(this).parent().parent().find('.end_date').show();
        }
    });

    initYearDatePicker();

    var todayDate = new Date();
    if ($('#datepick').length) {
        $('#datepick').datepicker({
            dateFormat: datepicker_format,
            minDate: $.datepicker.formatDate(datepicker_format, todayDate),
            beforeShowDay: function(d) {
                var dateavailable = true;
                if (datepicker_available_days.indexOf($.datepicker.formatDate('yymmdd', d)) == -1) dateavailable = false;
                return ([dateavailable]);
            }
        });
    }
});

function toggleAdvancedSearch() {
    if ($('[name="advanced"]').val() == 'expanded') {
        $('[name="advanced"]').val('collapsed');
        $('.advance-search-form').hide();
    } else if ($('[name="advanced"]').val() == 'collapsed') {
        $('[name="advanced"]').val('expanded');
        $('.advance-search-form').show();
    }
}

function searchCourse() {
    $("#loader").show();

    var searchForm = $('#search-course-form');
    var formActionUrl = searchForm.attr('action');
    var formData = new FormData(searchForm[0]);
    $.ajax({
        type: 'POST',
        url: formActionUrl,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success) {
                $("#loader").hide();

                if (window.location.pathname == '' || window.location.pathname == '/') {
                    window.location.href = url_course;
                } else {
                    $('.school-list .row').html(data.courses_html);                    
                }
            } else if (data.errors) {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        }
    });
}

function like_school(school_id, user_login_check=false)
{
    if (user_login_check) {
        alert('Login First');
    }
    urlname = like_school_url + '/' +  school_id;
    $.get(urlname, {}, function(data) {});
}

function changeSearchLanguage() {
    $.post(url_search_age_list, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        language: $('#choose-language').val()
    }, function (data) {
        $('#choose-age').html(data);
        if (typeof callbackSearchCourse === "function") {
            callbackSearchCourse('language');
        } else {
            changeSearchAge();
        }
    });
}

function changeSearchAge() {
    $.post(url_search_country_list, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        language: $('#choose-language').val(),
        age: $('#choose-age').val()
    }, function (data) {
        $('#choose-country').html(data);
        if (typeof callbackSearchCourse === "function") {
            callbackSearchCourse('age');
        } else {
            changeSearchCountry();
        }
    });
}

function changeSearchCountry() {
    $.post(url_search_program_type_list, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        language: $('#choose-language').val(),
        age: $('#choose-age').val(),
        country: $('#choose-country').val()
    }, function (data) {
        $('#choose-program-type').html(data);
        if (typeof callbackSearchCourse === "function") {
            callbackSearchCourse('country');
        } else {
            changeSearchProgramType();
        }
    });
}

function changeSearchProgramType() {
    $.post(url_search_study_mode_list, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        language: $('#choose-language').val(),
        age: $('#choose-age').val(),
        country: $('#choose-country').val(),
        program_type: $('#choose-program-type').val()
    }, function (data) {
        $('#choose-study-mode').html(data);
        if (typeof callbackSearchCourse === "function") {
            callbackSearchCourse('program-type');
        } else {
            changeSearchStudyMode();
        }
    });
}

function changeSearchStudyMode() {
    $.post(url_search_city_list, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        language: $('#choose-language').val(),
        age: $('#choose-age').val(),
        country: $('#choose-country').val(),
        program_type: $('#choose-program-type').val(),
        study_mode: $('#choose-study-mode').val()
    }, function (data) {
        if ($('[name="advanced"]').val() == 'expanded') {
            $('#choose-city').html(data);
            if (typeof callbackSearchCourse === "function") {
                callbackSearchCourse('study-mode');
            } else {
                changeSearchCity();
            }
        } else {
            $('#choose-city').html('<option value="">' + please_choose_str + '</option>');
            $('#choose-program-name').html('<option value="">' + please_choose_str + '</option>');
            $('#choose-program-duration').html('<option value="">' + please_choose_str + '</option>');
        }
    });
}

function changeSearchCity() {
    $.post(url_search_program_name_list, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        language: $('#choose-language').val(),
        age: $('#choose-age').val(),
        country: $('#choose-country').val(),
        program_type: $('#choose-program-type').val(),
        study_mode: $('#choose-study-mode').val(),
        city: $('#choose-city').val()
    }, function (data) {
        $('#choose-program-name').html(data);
        if (typeof callbackSearchCourse === "function") {
            callbackSearchCourse('city');
        } else {
            changeSearchProgramName();
        }
    });
}

function changeSearchProgramName() {
    $.post(url_search_program_duration_list, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        language: $('#choose-language').val(),
        age: $('#choose-age').val(),
        country: $('#choose-country').val(),
        program_type: $('#choose-program-type').val(),
        study_mode: $('#choose-study-mode').val(),
        city: $('#choose-city').val(),
        program_name: $('#choose-program-name').val()
    }, function (data) {
        $('#choose-program-duration').html(data);
        if (typeof callbackSearchCourse === "function") {
            callbackSearchCourse('program-name');
        }
    });
}


function changeSchoolCountry() {
    var country = $('#country_name').val();
    var nationalities = $('select[name="nationality[]"]');
    for (var nationality_index = 0; nationality_index < nationalities.length; nationality_index++) {
        var nationality_options = $(nationalities[nationality_index]).find('option');
        for (var nationality_option_index = 0; nationality_option_index < nationality_options.length; nationality_option_index++) {
            if (country) {
                if (country == $(nationality_options[nationality_option_index]).val()) {
                    $(nationality_options[nationality_option_index]).hide();
                } else {
                    $(nationality_options[nationality_option_index]).show();
                }
            } else {
                $(nationality_options[nationality_option_index]).show();
            }
        }
    }
    if (country != '') {
        $.post(url_school_city_by_country_list, {_token: token, id: country}, function (data) {
            $('#city_name').html(data);
        });
    }
}

function changeSchool() {
    var school = $('#school_name').val();
    $.post(url_school_country_list, {
        _token: token,
        school: school,
        empty_value: $('#country_name').hasClass('3col') && $('#country_name').hasClass('active') ? false : true
    }, function (data) {
        $('#country_name').html(data);
        if ($('#country_name').hasClass('3col') && $('#country_name').hasClass('active')) {
            $('#country_name').multiselect('rebuild');
        }
        changeCountry();
    });
}

function changeCountry() {
    var school = $('#school_name').val();
    var country = $('#country_name').val();
    $.post(url_school_city_list, {
        _token: token,
        school: school,
        country: country,
        empty_value: $('#city_name').hasClass('3col') && $('#city_name').hasClass('active') ? false : true
    }, function (data) {
        $('#city_name').html(data);
        if ($('#city_name').hasClass('3col') && $('#city_name').hasClass('active')) {
            $('#city_name').multiselect('rebuild');
        }
        changeCity();
    });
}

function changeCity() {
    var school = $('#school_name').val();
    var country = $('#country_name').val();
    var city = $('#city_name').val();
    $.post(url_school_branch_list, {
        _token: token,
        school: school,
        country: country,
        city: city,
        empty_value: $('#branch_choose').hasClass('3col') && $('#branch_choose').hasClass('active') ? false : true
    }, function (data) {
        $('#branch_choose').html(data);
        if ($('#branch_choose').hasClass('3col') && $('#branch_choose').hasClass('active')) {
            $('#branch_choose').multiselect('rebuild');
        }
    });
}

function confirmDelete() {
    if (confirm(delete_on_confirm)) {
        return true;
    }

    return false;
}

function confirmClone() {
    if (confirm(clone_on_confirm)) {
        return true;
    }

    return false;
}

function submitCommonForBlogForm(urlname, typeMethod = "POST") {
    $("#loader").show();
    getCkEditorsData();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($("#formaction")[0]);
    if (typeMethod == 'PUT') {
        formData.append('_method', 'PUT');
    }
    $.ajax({
        type: "POST",
        url: urlname,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.errors) {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.catch_error) {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            } else {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-success').show();
                $('.alert-success p').html(data.data);
            }
        }
    });
}

function submitForm(object, method = 'POST') {
    $("#loader").show();
    getCkEditorsData();

    var formData = new FormData($(object)[0]);

    console.log($(object).attr('action'));
    urlname = $(object).attr('action');
    $.ajax({
        type: 'POST',
        url: urlname,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#loader").hide();

            if (data.errors) {
                document.documentElement.scrollTop = 0;

                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.catch_error) {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            } else if (data.success == true) {
                $("#loader").hide();

                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
            }
        },
        error: function (data) {
            $("#loader").hide();

            document.documentElement.scrollTop = 0;

            var rees = JSON.parse(data.responseText);
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in rees.errors) {
                $('.alert-danger ul').append('<li>' + rees.errors[error] + '</li>');
            }
        }
    });
}

function fillForm(form1, form2) {
    $(':input[name]', form1).each(function () {
        $('[name=' + $(this).attr('name') + ']', form2).val($(this).val())
    });

    $(':textarea[name]', form1).each(function () {
        $('[name=' + $(this).attr('name') + ']', form2).val($(this).val())
    });
}

function copyForms(form1, form2) {
    copyForms1(form1, form2);
    $(':input[name]', form2).val(function () {
        try {
            return $(':input[name=' + this.name + ']', form1).val();
        } catch (e) {
        }
    });
}

function copyForms1(form1, form2) {
    copyForms2(form1, form2);
    $(':input[type="number"]', form2).val(function () {
        return $(':input[name=' + this.name + ']', form1).val();
    });
}

function copyForms2(form1, form2) {
    $('textarea', form2).text(function () {
        return $('textarea[name=' + this.name + ']', form1).text();
    });
}

function changeLanguage(form_to_show, form_to_hide) {
    $("." + form_to_hide).hide();
    $("." + form_to_show).show();
}

/* First airport pickup function for getting airport service option  */
$('#airport_pickup').change(function () {
    $.post(url_for_airport, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        'airport_name': $('#airport_pickup').val()
    }, function (data) {
        $('#airport_service').html(data);
    });
});

/* 
 *
  Calculators
 *
 */
function calculateCourse(type) {
    var focus_val = '';
    if (type == 'requested_for_under_age') {
        focus_val = $('#under_age').val();
    } else if (type == 'select_program') {
        focus_val = $('#get_program_name').val();
    } else if (type == 'date_selected') {
        focus_val = $('#datepick').val();
    } else if (type == 'duration') {
        focus_val = $("#program_duration").val();
    }
    if (!focus_val) return;
    $('#loader').show();

    $.post(calculate_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        type: type,
        value: focus_val,
        school_id: $('[name="school_id"]').val(),
        course_unique_id: $('#get_program_name').val(),
        program_unique_id: $('#program_unique_id').val(),
        date_set: $('#datepick').val(),
        under_age: $('#under_age').val(),
        study_mode: $('#study_mode').val(),
        program_duration: $('#program_duration').val(),
        courier_fee: $("#checked_courier_fee").is(':checked'),
    }).done(function (data) {
        $('#loader').hide();

        var default_program_duration = $("#program_duration").val();
        if (type == 'requested_for_under_age') {
            if (data.program_get != undefined) {
                $('#get_program_name').html(data.program_get);
                $('#get_program_name').val('');
                $('#datepick').val('');
                $("#program_duration").val('');
            }
        } else if (type == 'select_program') {
            $("#program_information").html(data.program_information);
            $("#level_required").html(data.level_required);
            $("#lessons_per_week").html(data.lessons_per_week);
            $("#hours_per_week").html(data.hours_per_week);
            $("#study_time").html(data.study_time);
            $("#classes_day").html(data.classes_days);
            $("#start_date").html(data.start_date);

            if (data.availale_days != undefined) {
                datepicker_available_days = data.availale_days;
                if ($(".datepicker").length) {
                    var startDate;
                    if (datepicker_available_days.length) {
                        var posDay = datepicker_available_days[0];
                        var dayYear = parseInt(posDay.substr(0, 4));
                        var dayMonth = parseInt(posDay.substr(4, 2)) - 1;
                        var dayDay = parseInt(posDay.substr(6, 2));
                        $(".datepicker").datepicker("option", "minDate", $.datepicker.formatDate(datepicker_format, new Date(dayYear, dayMonth, dayDay)));
                        posDay = datepicker_available_days[datepicker_available_days.length - 1];
                        dayYear = parseInt(posDay.substr(0, 4));
                        dayMonth = parseInt(posDay.substr(4, 2)) - 1;
                        dayDay = parseInt(posDay.substr(6, 2));
                        $(".datepicker").datepicker("option", "maxDate", $.datepicker.formatDate(datepicker_format, new Date(dayYear, dayMonth, dayDay)));
                    } else {
                        startDate = new Date();
                        $(".datepicker").datepicker("option", "minDate", $.datepicker.formatDate(datepicker_format, startDate));
                        $(".datepicker").datepicker("option", "maxDate", null);
                    }
                }
            }
        } else if (type == 'date_selected') {
            if (data.program_duration != undefined) {
                $("#program_duration").html(data.program_duration);
            }
        } else if (type == 'duration') {
            if (data.courier_fee != undefined) {
                if (data.courier_fee) {
                    $("#courier_fee").show();
                    if (data.courier_fee_note != undefined) {
                        $("#expressMailingModal .modal-body").html(data.courier_fee_note);
                    } else {
                        $("#expressMailingModal .modal-body").html('');
                    }
                } else {
                    $("#courier_fee").hide();
                }
            }
            if (data.accommodations != undefined) {
                $('#accom_type').html(data.accommodations);
                $('#room_type').html(data.empty_option);
                $('#meal_type').html(data.empty_option);
                $('#accom_duration').html(data.empty_option);
                $('#accommodation_id').val('');
            }
            if (data.accommodations_visible != undefined) {
                if (data.accommodations_visible) {
                    $('#accommodation_fees').show();
                } else {
                    $('#accommodation_fees').hide();
                }
            } 
            if (data.airports != undefined) {
                $('#airport_service_provider').html(data.airports);
            }
            if (data.airports_visible != undefined) {
                if (data.airports_visible) {
                    $('#airport_service').show();
                } else {
                    $('#airport_service').hide();
                }
            }
            if (data.medicals != undefined) {
                $('#medical_company_name').html(data.medicals);
            }
            if (data.medicals_visible != undefined) {
                if (data.medicals_visible) {
                    $("#medical_service").show();
                } else {
                    $("#medical_service").hide();
                }
            }
            if (data.custodians_visible != undefined) {
                if (data.custodians_visible) {
                    $("#custodian_service").show();
                } else {
                    $("#custodian_service").hide();
                }
            } 
            if (data.airports_visible != undefined && data.medicals_visible != undefined && data.custodians_visible != undefined) {
                if (data.airports_visible || data.medicals_visible || data.custodians_visible) {
                    $("#other_services").show();
                } else {
                    $("#other_services").hide();
                }
            } else {
                $("#other_services").hide();
            }
            if (data.christmas_notification != undefined) {
                confirm(data.christmas_notification);
            }
        }

        resetAccommodation(true);
        resetOtherService(true); 
        reloadCourseCalclulator();

        if (typeof callbackCalculateCourse === "function") {
            callbackCalculateCourse(type);
        } else {
            setTimeout(function() {
                if (type == 'date_selected') {
                    if ($("#program_duration option").length) {
                        if (default_program_duration != $($("#program_duration option")[0]).attr('value')) {
                            $("#program_duration").val($($("#program_duration option")[0]).attr('value')).change();
                        }
                        calculateCourse('duration');
                    }
                }
                if (type == 'duration') {
                    calculateOtherService('');
                }
            }, 1000);
        }
    });
}

function reloadCourseCalclulator() {
    $.get(reload_calculate_url, function (data) {
        if (data.total != undefined) {
            $("#program_fees_table #program_cost .cost_value").html(data.program_cost.value);
            $("#program_fees_table #program_cost .converted_value").html(parseFloat(data.program_cost.converted_value).toFixed(2));
            $("#program_fees_table #registration_fee .cost_value").html(data.registration_fee.value);
            $("#program_fees_table #registration_fee .converted_value").html(parseFloat(data.registration_fee.converted_value).toFixed(2));
            $("#program_fees_table #text_book_fee .cost_value").html(data.text_book_fee.value);
            $("#program_fees_table #text_book_fee .converted_value").html(parseFloat(data.text_book_fee.converted_value).toFixed(2));
            $("#program_fees_table #summer_fees .cost_value").html(data.summer_fees.value);
            $("#program_fees_table #summer_fees .converted_value").html(parseFloat(data.summer_fees.converted_value).toFixed(2));
            if (parseFloat(data.summer_fees.value)) $("#program_fees_table #summer_fees").show(); else $("#program_fees_table #summer_fees").hide();
            $("#program_fees_table #peak_time_fees .cost_value").html(data.peak_time_fees.value);
            $("#program_fees_table #peak_time_fees .converted_value").html(parseFloat(data.peak_time_fees.converted_value).toFixed(2));
            if (parseFloat(data.peak_time_fees.value)) $("#program_fees_table #peak_time_fees").show(); else $("#program_fees_table #peak_time_fees").hide();
            $("#program_fees_table #under_age_fees .cost_value").html(data.under_age_fees.value);
            $("#program_fees_table #under_age_fees .converted_value").html(parseFloat(data.under_age_fees.converted_value).toFixed(2));
            if (parseFloat(data.under_age_fees.value)) $("#program_fees_table #under_age_fees").show(); else $("#program_fees_table #under_age_fees").hide();
            $("#program_fees_table #express_mail_fee .cost_value").html(data.express_mail_fee.value);
            $("#program_fees_table #express_mail_fee .converted_value").html(parseFloat(data.express_mail_fee.converted_value).toFixed(2));
            if (parseFloat(data.express_mail_fee.value)) $("#program_fees_table #express_mail_fee").show(); else $("#program_fees_table #express_mail_fee").hide();
            $("#program_fees_table #discount_fee .cost_value").html("-" + data.discount_fee.value);
            $("#program_fees_table #discount_fee .converted_value").html("-" + parseFloat(data.discount_fee.converted_value).toFixed(2));
            $("#program_fees_table #program_total .cost_value").html(data.total.value);
            $("#program_fees_table #program_total .converted_value").html(parseFloat(data.total.converted_value).toFixed(2));

            $("#program_fees_table .cost_currency").html(data.currency.cost);
            $("#program_fees_table .converted_currency").html(data.currency.converted);

            $("#total_table .total_cost").html(parseFloat(data.overall_total.value).toFixed(2));
            $("#total_table .total_converted").html(parseFloat(data.overall_total.converted_value).toFixed(2));
            $("#total_table .total_cost_currency").html(data.currency.cost);
            $("#total_table .total_converted_currency").html(data.currency.converted);

            $("#total_fees").val(data.overall_total.value);
            $("#total_fees_to_save_to_db").val(data.overall_total.value + " " + data.currency.cost);
            $("#other_currency_to_save_to_db").val(parseFloat(data.overall_total.converted_value).toFixed(2) + " " + data.currency.converted)
        }
    }).done(function () {
        $('#loader').hide();
    })
}

function calcuateAccommodation() {
    if ($('#meal_type').val() != '') {
        $('#loader').show();
        $.post(calculate_accommodation_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            date_set: $('#datepick').val(),
            program_duration: $("#program_duration").val(),
            age: $('#under_age').val(),
            accom_type: $('#accom_type').val(),
            room_type: $('#room_type').val(),
            meal_type: $('#meal_type').val(),
            duration: $('#accom_duration').val(),
            special_diet: $("#special_diet_check").is(':checked'),
        }, function (data) {
            reloadCourseCalclulator();
            resetOtherService(true);

            $("#accommodation_fees #accommodation_fee .cost_value").html(data.accom_fee.value);
            $("#accommodation_fees #accommodation_fee .converted_value").html(parseFloat(data.accom_fee.converted_value).toFixed(2));
            $("#accommodation_fees #accommodation_placement_fee .cost_value").html(data.placement_fee.value);
            $("#accommodation_fees #accommodation_placement_fee .converted_value").html(parseFloat(data.placement_fee.converted_value).toFixed(2));
            $("#accommodation_fees #accommodation_special_diet_fee .cost_value").html(data.special_diet_fee.value);
            $("#accommodation_fees #accommodation_special_diet_fee .converted_value").html(parseFloat(data.special_diet_fee.converted_value).toFixed(2));
            if (parseFloat(data.special_diet_fee.value)) $("#accommodation_fees #accommodation_special_diet_fee").show(); else $("#accommodation_fees #accommodation_special_diet_fee").hide();
            $("#accommodation_fees #accommodation_deposit_fee .cost_value").html(data.deposit_fee.value);
            $("#accommodation_fees #accommodation_deposit_fee .converted_value").html(parseFloat(data.deposit_fee.converted_value).toFixed(2));
            if (parseFloat(data.deposit_fee.value)) $("#accommodation_fees #accommodation_deposit_fee").show(); else $("#accommodation_fees #accommodation_deposit_fee").hide();
             $("#accommodation_fees #accommodation_summer_fees .cost_value").html(data.summer_fee.value);
            $("#accommodation_fees #accommodation_summer_fees .converted_value").html(parseFloat(data.summer_fee.converted_value).toFixed(2));
            if (parseFloat(data.summer_fee.value)) $("#accommodation_fees #accommodation_summer_fees").show(); else $("#accommodation_fees #accommodation_summer_fees").hide();
            $("#accommodation_fees #accommodation_peak_fees .cost_value").html(data.peak_fee.value);
            $("#accommodation_fees #accommodation_peak_fees .converted_value").html(parseFloat(data.peak_fee.converted_value).toFixed(2));
            if (parseFloat(data.peak_fee.value)) $("#accommodation_fees #accommodation_peak_fees").show(); else $("#accommodation_fees #accommodation_peak_fees").hide();
            $("#accommodation_fees #accommodation_christmas_fees .cost_value").html(data.christmas_fee.value);
            $("#accommodation_fees #accommodation_christmas_fees .converted_value").html(parseFloat(data.christmas_fee.converted_value).toFixed(2));
            if (parseFloat(data.christmas_fee.value)) $("#accommodation_fees #accommodation_christmas_fees").show(); else $("#accommodation_fees #accommodation_christmas_fees").hide();
            $("#accommodation_fees #accommodation_under_age_fees .cost_value").html(data.under_age_fee.value);
            $("#accommodation_fees #accommodation_under_age_fees .converted_value").html(parseFloat(data.under_age_fee.converted_value).toFixed(2));
            if (parseFloat(data.under_age_fee.value)) $("#accommodation_fees #accommodation_under_age_fees").show(); else $("#accommodation_fees #accommodation_under_age_fees").hide();
            $("#accommodation_fees #accommodation_discount_fee .cost_value").html("-" + data.discount_fee.value);
            $("#accommodation_fees #accommodation_discount_fee .converted_value").html("-" + parseFloat(data.discount_fee.converted_value).toFixed(2));

            $("#accommodation_fees #accommodation_total .cost_value").html(parseFloat(data.total.value).toFixed(2));
            $("#accommodation_fees #accommodation_total .converted_value").html(parseFloat(data.total.converted_value).toFixed(2));
            
            $("#accommodation_fees .cost_currency").html(data.currency.cost);
            $("#accommodation_fees .converted_currency").html(data.currency.converted);
            
            $("#total_table .total_cost").html(parseFloat(data.overall_total.value).toFixed(2));
            $("#total_table .total_converted").html(parseFloat(data.overall_total.converted_value).toFixed(2));
            $("#total_table .total_cost_currency").html(data.currency.cost);
            $("#total_table .total_converted_currency").html(data.currency.converted);

            $("#total_fees").val(data.overall_total.value);
            $("#total_fees_to_save_to_db").val(data.overall_total.value + " " + data.currency.cost);
            $("#other_currency_to_save_to_db").val(parseFloat(data.overall_total.converted_value).toFixed(2) + " " + data.currency.converted);

            $('#accommodation_fees_table').show();
            
            if (data.special_diet != undefined) {
                if (data.special_diet) {
                    $('#special_diet').show();
                    if (data.special_diet_note != undefined) {
                        $("#specialDietModal .modal-body").html(data.special_diet_note);
                    } else {
                        $("#specialDietModal .modal-body").html('');
                    }
                } else {
                    $('#special_diet').hide();
                }
            }

            if (typeof callbackChangeAccommodation === "function") {
                callbackChangeAccommodation('calculate');
            }
        }).done(function () {
            $("#loader").hide();
        });
    }
}

function resetAccommodation(init = false) {
    if (init) {
        $('#accom_type')[0].selectedIndex = 0;
        $('#accom_duration')[0].selectedIndex = 0;
        $('#accommodation_id').val('');
        $('#special_diet').hide();
    }
    $.get(reset_accommodation_url, function () {
        $("#accommodation_fees #accommodation_fee .cost_value").html(0);
        $("#accommodation_fees #accommodation_fee .converted_value").html(0);
        $("#accommodation_fees #accommodation_placement_fee .cost_value").html(0);
        $("#accommodation_fees #accommodation_placement_fee .converted_value").html(0);
        $("#accommodation_fees #accommodation_special_diet_fee .cost_value").html(0);
        $("#accommodation_fees #accommodation_special_diet_fee .converted_value").html(0);
        $("#accommodation_fees #accommodation_deposit_fee .cost_value").html(0);
        $("#accommodation_fees #accommodation_deposit_fee .converted_value").html(0);
        $("#accommodation_fees #accommodation_summer_fees .cost_value").html(0);
        $("#accommodation_fees #accommodation_summer_fees .converted_value").html(0);
        $("#accommodation_fees #accommodation_peak_fees .cost_value").html(0);
        $("#accommodation_fees #accommodation_peak_fees .converted_value").html(0);
        $("#accommodation_fees #accommodation_christmas_fees .cost_value").html(0);
        $("#accommodation_fees #accommodation_christmas_fees .converted_value").html(0);
        $("#accommodation_fees #accommodation_under_age_fees .cost_value").html(0);
        $("#accommodation_fees #accommodation_under_age_fees .converted_value").html(0);
        $("#accommodation_fees #accommodation_discount_fee .cost_value").html(0);
        $("#accommodation_fees #accommodation_discount_fee .converted_value").html(0);
        $("#accommodation_fees #accommodation_total .cost_value").html(0);
        $("#accommodation_fees #accommodation_total .converted_value").html(0);
        $("#accommodation_fees .cost_currency").html('');
        $("#accommodation_fees .converted_currency").html('');
        $('#accommodation_fees_table').hide();
    })
}

function calculateOtherService(type) {
    $.post(other_service_fee_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        program_duration: $('#program_duration').val(),
        airport_service_provider: $('#airport_service_provider').val(),
        airport_name: $('#airport_name').val(),
        airport_service: $('#airport_type_of_service').val(),
        medical_company_name: $('#medical_company_name').val(),
        medical_deductible: $('#medical_deductible_up_to').val(),
        medical_duration: $('#medical_duration').val(),
        under_age: $('#under_age').val(),
        custodianship: $('#custodianship_check').is(':checked'),
    }, function (data) {
        $("#other_service_fees_table #airport_pickup .cost_value").html(data.airport_fee.value);
        $("#other_service_fees_table #airport_pickup .converted_value").html(parseFloat(data.airport_fee.converted_value).toFixed(2));
        if (data.airport_fee.value) {
            $("#other_service_fees_table #airport_pickup").show();
        } else {
            $("#other_service_fees_table #airport_pickup").hide();
        }
        $("#other_service_fees_table #medical_insurance .cost_value").html(data.medical_fee.value);
        $("#other_service_fees_table #medical_insurance .converted_value").html(parseFloat(data.medical_fee.converted_value).toFixed(2));
        if (data.medical_fee.value) {
            $("#other_service_fees_table #medical_insurance").show();
        } else {
            $("#other_service_fees_table #medical_insurance").hide();
        }
        $("#other_service_fees_table #custodian_fee .cost_value").html(data.custodian_fee.value);
        $("#other_service_fees_table #custodian_fee .converted_value").html(parseFloat(data.custodian_fee.converted_value).toFixed(2));
        if (data.custodian_fee.value) {
            $("#other_service_fees_table #custodian_fee").show();
        } else {
            $("#other_service_fees_table #custodian_fee").hide();
        }
        $("#other_service_fees_table #other_service_total .cost_value").html(data.total.value);
        $("#other_service_fees_table #other_service_total .converted_value").html(parseFloat(data.total.converted_value).toFixed(2));
        
        $("#other_service_fees_table .cost_currency").html(data.currency.cost);
        $("#other_service_fees_table .converted_currency").html(data.currency.converted);
        
        $("#total_table .total_cost").html(parseFloat(data.overall_total.value).toFixed(2));
        $("#total_table .total_converted").html(parseFloat(data.overall_total.converted_value).toFixed(2));
        $("#total_table .total_cost_currency").html(data.currency.cost);
        $("#total_table .total_converted_currency").html(data.currency.converted);

        $("#other_service_fees_table").show();

        $("#total_fees").val(data.overall_total.value);
        $("#total_fees_to_save_to_db").val(data.overall_total.value + " " + data.currency.cost);
        $("#other_currency_to_save_to_db").val(parseFloat(data.overall_total.converted_value).toFixed(2) + " " + data.currency.converted);

        $("#AirportPickupModal .modal-body").html(data.airport_note);
        $("#MedicalInsuranceModal .modal-body").html(data.medical_note);
        
        $('#airport_id').html(data.airport_id);
        $('#airport_fee_id').html(data.airport_fee_id);
        $('#medical_id').html(data.medical_id);

        if (typeof callbackCalculateOtherService === "function") {
            callbackCalculateOtherService(type);
        }
    });
}

function resetOtherService(init = false) {
    if (init) {
        $('#airport_service_provider')[0].selectedIndex = '';
        $("#airport_type_of_service")[0].selectedIndex = '';
        $('#airport_id').val('');
        $('#airport_fee_id').val('');

        $('#medical_company_name')[0].selectedIndex = '';
        $('#medical_duration')[0].selectedIndex = '';
        $('#medical_id').val('');

        $('#custodianship_check').prop('checked', false);
    }
    $.get(reset_other_service_url, function () {
        $("#other_services #airport_pickup .cost_value").html(0);
        $("#other_services #airport_pickup .converted_value").html(0);
        $("#other_services #medical_insurance .cost_value").html(0);
        $("#other_services #medical_insurance .converted_value").html(0);
        $("#other_services #custodian_fee .cost_value").html(0);
        $("#other_services #custodian_fee .converted_value").html(0);
        $("#other_services .cost_currency").html('');
        $("#other_services .converted_currency").html('');
        $("#other_service_fees_table").hide();
    })
}

function discountPrice(value, form_token = '') {
    if (value != '') {
        $.post(calculate_discount_url, {
            _token: form_token ? form_token : token,
            date_set: $('#datepick').val(),
            value: value,
        }, function (data) {
        }).done(function (data) {
            reloadCourseCalclulator();
            $('#loader').hide();
        });
    }
}

$(document).ready(function() {
    $('#under_age').change(function () {
        calculateCourse('requested_for_under_age');
    });

    $('#accom_type').change(function () {
        $.post(accomm_rooms_meals_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            accom_type: $('#accom_type').val(),
            age_selected: $('#under_age').val()
        }, function (data) {
            $('#room_type').html(data.room_type);
            $('#meal_type').html(data.meal_type);
            $('#accom_duration').val('');
            $('#accommodation_id').val('');

            if (typeof callbackChangeAccommodation === "function") {
                callbackChangeAccommodation('accom_type');
            }
        });
    });

    $('#room_type').change(function () {
        $.post(accomm_meals_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            accom_type: $('#accom_type').val(),
            room_type: $('#room_type').val(),
            age_selected: $('#under_age').val()
        }, function (data) {
            $('#meal_type').html(data.meal_type);
            $('#accom_duration').val('');
            $('#accommodation_id').val('');

            if (typeof callbackChangeAccommodation === "function") {
                callbackChangeAccommodation('room_type');
            }
        });
    });

    $('#meal_type').change(function () {
        $.post(accomm_durations_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            accom_type: $('#accom_type').val(),
            room_type: $('#room_type').val(),
            meal_type: $('#meal_type').val(),
            program_duration: $("#program_duration").val()
        }, function (data) {
            $('#accom_duration').html(data.duration);
            $('#accom_duration').val('');
            $('#accommodation_id').val(data.accommodation_id);

            if (typeof callbackChangeAccommodation === "function") {
                callbackChangeAccommodation('meal_type');
            }
        });
    });

    if ($("#program_duration option").length) {
        $("#program_duration").val($($("#program_duration option")[0]).attr('value')).change();
        calculateCourse('duration', $("#program_duration").val());
    }

    $('#airport_service_provider').change(function () {
        var airport_service_provider = $('#airport_service_provider option:selected').val() ? jQuery.trim($('#airport_service_provider option:selected').text()) : '';
        $.post(airport_names_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            service_provider: airport_service_provider
        }, function (data) {
            $('#airport_name').html(data);

            if (typeof callbackChangeAirport === "function") {
                callbackChangeAirport('service_provider');
            }
        });
    });

    $('#airport_name').change(function () {
        var airport_service_provider = $('#airport_service_provider option:selected').val() ? jQuery.trim($('#airport_service_provider option:selected').text()) : '';
        var airport_name = $('#airport_name option:selected').val() ? jQuery.trim($('#airport_name option:selected').text()) : '';
        $.post(airport_services_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            service_provider: airport_service_provider,
            name: airport_name
        }, function (data) {
            $('#airport_type_of_service').html(data);

            if (typeof callbackChangeAirport === "function") {
                callbackChangeAirport('name');
            }
        });
    });

    $('#airport_type_of_service').change(function () {
        calculateOtherService('airport');
    });

    $('#medical_company_name').change(function () {
        var medical_company_name = $('#medical_company_name option:selected').val() ? jQuery.trim($('#medical_company_name option:selected').text()) : '';
        $.post(medical_deductibles_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            company_name: medical_company_name
        }, function (data) {
            $('#medical_deductible_up_to').html(data);

            if (typeof callbackChangeMedical === "function") {
                callbackChangeMedical('company_name');
            }
        });
    });

    $('#medical_deductible_up_to').change(function () {
        var program_duration = $('#program_duration').val();
        var medical_company_name = $('#medical_company_name option:selected').val() ? jQuery.trim($('#medical_company_name option:selected').text()) : '';
        var medical_deductible = $('#medical_deductible_up_to option:selected').val() ? jQuery.trim($('#medical_deductible_up_to option:selected').text()) : '';
        $.post(medical_durations_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            program_duration: program_duration,
            company_name: medical_company_name,
            deductible: medical_deductible,
        }, function (data) {
            $('#medical_duration').html(data);

            if (typeof callbackChangeMedical === "function") {
                callbackChangeMedical('deductible_up_to');
            }
        });
    });

    $('#medical_duration').change(function () {
        calculateOtherService('medical');
    });
});


function submitCourseForm(object) {
    $("#loader").show();
    getCkEditorsData();

    var formurl = $(object).parents().find('#form1').attr('action');
    var formData = new FormData($(object).parents().find('#form1')[0]);
    $.ajax({
        type: 'POST',
        url: formurl,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == 'success') {
                $("#loader").show();
                setTimeout(function () {
                    window.location.replace(program_under_age_url);
                }, 2000)
            }
            if (data.errors) {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.catch_error) {
                console.log(data.catch_error);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            } else if (data.success == 'success') {
                $("#loader").hide();

                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
            }
        }
    });
}

function updateCourseForm(object) {
    $("#loader").show();
    getCkEditorsData();

    var urlname = $(object).parents().find('#form1').attr('action');
    var formData = new FormData($(object).parents().find('#form1')[0]);
    $.ajax({
        type: 'POST',
        url: urlname,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == 'success') {
                $("#loader").show();
                setTimeout(function () {
                    window.location.replace(edit_program_under_age_url);
                }, 2000)
            }
            if (data.errors) {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.catch_error) {
                console.log(data.catch_error);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();

                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            } else if (data.success == 'success') {
                $("#loader").hide();

                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
            }
        }
    });
}

function submitCourseProgramForm(this_object) {
    $('#loader').show();
    getCkEditorsData();

    var courseProgramForm = $(this_object).parents().find('#courseform');
    var url_submit = $(courseProgramForm).attr('action');
    var form = new FormData($(courseProgramForm)[0]);
    $.ajax({
        type: 'POST',
        url: url_submit,
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('#loader').hide();
            if (data.success == 'success') {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;

                if ($(courseProgramForm).data('mode') == 'create') {
                    window.location.href = edit_program_under_age_url;
                }
            } else if (data.errors) {
                document.documentElement.scrollTop = 0;
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.catch_error) {
                console.log(data.catch_error);
                document.documentElement.scrollTop = 0;

                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            }
        }
    });
}

function submitAccommodationForm(object) {
    $('#loader').show();
    getCkEditorsData();

    var urlfor = $(object).parents().find('#courseform').attr('action');
    var accommodationForm = $(object).parents().find('#courseform');

    var formData = new FormData($(accommodationForm)[0]);
    $.ajax({
        type: 'POST',
        url: urlfor,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('#loader').hide();
            if (data.success == 'success') {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;

                if ($(accommodationForm).data('mode') == 'create') {
                    window.location.href = edit_accommodation_url;
                }
            } else if (data.errors) {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.catch_error) {
                console.log(data.catch_error);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            }
        }
    });
}

function submitAccommodationUnderAgeForm(object, reload = false) {
    $('#loader').show();
    getCkEditorsData();

    var urlname = (object.parents().find('#accommodation_under_age_form').attr('action'));
    var form = $(object).parents().find('#accommodation_under_age_form');
    var formData = new FormData($(form)[0]);
    $.ajax({
        type: 'POST',
        url: urlname,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('#loader').hide();

            if (data.errors) {
                document.documentElement.scrollTop = 0;
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }

                if ($(form).data('mode') == 'create') {
                    window.location.href = edit_accomm_under_age_url;
                }
            } else if (data.success == 'success') {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                if (reload) {
                    window.location.reload();
                }
            } else if (data.catch_error) {
                console.log(data.catch_error);
                document.documentElement.scrollTop = 0;

                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            }
        }
    });
}

function submitOtherServiceForm(object, reload = false) {
    $("#loader").show();
    getCkEditorsData();

    var urlname = $(object).parents().find('#courseform').attr('action');
    var form = $(object).parents().find('#courseform');
    var formData = new FormData($(form)[0]);
    $.ajax({
        type: 'POST',
        url: urlname,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success == 'success') {
                $("#loader").hide();
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;                

                if ($(form).data('mode') == 'create') {
                    window.location.href = edit_other_service_url;
                }
            } else if (data.errors) {
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.catch_error) {
                console.log(data.catch_error);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            }
        },
    });
}

/*
* Visa Form ADd Field function
*
* */
function submitVisaApplication(object) {
    $("#loader").show();
    getCkEditorsData();

    var urlname = ($(object).parents().find('#visa-form').attr('action'));
    var formobject = new FormData($(object).parents().find('#visa-form')[0]);
    $.ajax({
        type: 'POST',
        url: urlname,
        data: formobject,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#loader").hide();
            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
            } else if (data.errors) {
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
            document.documentElement.scrollTop = 0;
        },
        error: function (data) {
            $("#loader").hide();
            close_button.click();
            var rees = JSON.parse(data.responseText);

            $('.alert-danger').show();
            $('.alert-danger ul').html('');

            for (var error in rees.errors) {
                $('.alert-danger ul').append('<li>' + rees.errors[error] + '</li>');
            }
            document.documentElement.scrollTop = 0;
        }
    });
}


//////
function addLanguage(english_name, arabic_name) {
    $("#loader").show();

    $.post(add_language_url, {_token: token, english_name: english_name, arabic_name: arabic_name}, function (data) {
        $("button[class='close']").click();
    }).done(function (data) {
        var models_dropdown = $("#language_choose");

        $('.alert-success').show();
        $('.alert-success p').html(data.data);

        models_dropdown.append(data.result);
        document.documentElement.scrollTop = 0;
        $("#language_choose").multiselect('rebuild');
        $("#loader").hide();
    });
}

function deleteLanguage() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#language_choose option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_language_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#language_choose").html(data.result);
                document.documentElement.scrollTop = 0;
                $("#language_choose").multiselect('rebuild');
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
            });

        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addStudyMode(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_study_mode_url, {_token: token, english_val: english_val, arabic_val: arabic_val}, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var models_dropdown = $("#study_mode_choose");

            $('.alert-success').show();
            $('.alert-success p').html(data.data);

            models_dropdown.append(data.result);
            document.documentElement.scrollTop = 0;
            $("#study_mode_choose").multiselect('rebuild');
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

function deleteStudyMode() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#study_mode_choose option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_study_mode_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#study_mode_choose").html(data.result);
                document.documentElement.scrollTop = 0;
                $("#study_mode_choose").multiselect('rebuild');
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addProgramType(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_program_type_url, {
            _token: token,
            english_val: english_val,
            arabic_val: arabic_val
        }, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var models_dropdown = $("#program_type_choose");

            $('.alert-success').show();
            $('.alert-success p').html(data.data);

            models_dropdown.append(data.result);
            document.documentElement.scrollTop = 0;
            $("#program_type_choose").multiselect('rebuild');
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteProgramType() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#program_type_choose option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_program_type_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#program_type_choose").html(data.result);
                document.documentElement.scrollTop = 0;
                $("#program_type_choose").multiselect('rebuild');
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addBranch(english_name, arabic_name) {
    $("#loader").show();

    $.post(add_branch_url, {_token: token, english_name: english_name, arabic_name: arabic_name}, function (data) {
        $("button[class='close']").click();
    }).done(function (data) {
        var models_dropdown = $("#branch_choose");

        $('.alert-success').show();
        $('.alert-success p').html(data.data);

        models_dropdown.append(data.result);
        document.documentElement.scrollTop = 0;
        $("#loader").hide();
    });
}

function deleteBranch() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#branch_choose option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_branch_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#branch_choose").html(data.result);
                document.documentElement.scrollTop = 0;
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
            });

        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addStudyTime(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_study_time_url, {_token: token, english_val: english_val, arabic_val: arabic_val}, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var models_dropdown = $("#study_time_choose");

            $('.alert-success').show();
            $('.alert-success p').html(data.data);

            models_dropdown.append(data.result);
            document.documentElement.scrollTop = 0;
            $("#study_time_choose").multiselect('rebuild');
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteStudyTime() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#study_time_choose option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_study_time_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#study_time_choose").html(data.result);
                document.documentElement.scrollTop = 0;
                $("#study_time_choose").multiselect('rebuild');
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addClassesDay(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_classes_day_url, {_token: token, english_val: english_val, arabic_val: arabic_val}, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var models_dropdown = $("#classes_day_choose");

            $('.alert-success').show();
            $('.alert-success p').html(data.data);

            models_dropdown.append(data.result);
            document.documentElement.scrollTop = 0;
            $("#classes_day_choose").multiselect('rebuild');
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

function deleteClassesDay() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#classes_day_choose option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_classes_day_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#classes_day_choose").html(data.result);
                document.documentElement.scrollTop = 0;
                $("#classes_day_choose").multiselect('rebuild');
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addStartDate(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_start_day_url, {_token: token, english_val: english_val, arabic_val: arabic_val}, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var models_dropdown = $("#start_date_choose");

            $('.alert-success').show();
            $('.alert-success p').html(data.data);

            models_dropdown.append(data.result);
            document.documentElement.scrollTop = 0;
            $("#start_date_choose").multiselect('rebuild');
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteStartDate() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#start_date_choose option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_start_day_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#start_date_choose").html(data.result);
                document.documentElement.scrollTop = 0;
                $("#start_date_choose").multiselect('rebuild');
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addProgramAgeRange(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_program_age_range_url, {
            _token: token,
            english_val: english_val,
            arabic_val: arabic_val
        }, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var models_dropdown = $("#program_age_range_choose" + program_age_range);

            $('.alert-success').show();
            $('.alert-success p').html(data.data);

            models_dropdown.append(data.result);

            models_dropdown.multiselect('rebuild');
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteProgramAgeRange() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#program_age_range_choose" + program_age_range + " option:selected"), function () {
        ids.push($(this).val());
    });
    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_program_age_range_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#program_age_range_choose" + program_age_range).html(data.result);
                document.documentElement.scrollTop = 0;
                $("#program_age_range_choose" + program_age_range).multiselect('rebuild');
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addProgramUnderAgeRange(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_program_under_age_range_url, {
            _token: token,
            english_val: english_val,
            arabic_val: arabic_val
        }, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var models_dropdown = $("#program_under_age_range_choose" + rowNum);

            $('.alert-success').show();
            $('.alert-success p').html(data.data);

            models_dropdown.append(data.result);
            models_dropdown.multiselect('rebuild');
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteProgramUnderAgeRange() {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($("#program_under_age_range_choose option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_program_under_age_range_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                $("#program_under_age_range_choose").html(data.result);
                $("#program_under_age_range_choose").multiselect('rebuild');
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addAccommAgeRange(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_accomm_age_range_url, {_token: token, english_val: english_val, arabic_val: arabic_val}, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            $('.alert-success').show();
            $('.alert-success p').html(data.data);

            var accomm_age_range_index = 0;
            while(true) {
                var models_dropdown = $("#accom_age_choose" + accomm_age_range_index);
                if (models_dropdown.length) {
                    models_dropdown.append(data.result);
                    models_dropdown.multiselect('rebuild');
                } else {
                    break;
                }
                accomm_age_range_index++;
            }
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteAccommAgeRange(object) {
    var ids = [];
    var token = $("meta[name='csrf-token']").attr('content');
    $.each($(object).find("option:selected"), function () {
        ids.push($(this).val());
    });
    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_accomm_age_range_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                var accomm_age_range_index = 0;
                while(true) {
                    var models_dropdown = $("#accom_age_choose" + accomm_age_range_index);
                    if (models_dropdown.length) {
                        models_dropdown.html(data.result);
                        models_dropdown.multiselect('rebuild');
                    } else {
                        break;
                    }
                    accomm_age_range_index++;
                }
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;

                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addCustodianAgeRange(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_accomm_custodian_range_url, {
            _token: token,
            english_val: english_val,
            arabic_val: arabic_val
        }, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var custodian_age_range_index = 0;
            while(true) {
                var models_dropdown = $("#custodian_age_range_choose" + custodian_age_range_index);
                if (models_dropdown.length) {
                    models_dropdown.append(data.result);
                    models_dropdown.multiselect('rebuild');
                } else {
                    break;
                }
                custodian_age_range_index++;
            }

            $('.alert-success').show();
            $('.alert-success p').html(data.data);
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteCustodianAgeRange(object) {
    var ids = [];
    var token = $("meta[name='csrf-token']").attr('content');
    $.each($(object).find("option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_accomm_custodian_range_url, {
                _method: 'DELETE', _token: token, ids: ids
            }, function (data) {
                var custodian_age_range_index = 0;
                while(true) {
                    var models_dropdown = $("#custodian_age_range_choose" + custodian_age_range_index);
                    if (models_dropdown.length) {
                        models_dropdown.html(data.result);
                        models_dropdown.multiselect('rebuild');
                    } else {
                        break;
                    }
                    custodian_age_range_index++;
                }
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);

                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


//////
function addAccommUnderAgeRange(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_accomm_under_range_url, {
            _token: token, english_val: english_val, arabic_val: arabic_val
        }, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var accomm_age_range_index = 0;
            while(true) {
                var models_dropdown = $("#accommodation_under_age_choose" + accomm_age_range_index);
                if (models_dropdown.length) {
                    models_dropdown.append(data.result);
                    models_dropdown.multiselect('rebuild');
                } else {
                    break;
                }
                accomm_age_range_index++;
            }
            $('.alert-success').show();
            $('.alert-success p').html(data.data);
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteAccommUnderAgeRange(object) {
    var ids = [];

    var token = $("meta[name='csrf-token']").attr('content');
    $.each($(object).find("option:selected"), function () {
        ids.push($(this).val());
    });
    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_accomm_under_range_url, {_method: 'DELETE', _token: token, ids: ids}, function (data) {
                var custodian_age_range_index = 0;
                while(true) {
                    var models_dropdown = $("#accommodation_under_age_choose" + custodian_age_range_index);
                    if (models_dropdown.length) {
                        models_dropdown.html(data.result);
                        models_dropdown.multiselect('rebuild');
                    } else {
                        break;
                    }
                    custodian_age_range_index++;
                }
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);

                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


function addApplyFrom(object) {
    $("#loader").show();
    var urlname = $(object).parents().find('#form_apply').attr('action');
    var formdata = new FormData($(object).parents().find('#form_apply')[0]);
    var close_button = ($(object).parents().find('#close_this'));

    $.ajax({
        url: urlname,
        method: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;

                close_button.click();
                $("#applying_from").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                close_button.click();

                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        },
        error: function (data) {
            $("#loader").hide();

            close_button.click();
            var rees = JSON.parse(data.responseText);
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in rees.errors) {
                $('.alert-danger ul').append('<li>' + rees.errors[error] + '</li>');
            }
        }
    });
}

function deleteApplyFrom(object) {
    var urlname = $(object).attr('data-url');
    var applying_from = ($(object).parents().find('#applying_from option:selected').val());
    if (applying_from == '') {
        alert("Select Some option")
        return;
    }
    $("#loader").show();
    $.ajax({
        url: urlname,
        method: 'POST',
        data: {
            _token: $("meta[name='csrf-token']").attr('content'),
            applying_from: applying_from
        },
        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#applying_from").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        },
        error: function (data) {
            var rees = JSON.parse(data.responseText);
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in rees.errors) {
                $('.alert-danger ul').append('<li>' + rees.errors[error] + '</li>');
            }
        }
    });
}

function addApplicationCenter(object) {
    $("#loader").show();
    var urlname = $(object).parents().find('#application_form').attr('action');
    var formdata = new FormData($(object).parents().find('#application_form')[0]);
    var close_button = ($(object).parents().find('#close_this'));

    $.ajax({
        url: urlname,
        method: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                close_button.click();
                $("#application_center").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        },
        error: function (data) {
            $("#loader").hide();

            close_button.click();
            var rees = JSON.parse(data.responseText);
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in rees.errors) {
                $('.alert-danger ul').append('<li>' + rees.errors[error] + '</li>');
            }
        }
    });
}

function deleteApplicationCenter(object) {
    var urlname = $(object).attr('data-url');
    var application_centers = $("#application_center").val();

    console.log(application_centers);
    if (application_centers == '') {
        alert("Select Some option")
        return;
    }
    $("#loader").show();
    $.ajax({
        url: urlname,
        method: 'POST',
        data: {_token: $("meta[name='csrf-token']").attr('content'), application_center: application_centers},

        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#application_center").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        }
    });
}

function addNationality(object) {
    $("#loader").show();
    var urlname = $(object).parents().find('#add_nationailty_form').attr('action');
    var formdata = new FormData($(object).parents().find('#add_nationailty_form')[0]);
    var close_button = ($(object).parents().find('#close_this'));

    $.ajax({
        url: urlname,
        method: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;

                close_button.click();
                $("#nationality_select").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                close_button.click();

                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        },
        error: function (data) {
            $("#loader").hide();

            close_button.click();
            var rees = JSON.parse(data.responseText);

            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in rees.errors) {
                $('.alert-danger ul').append('<li>' + rees.errors[error] + '</li>');
            }
        }
    });
}

function deleteNationality(object) {
    var urlname = $(object).attr('data-url');
    var nationality = $('#nationality_select').val();

    if (nationality == '') {
        alert("Select Some option");
        return;
    }
    $("#loader").show();
    $.ajax({
        url: urlname,
        method: 'POST',
        data: {_token: $("meta[name='csrf-token']").attr('content'), application_center: nationality},

        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#nationality_select").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        }
    });
}


//////
function addSchoolNationality(english_val, arabic_val) {
    if (english_val != '' && arabic_val != '') {
        $("#loader").show();
        $.post(add_school_nationality_url, {
            _token: token,
            english_val: english_val,
            arabic_val: arabic_val
        }, function (data) {
            $("button[class='close']").click();
        }).done(function (data) {
            var school_nationality_index = 0;
            while(true) {
                var models_dropdown = $("#school_nationality_choose" + school_nationality_index);
                if (models_dropdown.length) {
                    models_dropdown.append(data.result);
                } else {
                    break;
                }
                school_nationality_index++;
            }

            $('.alert-success').show();
            $('.alert-success p').html(data.data);
            $("#loader").hide();
        });
    } else {
        alert("Fill both fields");
    }
}

//
function deleteSchoolNationality(object) {
    var ids = [];
    var token = $("meta[name='csrf-token']").attr('content');
    $.each($(object).closest('.nationality').find("select option:selected"), function () {
        ids.push($(this).val());
    });

    if (ids != '') {
        if (confirm(delete_on_confirm)) {
            $("#loader").show();
            $.post(delete_school_nationality_url, {
                _method: 'DELETE', _token: token, ids: ids
            }, function (data) {
                var school_nationality_index = 0;
                while(true) {
                    var models_dropdown = $("#school_nationality_choose" + school_nationality_index);
                    if (models_dropdown.length) {
                        models_dropdown.html(data.result);
                    } else {
                        break;
                    }
                    school_nationality_index++;
                }
            }).done(function (data) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);

                $("#loader").hide();
            });
        }
    } else {
        alert('Please select any option to delete');
    }
}


function addTravel(object) {
    $("#loader").show();
    var urlname = $(object).parents().find('#form_travel').attr('action');
    var formdata = new FormData($(object).parents().find('#form_travel')[0]);
    var close_button = ($(object).parents().find('#close_this'));

    $.ajax({
        url: urlname,
        method: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                close_button.click();
                $("#to_travel").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        },
        error: function (data) {
            $("#loader").hide();

            close_button.click();
            var rees = JSON.parse(data.responseText);
            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in rees.errors) {
                $('.alert-danger ul').append('<li>' + rees.errors[error] + '</li>');
            }
        }
    });
}

function deleteTravel(object) {
    var urlname = $(object).attr('data-url');
    var travel = $("#to_travel option:selected").val();

    if (travel == '') {
        alert("Select Some option")
        return;
    }

    $("#loader").show();
    $.ajax({
        url: urlname,
        method: 'POST',
        data: {_token: $("meta[name='csrf-token']").attr('content'), application_center: travel},

        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                $("#to_travel").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        }
    });
}

function addTypeOfVisa(object) {
    $("#loader").show();
    var urlname = $(object).parents().find('#type_of_visa_form').attr('action');
    var formdata = new FormData($(object).parents().find('#type_of_visa_form')[0]);
    var close_button = ($(object).parents().find('#close_this'));

    $.ajax({
        url: urlname,
        method: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                close_button.click();
                $("#type_of_visa").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        },
        error: function (data) {
            $("#loader").hide();
            close_button.click();
            var rees = JSON.parse(data.responseText);

            $('.alert-danger').show();
            $('.alert-danger ul').html('');
            for (var error in rees.errors) {
                $('.alert-danger ul').append('<li>' + rees.errors[error] + '</li>');
            }
        }
    });
}

function deleteTypeOfVisa(object) {
    var urlname = $(object).attr('data-url');
    var type_of_visa = $("#type_of_visa").val();

    if (type_of_visa == '') {
        alert("Select Some option")
        return;
    }

    $("#loader").show();
    $.ajax({
        url: urlname,
        method: 'POST',
        data: {_token: $("meta[name='csrf-token']").attr('content'), application_center: type_of_visa},

        success: function (data) {
            $("#loader").hide();

            if (data.success) {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;

                $("#type_of_visa").html(data.option);
            } else if (data.errors) {
                close_button.click();
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            } else if (data.message) {
                $('.alert-danger').show();
                $('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $('.alert-danger ul').append('<li>' + data.errors[error] + '</li>');
                }
            }
        }
    });
}

/*
*
* Visa Form ADd Field function ends
*
* */

/*
* Visa Form clone field function starts
* */
changing_attr_clone = 0;
function cloneAnotherVisa(object) {
    changing_attr_clone++;
    var cloned = $(object).parents().find('.clone_visa0');
    var cloning = cloned.clone(true);
    var change_atrr = cloning.attr('class', 'clone_visa' + changing_attr_clone);
    console.log(change_atrr);
    cloning.insertAfter(cloned);
}

function removeAnotherVisa(object) {
    if (changing_attr_clone > 0) {
        var cloned = $(object).parents().find('.clone_visa' + changing_attr_clone);
        cloned.remove();
        changing_attr_clone--;
    }
}

changing_attr_clone_service = 0;
function cloneAnotherVisaService(object) {
    changing_attr_clone_service++;
    var cloned = $(object).parents().find('.clone_visa_service0');
    var cloning = cloned.clone(true);
    var change_atrr = cloning.attr('class', 'clone_visa_service' + changing_attr_clone_service);
    console.log(change_atrr);
    cloning.insertAfter(cloned);
}

function removeAnotherVisaService(object) {
    if (changing_attr_clone_service > 0) {
        var cloned = $(object).parents().find('.clone_visa_service' + changing_attr_clone_service);
        cloned.remove()
        changing_attr_clone_service--;
    }
}

/*
* function for getting contents of tinymce
* */
function getContent(texteditorId, inputId) {
    if (typeof (tinymce) !== 'undefined') {
        if (tinymce.get(texteditorId)) {
            var myContent = tinymce.get(texteditorId).getContent();

            $('#' + inputId).val(myContent);
        }
    }
}

function submitFormAction(id) {
    $("#loader").show();
    getCkEditorsData();

    var data = new FormData($('#' + id)[0]);
    var urlname = $("#" + id).attr('action');
    $.ajax({
        type: "post",
        url: urlname,
        data: data,
        cache: false,
        contentType: false,
        processData: false,

        success: function (data) {
            $("#loader").hide();

            if (data.success != 'error') {
                toastr.success(data.success);
            } else {
                if (Array.isArray(data.message) || typeof data.message === 'object') {
                    for (message in data.message) {
                        toastr.error(data.message[message])
                    }
                } else {
                    toastr.error(data.message);
                }
            }
        },
        error: function (data) {
            $("#loader").hide();

            var rees = JSON.parse(data.responseText);
            for (errors in rees.errors) {
                toastr.error(rees.errors[errors])
            }
        }
    });
}

function initRating() {
    let rating_inputs = $('.rating-input');
    for (let rating_input_index = 0; rating_input_index < rating_inputs.length; rating_input_index++) {
        $(rating_inputs[rating_input_index]).igRating(
            {
                voteCount: 5,
                value: $(rating_inputs[rating_input_index]).data('value') ? parseFloat($(rating_inputs[rating_input_index]).data('value')) / 5 : 0,
                valueChange: function (evt, ui) {
                    $('input[name="' + $(rating_inputs[rating_input_index]).data('name') + '"]').val(parseFloat(ui.value) * 5);
                }
            }
        );
    }
}

function initLanguageSection() {
    if ($('html').attr('lang') == 'en') {
        $('.arabic').hide();
    } else {
        $('.english').hide();
    }
}

function activeSidebarLinks() {
    var location_href = window.location.href;
    $('.sidebar .nav-item > a.nav-link').each(function() {
        if ($(this).attr('href') && location_href.indexOf($(this).attr('href')) >= 0) {
            $(this).addClass('active');
            if ($(this).closest('.collapse').length) {
                $(this).closest('.collapse').addClass('show');
                if ($(this).closest('.collapse').closest('.nav-item').length) {
                    $(this).closest('.collapse').closest('.nav-item').addClass('active');
                }
            }
        }
    });
}

$(document).ready(function() {
    initRating();
    initCkeditor();
    initCkeditors();
    initLanguageSection();
    
    activeSidebarLinks();
});