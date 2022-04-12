/*
* Init tinymce
*/
function initCkeditor(editor_id = 'textarea_en') {
    var option = {
        removePlugins: 'toolbar',
        allowedContent: 'p h1 h2 strong em; a[!href]; img[!src,width,height];'

    };
    CKEDITOR.replace(editor_id, option);
}

function getCKEDITORdataSchool(textarea, value) {
    var text = CKEDITOR.instances.textareaid2.getData();
    $("#" + value).val(text);
}

function getCKEDITORdataCustomer(textarea, value) {
    var text = CKEDITOR.instances.textareaid.getData();
    $("#" + value).val(text);
}

function tinymceInit(id = null) {
    if (id == null) {
        tinymce.init({
            selector: 'textarea'
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

$(document).ready(function () {
    $('.available_date').change(function (e) {
        if ($(this).val() == 'selected_dates') {
            $(this).parent().parent().find('.available_days').show();
            $(this).parent().parent().find('.select_day').hide();
            $(this).parent().parent().find('.start_date').hide();
            $(this).parent().parent().find('.end_date').hide();
        } else {
            $(this).parent().parent().find('.available_days').hide();
            $(this).parent().parent().find('.select_day').show();
            $(this).parent().parent().find('.start_date').show();
            $(this).parent().parent().find('.end_date').show();
        }
    });

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
                yeardatepicker_months[datepicker_index].push(click_month + "/" + click_year);
            } else {
                yeardatepicker_months[datepicker_index].splice(month_index, 1);
            }
            for (var month_day_index = 0; month_day_index < month_days.length; month_day_index++) {
                if (!$(month_days[month_day_index]).hasClass('ui-datepicker-other-month')) {
                    var click_day = $(month_days[month_day_index]).find('a').html();
                    if (parseInt(click_day) < 10) click_day = '0' + click_day;
                    var click_date = click_month + "/" + click_day + "/" + click_year;
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
            
            $(datepickerEl).val(yeardatepicker_days[datepicker_index].join(","));
            datepickerObj.find('.ui-datepicker-today').click();            
            setTimeout(function() {
                datepickerObj.find('.ui-datepicker-today').click();
            }, 300);
        });
    }
    
    var todayDate = new Date();
    if ($("#datepick").length) {
        $("#datepick").datepicker({
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

function changeCourseSchool() {
    var school = $('#school_name').val();
    if (school != '') {
        $.post(url_school_country_list, {_token: token, id: school}, function (data) {
            $('#country_name').html(data);
        });
    }
}

function changeCourseCountry() {
    var school = $('#school_name').val();
    var country = $('#country_name').val();
    if (school != '' && country != '') {
        $.post(url_school_city_list, {_token: token, id: school, country: country}, function (data) {
            $('#city_name').html(data);
        });
    }
}

function changeCourseCity() {
    var school = $('#school_name').val();
    var country = $('#country_name').val();
    var city = $('#city_name').val();
    if (school != '' && country != '' && city != '') {
        $.post(url_school_branch_list, {_token: token, id: school, country: country, city: city}, function (data) {
            $('#branch_choose').html(data);
        });
    }
}

function confirmDelete() {
    if (confirm(delete_on_confirm)) {
        return true;
    }

    return false;
}

function submitCourseForm(object) {
    $("#loader").show();
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
            console.log(formData);
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

function submitCommonForBlogForm(urlname, typeMethod = "POST") {
    $("#loader").show();

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

function submitSchoolAdminForm(urlname, method = 'POST') {
    $("#loader").show();

    var formData = new FormData($("#form_to_be_submitted")[0]);

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

                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            } else if (data.success == 'success') {
                $('.alert-success').show();
                $('.alert-success').find('p').html(data.data);
                document.documentElement.scrollTop = 0;
            }
        }
    });
}

function submitForm(object, method = 'POST') {
    $("#loader").show();

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
    var airport = jQuery.trim($('#airport_pickup option:selected').text());

    $.post(url_for_airport, {_token: $('meta[name="csrf-token"]').attr('content'), 'airport_name': airport}, function (data) {
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
        focus_val = $("#under_age").val();
    } else if (type == 'select_program') {
        focus_val = $("#get_program_name").val();
    } else if (type == 'date_selected') {
        focus_val = $("#datepick").val();
    } else if (type == 'duration') {
        focus_val = $("#program_duration").val();
    }
    if (!focus_val) return;
    $('#loader').show();
    $.post(calculate_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        type: type,
        value: focus_val,
        course_unique_id: $("#get_program_name").val(),
        program_unique_id: $("#program_unique_id").val(),
        date_set: $("#datepick").val(),
        under_age: $('#under_age').val(),
        study_mode: $('#study_mode').val(),
        program_duration: $('#program_duration').val(),
        courier_fee: $("#checked_courier_fee").is(':checked'),
        accom_id: $('#accom_type').val()
    }).done(function (data) {
        $('#loader').hide();

        var default_program_duration = $("#program_duration").val();
        if (type == 'requested_for_under_age') {
            if (data.program_get != undefined) {
                $("#get_program_name").html(data.program_get);
            }
        } else if (type == 'select_program') {
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
            if (data.christmas_notification != undefined) {
                confirm(data.christmas_notification);
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
                $("#accom_type").html(data.accommodations);
            }
            if (data.accommodations_visible != undefined) {
                if (data.accommodations_visible) {
                    $("#accommodation_fees").show();
                } else {
                    $("#accommodation_fees").hide();
                }
            } 
            if (data.airports != undefined) {
                $("#airport_service_provider").html(data.airports);
            }
            if (data.airports_visible != undefined) {
                if (data.airports_visible) {
                    $("#airport_service").show();
                } else {
                    $("#airport_service").hide();
                }
            }
            if (data.medicals != undefined) {
                $("#medical_company_name").html(data.medicals);
            }
            if (data.medicals_visible != undefined) {
                if (data.medicals_visible) {
                    $("#medical_service").show();
                } else {
                    $("#medical_service").hide();
                }
            }
            if (data.airports_visible != undefined && data.medicals_visible != undefined) {
                if (data.airports_visible || data.medicals_visible) {
                    $("#other_services").show();
                } else {
                    $("#other_services").hide();
                }
            } else {
                $("#other_services").hide();
            }
        }

        resetAccommodation(true);
        resetAirportMedical(true); 
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

function resetAccommodation(init = false) {
    if (init) {
        $("#accom_type")[0].selectedIndex = '';
        $("#accom_duration")[0].selectedIndex = '';
        $("#special_diet").hide();
        $("#custodianship").hide();
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
        $("#accommodation_fees #accommodation_custodian_fee .cost_value").html(0);
        $("#accommodation_fees #accommodation_custodian_fee .converted_value").html(0);
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
        $("#accommodation_fees_table").hide();
    })
}

function resetAirportMedical(init = false) {
    if (init) {
        $("#airport_service_provider")[0].selectedIndex = '';
        $("#airport_type_of_service")[0].selectedIndex = '';

        $("#medical_company_name")[0].selectedIndex = '';
        $("#medical_duration")[0].selectedIndex = '';
    }
    $.get(reset_airport_medical_url, function () {
        $("#other_services #airport_pickup .cost_value").html(0);
        $("#other_services #airport_pickup .converted_value").html(0);
        $("#other_services #medical_insurance .cost_value").html(0);
        $("#other_services #medical_insurance .converted_value").html(0);
        $("#other_services .cost_currency").html('');
        $("#other_services .converted_currency").html('');
        $("#airport_medical_fees_table").hide();
    })
}

function calcuateAccommodation() {
    meal_type = jQuery.trim($("#meal_type option:selected").text())
    if (meal_type != '') {
        $('#loader').show();
        $.post(calculate_accommodation_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            date_set: $("#datepick").val(),
            program_duration: $("#program_duration").val(),
            age: $("#under_age").val(),
            accom_id: $("#accom_type").val(),
            accom_type: jQuery.trim($("#accom_type option:selected").text()),
            room_type: jQuery.trim($("#room_type option:selected").text()),
            meal_type: meal_type,
            duration: $("#accom_duration").val(),
            special_diet: $("#special_diet_check").is(':checked'),
            custodianship: $("#custodianship_check").is(':checked')
        }, function (data) {
            reloadCourseCalclulator();
            resetAirportMedical(true);

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
            $("#accommodation_fees #accommodation_custodian_fee .cost_value").html(data.custodian_fee.value);
            $("#accommodation_fees #accommodation_custodian_fee .converted_value").html(parseFloat(data.custodian_fee.converted_value).toFixed(2));
            if (parseFloat(data.custodian_fee.value)) $("#accommodation_fees #accommodation_custodian_fee").show(); else $("#accommodation_fees #accommodation_custodian_fee").hide();
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

            $("#accommodation_fees_table").show();
            
            if (data.special_diet != undefined) {
                if (data.special_diet) {
                    $("#special_diet").show();
                    if (data.special_diet_note != undefined) {
                        $("#specialDietModal .modal-body").html(data.special_diet_note);
                    } else {
                        $("#specialDietModal .modal-body").html('');
                    }
                } else {
                    $("#special_diet").hide();
                }
            }

            if (data.custodianship != undefined) {
                if (data.custodianship) {
                    $("#custodianship").show();
                } else {
                    $("#custodianship").hide();
                }
            }

            if (typeof callbackCalcuateAccommodation === "function") {
                callbackCalcuateAccommodation();
            }
        }).done(function () {
            $("#loader").hide();
        });
    }
}

function calculateAirportMedical(type = 'airport') {
    var program_duration = $('#program_duration').val();

    var airport_service_provider = $('#airport_service_provider option:selected').val() ? jQuery.trim($('#airport_service_provider option:selected').text()) : '';
    var airport_name = $('#airport_name option:selected').val() ? jQuery.trim($('#airport_name option:selected').text()) : '';
    var airport_service = $('#airport_type_of_service option:selected').val() ? jQuery.trim($('#airport_type_of_service option:selected').text()) : '';
    
    var medical_company_name = $('#medical_company_name option:selected').val() ? jQuery.trim($('#medical_company_name option:selected').text()) : '';
    var medical_deductible = $('#medical_deductible_up_to option:selected').val() ? jQuery.trim($('#medical_deductible_up_to option:selected').text()) : '';
    var medical_duration = $('#medical_duration option:selected').val() ? jQuery.trim($('#medical_duration option:selected').text()) : '';

    $.post(airport_medical_fee_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        program_duration: program_duration,
        airport_service_provider: airport_service_provider,
        airport_name: airport_name,
        airport_service: airport_service,
        medical_company_name: medical_company_name,
        medical_deductible: medical_deductible,
        medical_duration: medical_duration
    }, function (data) {
        $("#airport_medical_fees_table #airport_pickup .cost_value").html(data.airport_fee.value);
        $("#airport_medical_fees_table #airport_pickup .converted_value").html(parseFloat(data.airport_fee.converted_value).toFixed(2));
        $("#airport_medical_fees_table #medical_insurance .cost_value").html(data.medical_fee.value);
        $("#airport_medical_fees_table #medical_insurance .converted_value").html(parseFloat(data.medical_fee.converted_value).toFixed(2));
        $("#airport_medical_fees_table #airport_medical_total .cost_value").html(data.total.value);
        $("#airport_medical_fees_table #airport_medical_total .converted_value").html(parseFloat(data.total.converted_value).toFixed(2));
        
        $("#airport_medical_fees_table .cost_currency").html(data.currency.cost);
        $("#airport_medical_fees_table .converted_currency").html(data.currency.converted);
        
        $("#total_table .total_cost").html(parseFloat(data.overall_total.value).toFixed(2));
        $("#total_table .total_converted").html(parseFloat(data.overall_total.converted_value).toFixed(2));
        $("#total_table .total_cost_currency").html(data.currency.cost);
        $("#total_table .total_converted_currency").html(data.currency.converted);

        $("#airport_medical_fees_table").show();

        $("#total_fees").val(data.overall_total.value);
        $("#total_fees_to_save_to_db").val(data.overall_total.value + " " + data.currency.cost);
        $("#other_currency_to_save_to_db").val(parseFloat(data.overall_total.converted_value).toFixed(2) + " " + data.currency.converted);

        $("#AirportPickupModal .modal-body").html(data.airport_note);
        $("#MedicalInsuranceModal .modal-body").html(data.medical_note);

        if (typeof callbackCalculateAirportMedical === "function") {
            callbackCalculateAirportMedical(type);
        }
    });
}

function discountPrice(value, form_token = '') {
    if (value != '') {
        $.post(calculate_discount_url, {
            _token: form_token ? form_token : token,
            date_set: $("#datepick").val(),
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

    $('#airport_service_provider').change(function () {
        var airport_service_provider = $('#airport_service_provider option:selected').val() ? jQuery.trim($('#airport_service_provider option:selected').text()) : '';
        $.post(airport_names_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'service_provider': airport_service_provider
        }, function (data) {
            $('#airport_name').html(data);

            if (typeof callbackChangeAirportServiceProvider === "function") {
                callbackChangeAirportServiceProvider();
            }
        });
    });

    $('#airport_name').change(function () {
        var airport_service_provider = $('#airport_service_provider option:selected').val() ? jQuery.trim($('#airport_service_provider option:selected').text()) : '';
        var airport_name = $('#airport_name option:selected').val() ? jQuery.trim($('#airport_name option:selected').text()) : '';
        $.post(airport_services_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'service_provider': airport_service_provider,
            'name': airport_name
        }, function (data) {
            $('#airport_type_of_service').html(data);

            if (typeof callbackChangeAirportName === "function") {
                callbackChangeAirportName();
            }
        });
    });

    $('#airport_type_of_service').change(function () {
        calculateAirportMedical('airport');
    });

    $('#medical_company_name').change(function () {
        var medical_company_name = $('#medical_company_name option:selected').val() ? jQuery.trim($('#medical_company_name option:selected').text()) : '';
        $.post(medical_deductibles_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'company_name': medical_company_name
        }, function (data) {
            $('#medical_deductible_up_to').html(data);

            if (typeof callbackChangeMedicalCompanyName === "function") {
                callbackChangeMedicalCompanyName();
            }
        });
    });

    $('#medical_deductible_up_to').change(function () {
        var program_duration = $('#program_duration').val();
        var medical_company_name = $('#medical_company_name option:selected').val() ? jQuery.trim($('#medical_company_name option:selected').text()) : '';
        var medical_deductible = $('#medical_deductible_up_to option:selected').val() ? jQuery.trim($('#medical_deductible_up_to option:selected').text()) : '';
        $.post(medical_durations_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'program_duration': program_duration,
            'company_name': medical_company_name,
            'deductible': medical_deductible,
        }, function (data) {
            $('#medical_duration').html(data);

            if (typeof callbackChangeMedicalDeductibleUpTo === "function") {
                callbackChangeMedicalDeductibleUpTo();
            }
        });
    });

    $('#medical_duration').change(function () {
        calculateAirportMedical('medical');
    });

    $('#accom_type').change(function () {
        var accom_text = $('#accom_type option:selected').val() ? jQuery.trim($('#accom_type option:selected').text()) : '';
        $.post(rooms_meals_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'accom_type': accom_text,
            'age_selected': $("#under_age").val()
        }, function (data) {
            $('#room_type').html(data.room_type);
            $('#meal_type').html(data.meal_type);

            if (typeof callbackChangeAccommodationType === "function") {
                callbackChangeAccommodationType();
            }
        });
    });

    $('#meal_type').change(function () {
        $.post(accomm_durations_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            accom_type: jQuery.trim($("#accom_type option:selected").text()),
            room_type: jQuery.trim($("#room_type option:selected").text()),
            meal_type: jQuery.trim($("#meal_type option:selected").text()),
            program_duration: $("#program_duration").val()
        }, function (data) {
            $('#accom_duration').html(data.duration);

            if (typeof callbackChangeAccommodationMealType === "function") {
                callbackChangeAccommodationMealType();
            }
        });
    });

    if ($("#program_duration option").length) {
        $("#program_duration").val($($("#program_duration option")[0]).attr('value')).change();
        calculateCourse('duration', $("#program_duration").val());
    }
});

function submitAccommodationForm(object) {
    var urlfor = $(object).parents().find('#courseform').attr('action');
    var accommodationForm = $(object).parents().find('#courseform');

    var formData = new FormData($(accommodationForm)[0]);
    $('#loader').show();
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

                window.location.href = edit_accomm_under_age_url;
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

function submitAirportMedicalForm(object, reload = false) {
    var urlname = $(object).parents().find('#courseform').attr('action');
    var form = $(object).parents().find('#courseform');
    var formData = new FormData($(form)[0]);

    $("#loader").show();
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
                if (reload) {
                    window.location.reload();
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

function submitAccommodationUnderAgeForm(object, reload = false) {
    var urlname = (object.parents().find('#accommodation_under_age_form').attr('action'));
    var form = $(object).parents().find('#accommodation_under_age_form');
    var formData = new FormData($(form)[0]);

    $('#loader').show();
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
            } else if (data.success == 'success') {
                $('.alert-success').show();
                $('.alert-success p').html(data.data);
                document.documentElement.scrollTop = 0;
                if (reload)
                    window.location.reload();
            } else if (data.catch_error) {
                console.log(data.catch_error);
                document.documentElement.scrollTop = 0;

                $('.alert-danger').show();
                $('.alert-danger ul').html(data.catch_error);
            }
        }
    });
}

function submitCourseProgramForm(this_object) {
    var form1 = $(this_object).parents().find('#courseform');
    var url_submit = $(form1).attr('action');
    var form = new FormData($(form1)[0]);

    $('#loader').show();
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


/*
* Visa Form ADd Field function
*
* */
function submitVisaApplication(object) {
    $("#loader").show();
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
function addAccommCustodianAgeRange(english_val, arabic_val) {
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
function deleteAccommCustodianAgeRange(object) {
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
                        models_dropdown.append(data.result);
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
                        models_dropdown.append(data.result);
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
        data: {_token: $("meta[name='csrf-token']").attr('content'), applying_from: applying_from},

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

function sendMessage(id) {
    $("#loader").show();
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
                toastr.error(data.message);
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