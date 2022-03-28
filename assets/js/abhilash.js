/*
* Multiselect option initialisation starts here
*
* */
//id = program_under_age_add

/*
* function for removing element program under age
*
* */

/*Init tinymce
*
* */
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
        alert(id);
        tinymce.init({
            selector: 'textarea#' + id
        });
    }
}

function removeEditor() {
    if (typeof (tinymce) != "undefined") {
        tinymce.remove('textarea');
        tinymceInit();
    }
}

var datepicker_available_days = [];
var datepicker_format = 'dd-mm-yy';
$(document).ready(function () {
    var remove_program_button = 0;
    var formnum = 0;

    $('#program_under_age_remove' + remove_program_button).click(function () {
    });

    $('#clone_program_text_book_fee').find('.fa-minus').click(function (e) {
        if (!(rowNum1 <= 1)) {
            rowNum1--;

            $(this).closest("#clone_program_text_book_fee").remove();
            $('#clone_program_text_book_fee').find('#increment').attr('value', rowNum);
        }
    });
    var airportincrement = typeof (airportincrements) != 'undefined' ? airportincrements : 0;

    $('#accom_program_duration_clone').find('.fa-plus-circle').click(function () {
        airportincrement++;
        $(this).parents().find('#airportincrement').attr('value', airportincrement);
        var copied = $(this).parent().parent().parent().parent().clone(true);
        copied.insertAfter($(this).parent().parent());
    });

    $('#accom_program_duration_clone').find('.fa-minus').click(function (e) {
        if (!(airportincrement == 0)) {
            $(this).closest("#accom_program_duration_clone").remove();
            $('#accom_program_duration_clone').find('#increment').attr('value', airportincrement);
            airportincrement--;
        }
    });

    var medical_clone = typeof (medical_clones) != 'undefined' ? medical_clones : '';
    $('#medical_clone' + medical_clone).find('.fa-plus-circle').click(function () {
        $('#medical_clone' + medical_clone).find('#medicalincrement').attr('value', rowNum3);
        var copied = $("#medical_clone" + medical_clone).clone(true);
        copied.insertAfter("#accom_program_duration_clone");
        rowNum3++;
    });
    $('#medical_clone' + medical_clone).find('.fa-minus').click(function (e) {
        if (!(rowNum3 <= 1)) {
            rowNum3--;
            $(this).closest("#medical_clone" + medical_clone).remove();
            $('#medical_clone' + medical_clone).find('#increment').attr('value', rowNum);
        }
    });

    var accomunderagecloneselect = 0;
    $('#accom_under_age_clone' + formnum).find('.fa-minus').click(function (e) {
        alert('CLIEKD');
        if (!(accomunderagecloneselect == 0)) {
            $(this).parent().parent().remove();
            $(this).parent().parent().parent().find('#accomincreement').attr('value', accomunderagecloneselect);

            accomunderagecloneselect--;
        }
    });

    $('.available_date').change(function (e) {
        if ($(this).val() == 'start_day_every') {
            $(this).parent().parent().find('.select_day_week').show();
            $(this).parent().parent().find('.available_days').hide();
        } else {            
            $(this).parent().parent().find('.select_day_week').hide();
            $(this).parent().parent().find('.available_days').show();
        }
    });

    $('.yeardatepicker').each(function() {
        var todayDate = new Date();
        var datepicker_days = [];
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
                var i = $.inArray(d, datepicker_days);
                if (i == -1) {
                    datepicker_days.push(d);
                } else {
                    datepicker_days.splice(i, 1);
                }
                $(this).data('datepicker').inline = true;
                $(this).data('datepicker').settings.showCurrentAtPos = 0;
                datepicker_days.sort(function (first, second) {
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
                $(this).val(datepicker_days.join(","));
            },
            onClose: function() {
                $(this).data('datepicker').inline = false;
                $(this).data('datepicker').settings.showCurrentAtPos = todayDate.getMonth();
            },
            beforeShowDay: function(d) {
                var dateavailable = true;
                if ($.datepicker.formatDate('yymmdd', d) < $.datepicker.formatDate('yymmdd', todayDate)) dateavailable = false;
                return ([dateavailable, $.inArray($.datepicker.formatDate('mm/dd/yy', d), datepicker_days) == -1 ? 'ui-state-free' : 'ui-state-busy']);
            }
        });
    });
    
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

function getSchool(thisurl, id) {
    if (id != '') {
        $('select[multiple].active2.3col').multiselect({
            enableFiltering: true,
            maxHeight: 450
        });
        $.post(thisurl, {_token: token, id: id}, function (data) {
            $('#country_name').html(data.country);
            $('#city_name').html(data.city);

            var models_dropdown = $("select[multiple].active2.3col");
            models_dropdown.empty();

            $(data.branch).each(function () {
                var option = $("<option />");
                option.html(this);
                option.val(this);
                models_dropdown.append(option);
            });

            $('select[multiple].active2.3col').multiselect('rebuild');
        });
    }
}

function reloadJson() {
    var reload = true;
    var tok = $('meta[name="csrf-token"]').attr('content');
    $.post(calculate_discount_url, {_token: tok, reload: reload}, function (data) {
    });
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
            console.log(formData);
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
    removeEditor();
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
function calculatorForCourier(type, value) {
    $('#loader').show();
    $.post(calculate_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        type: type,
        value: value,
        date_set: $("#datepick").val(),
        program_duration: $("#program_duration").val(),
        under_age: $('#under_age').val(),
    }, function (data) {
        if (data.error != null) {
        }
    }).done(function (data) {
        reloadCourseCalclulator();
    });
}

function calculatorCourse(type, value) {
    if (value != '') {
        $('#loader').show();
        $.post(calculate_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: type,
            value: value,
            course_unique_id: $("#get_program_name").val(),
            program_unique_id: $("#program_unique_id").val(),
            date_set: $("#datepick").val(),
            under_age: $('#under_age').val(),
            study_mode: $('#study_mode').val(),
            program_duration: $('#program_duration').val(),
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
                $("#classes_day").html(data.classes_day);
                $("#start_date").html(data.start_date);

                if (data.courier_fee != undefined) {
                    if (data.courier_fee) {
                        $("#courier_fee").hide();
                    } else {
                        $("#courier_fee").show();
                    }
                }

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

            setTimeout(function() {
                if (type == 'date_selected') {
                    if ($("#program_duration option").length) {
                        if (default_program_duration != $($("#program_duration option")[0]).attr('value')) {
                            $("#program_duration").val($($("#program_duration option")[0]).attr('value')).change();
                        }
                        calculatorCourse('duration', $("#program_duration").val());
                    }
                }
            }, 1000);
        });
    }
}

function reloadCourseCalclulator() {
    $.get(reload_calculate_url, function (data) {
        if (data.total != undefined) {
            $("#program_fees_table #program_cost .cost_value").html(data.program_cost.value);
            $("#program_fees_table #program_cost .converted_value").html(data.program_cost.converted_value.toFixed(2));
            $("#program_fees_table #registration_fee .cost_value").html(data.registration_fee.value);
            $("#program_fees_table #registration_fee .converted_value").html(data.registration_fee.converted_value.toFixed(2));
            $("#program_fees_table #text_book_fee .cost_value").html(data.text_book_fee.value);
            $("#program_fees_table #text_book_fee .converted_value").html(data.text_book_fee.converted_value.toFixed(2));
            $("#program_fees_table #summer_fees .cost_value").html(data.summer_fees.value);
            $("#program_fees_table #summer_fees .converted_value").html(data.summer_fees.converted_value.toFixed(2));
            if (parseFloat(data.summer_fees.value)) $("#program_fees_table #summer_fees").show(); else $("#program_fees_table #summer_fees").hide();
            $("#program_fees_table #peak_time_fees .cost_value").html(data.peak_time_fees.value);
            $("#program_fees_table #peak_time_fees .converted_value").html(data.peak_time_fees.converted_value.toFixed(2));
            if (parseFloat(data.peak_time_fees.value)) $("#program_fees_table #peak_time_fees").show(); else $("#program_fees_table #peak_time_fees").hide();
            $("#program_fees_table #under_age_fees .cost_value").html(data.under_age_fees.value);
            $("#program_fees_table #under_age_fees .converted_value").html(data.under_age_fees.converted_value.toFixed(2));
            if (parseFloat(data.under_age_fees.value)) $("#program_fees_table #under_age_fees").show(); else $("#program_fees_table #under_age_fees").hide();
            $("#program_fees_table #express_mail_fee .cost_value").html(data.express_mail_fee.value);
            $("#program_fees_table #express_mail_fee .converted_value").html(data.express_mail_fee.converted_value.toFixed(2));
            if (parseFloat(data.express_mail_fee.value)) $("#program_fees_table #express_mail_fee").show(); else $("#program_fees_table #express_mail_fee").hide();
            $("#program_fees_table #discount_fee .cost_value").html("-" + data.discount_fee.value);
            $("#program_fees_table #discount_fee .converted_value").html("-" + data.discount_fee.converted_value.toFixed(2));
            $("#program_fees_table #program_total .cost_value").html(data.total.value);
            $("#program_fees_table #program_total .converted_value").html(data.total.converted_value.toFixed(2));

            $("#program_fees_table .cost_currency").html(data.currency.cost);
            $("#program_fees_table .converted_currency").html(data.currency.converted);

            $("#total_table .total_cost").html(data.overall_total.value.toFixed(2));
            $("#total_table .total_converted").html(data.overall_total.converted_value.toFixed(2));
            $("#total_table .total_cost_currency").html(data.currency.cost);
            $("#total_table .total_converted_currency").html(data.currency.converted);

            $("#total_fees_to_save_to_db").val(data.overall_total.value + " " + data.currency.cost);
            $("#other_currency_to_save_to_db").val(data.overall_total.converted_value.toFixed(2) + " " + data.currency.converted)
        }
    }).done(function () {
        $('#loader').hide();
    })
}

function resetAccommodation(init = false) {
    if (init) {
        $("#accom_type")[0].selectedIndex = '';
        $("#accom_duration")[0].selectedIndex = '';
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

function fetchAccommodationDuration(urlname, accom_type, set_session = false, duration = false, age = false, program_duration = null) {
    meal_type = jQuery.trim($("#meal_type option:selected").text())
    if (meal_type != '') {
        var date_set = $("#datepick").val();
        $('#loader').show();
        $.post(urlname, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: accom_type,
            date_set: date_set,
            room_type: jQuery.trim($("#room_type option:selected").text()),
            meal_type: meal_type,
            duration: duration,
            set_session: set_session,
            program_duration: program_duration,
            age: age
        }, function (data) {
            reloadCourseCalclulator();
            resetAirportMedical(true);

            if (set_session != true) {
                $("#accommodation_fees #accommodation_fee .cost_value").html(data.accom_fee.value);
                $("#accommodation_fees #accommodation_fee .converted_value").html(data.accom_fee.converted_value.toFixed(2));
                $("#accommodation_fees #accommodation_placement_fee .cost_value").html(data.placement_fee.value);
                $("#accommodation_fees #accommodation_placement_fee .converted_value").html(data.placement_fee.converted_value.toFixed(2));
                $("#accommodation_fees #accommodation_special_diet_fee .cost_value").html(data.special_diet_fee.value);
                $("#accommodation_fees #accommodation_special_diet_fee .converted_value").html(data.special_diet_fee.converted_value.toFixed(2));
                if (parseFloat(data.special_diet_fee.value)) $("#accommodation_fees #accommodation_special_diet_fee").show(); else $("#accommodation_fees #accommodation_special_diet_fee").hide();
                $("#accommodation_fees #accommodation_deposit_fee .cost_value").html(data.deposit_fee.value);
                $("#accommodation_fees #accommodation_deposit_fee .converted_value").html(data.deposit_fee.converted_value.toFixed(2));
                if (parseFloat(data.deposit_fee.value)) $("#accommodation_fees #accommodation_deposit_fee").show(); else $("#accommodation_fees #accommodation_deposit_fee").hide();
                $("#accommodation_fees #accommodation_custodian_fee .cost_value").html(data.custodian_fee.value);
                $("#accommodation_fees #accommodation_custodian_fee .converted_value").html(data.custodian_fee.converted_value.toFixed(2));
                if (parseFloat(data.custodian_fee.value)) $("#accommodation_fees #accommodation_custodian_fee").show(); else $("#accommodation_fees #accommodation_custodian_fee").hide();
                $("#accommodation_fees #accommodation_summer_fees .cost_value").html(data.summer_fee.value);
                $("#accommodation_fees #accommodation_summer_fees .converted_value").html(data.summer_fee.converted_value.toFixed(2));
                if (parseFloat(data.summer_fee.value)) $("#accommodation_fees #accommodation_summer_fees").show(); else $("#accommodation_fees #accommodation_summer_fees").hide();
                $("#accommodation_fees #accommodation_peak_fees .cost_value").html(data.peak_fee.value);
                $("#accommodation_fees #accommodation_peak_fees .converted_value").html(data.peak_fee.converted_value.toFixed(2));
                if (parseFloat(data.peak_fee.value)) $("#accommodation_fees #accommodation_peak_fees").show(); else $("#accommodation_fees #accommodation_peak_fees").hide();
                $("#accommodation_fees #accommodation_christmas_fees .cost_value").html(data.christmas_fee.value);
                $("#accommodation_fees #accommodation_christmas_fees .converted_value").html(data.christmas_fee.converted_value.toFixed(2));
                if (parseFloat(data.christmas_fee.value)) $("#accommodation_fees #accommodation_christmas_fees").show(); else $("#accommodation_fees #accommodation_christmas_fees").hide();
                $("#accommodation_fees #accommodation_under_age_fees .cost_value").html(data.under_age_fee.value);
                $("#accommodation_fees #accommodation_under_age_fees .converted_value").html(data.under_age_fee.converted_value.toFixed(2));
                if (parseFloat(data.under_age_fee.value)) $("#accommodation_fees #accommodation_under_age_fees").show(); else $("#accommodation_fees #accommodation_under_age_fees").hide();
                $("#accommodation_fees #accommodation_discount_fee .cost_value").html("-" + data.discount_fee.value);
                $("#accommodation_fees #accommodation_discount_fee .converted_value").html("-" + data.discount_fee.converted_value.toFixed(2));

                $("#accommodation_fees #accommodation_total .cost_value").html(data.total.value.toFixed(2));
                $("#accommodation_fees #accommodation_total .converted_value").html(data.total.converted_value.toFixed(2));
                
                $("#accommodation_fees .cost_currency").html(data.currency.cost);
                $("#accommodation_fees .converted_currency").html(data.currency.converted);
                
                $("#total_table .total_cost").html(data.overall_total.value.toFixed(2));
                $("#total_table .total_converted").html(data.overall_total.converted_value.toFixed(2));
                $("#total_table .total_cost_currency").html(data.currency.cost);
                $("#total_table .total_converted_currency").html(data.currency.converted);

                $("#total_fees_to_save_to_db").val(data.overall_total.value + " " + data.currency.cost);
                $("#other_currency_to_save_to_db").val(data.overall_total.converted_value.toFixed(2) + " " + data.currency.converted);

                $("#accommodation_fees_table").show();
            } else {
                $('#accom_duration').html(data.duration_value);
            }
        }).done(function () {
            $("#loader").hide();
        });
    }
}

function fetchAirportMedicalFee() {
    var program_duration = $('#program_duration').val();

    var airport_service_provider = $('#airport_service_provider option:selected').val() ? jQuery.trim($('#airport_service_provider option:selected').text()) : '';
    var airport_name = $('#airport_name option:selected').val() ? jQuery.trim($('#airport_name option:selected').text()) : '';
    var airport_service = $('#airport_type_of_service option:selected').val() ? jQuery.trim($('#airport_type_of_service option:selected').text()) : '';
    
    var medical_company_name = $('#medical_company_name option:selected').val() ? jQuery.trim($('#medical_company_name option:selected').text()) : '';
    var medical_deductible = $('#medical_deductible_up_to option:selected').val() ? jQuery.trim($('#medical_deductible_up_to option:selected').text()) : '';
    var medical_duration = $('#medical_duration option:selected').val() ? jQuery.trim($('#medical_duration option:selected').text()) : '';

    $.post(airport_medical_fee_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        'program_duration': program_duration,
        'airport_service_provider': airport_service_provider,
        'airport_name': airport_name,
        'airport_service': airport_service,
        'medical_company_name': medical_company_name,
        'medical_deductible': medical_deductible,
        'medical_duration': medical_duration
    }, function (data) {
        $("#airport_medical_fees_table #airport_pickup .cost_value").html(data.airport_fee.value);
        $("#airport_medical_fees_table #airport_pickup .converted_value").html(data.airport_fee.converted_value.toFixed(2));
        $("#airport_medical_fees_table #medical_insurance .cost_value").html(data.medical_fee.value);
        $("#airport_medical_fees_table #medical_insurance .converted_value").html(data.medical_fee.converted_value.toFixed(2));
        $("#airport_medical_fees_table #airport_medical_total .cost_value").html(data.total.value);
        $("#airport_medical_fees_table #airport_medical_total .converted_value").html(data.total.converted_value.toFixed(2));
        
        $("#airport_medical_fees_table .cost_currency").html(data.currency.cost);
        $("#airport_medical_fees_table .converted_currency").html(data.currency.converted);
        
        $("#total_table .total_cost").html(data.overall_total.value.toFixed(2));
        $("#total_table .total_converted").html(data.overall_total.converted_value.toFixed(2));
        $("#total_table .total_cost_currency").html(data.currency.cost);
        $("#total_table .total_converted_currency").html(data.currency.converted);

        $("#airport_medical_fees_table").show();

        $("#total_fees_to_save_to_db").val(data.overall_total.value + " " + data.currency.cost);
        $("#other_currency_to_save_to_db").val(data.overall_total.converted_value.toFixed(2) + " " + data.currency.converted);
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
    $('#airport_service_provider').change(function () {
        var airport_service_provider = $('#airport_service_provider option:selected').val() ? jQuery.trim($('#airport_service_provider option:selected').text()) : '';
        $.post(airport_names_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'service_provider': airport_service_provider
        }, function (data) {
            $('#airport_name').html(data);
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
        });
    });

    $('#airport_type_of_service').change(function () {
        fetchAirportMedicalFee();
    });

    $('#medical_company_name').change(function () {
        var medical_company_name = $('#medical_company_name option:selected').val() ? jQuery.trim($('#medical_company_name option:selected').text()) : '';
        $.post(medical_deductibles_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'company_name': medical_company_name
        }, function (data) {
            $('#medical_deductible_up_to').html(data);
        });
    });

    $('#medical_deductible_up_to').change(function () {
        var medical_company_name = $('#medical_company_name option:selected').val() ? jQuery.trim($('#medical_company_name option:selected').text()) : '';
        var medical_deductible = $('#medical_deductible_up_to option:selected').val() ? jQuery.trim($('#medical_deductible_up_to option:selected').text()) : '';
        $.post(medical_durations_url, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'company_name': medical_company_name,
            'deductible': medical_deductible
        }, function (data) {
            $('#medical_duration').html(data);
        });
    });

    $('#medical_duration').change(function () {
        fetchAirportMedicalFee();
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
        });
    });

    if ($("#program_duration option").length) {
        $("#program_duration").val($($("#program_duration option")[0]).attr('value')).change();
        calculatorCourse('duration', $("#program_duration").val());
    }
});

function specialDietCheck(urlname, checked, week) {
    //if medical_insurance_checked is true then yes or no
    $.post(urlname, {
        _token: token,
        checked: checked,
        week: week,
        special_diet: true,
        room_type: jQuery.trim($("#room_type option:selected").text()),
        meal_type: jQuery.trim($("#meal_type option:selected").text()),
    }, function (data) {
        if (data.total_value != undefined) {
            $('#total_fee').html(data.total_fee + " " + data.currency_name + " / " + data.currency_price + " " + " SAR");
            $("#total_fees_to_save_to_db").val(data.total_value + " " + data.currency_name);
            $("#other_currency_to_save_to_db").val(data.currency_price + " " + " SAR")

            $("#total_fees").val(data.total_fee);
        }
        $('#special_diet_fee').html(data.special_diet_fee);
    }).done(function () {
        $("#loader").hide();
    });
}

function addAccommodation(object) {
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
                setTimeout(function () {
                    window.location.replace(accomm_under_age_url);
                }, 2000)
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

function addAirportMedical(object, reload = false) {
    var urlname = $(object).parents().find("#courseform").attr('action');
    var formData = new FormData($(object).parents().find('#courseform')[0]);

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
                if (reload)
                    window.location.reload();
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

function addAccommodationUnderAge(object, reload = false) {
    var urlname = (object.parents().find('#courseform').attr('action'));
    var form1 = $(object).parents().find('#courseform');
    var form = new FormData($(form1)[0]);

    $('#loader').show();
    $.ajax({
        type: 'POST',
        url: urlname,
        data: form,
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
            $.post(delete_language_url, {_token: token, ids: ids}, function (data) {
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
            $.post(delete_study_mode_url, {_token: token, ids: ids}, function (data) {
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
            $.post(delete_program_type_url, {_token: token, ids: ids}, function (data) {
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
        $("#branch_choose").multiselect('rebuild');
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
            $.post(delete_branch_url, {_token: token, ids: ids}, function (data) {
                $("#branch_choose").html(data.result);
                document.documentElement.scrollTop = 0;
                $("#branch_choose").multiselect('rebuild');
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
            $.post(delete_study_time_url, {_token: token, ids: ids}, function (data) {
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
            $.post(delete_classes_day_url, {_token: token, ids: ids}, function (data) {
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
            $.post(delete_start_day_url, {_token: token, ids: ids}, function (data) {
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
            $.post(delete_program_age_range_url, {type : 'DELETE', _token: token, ids: ids}, function (data) {
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
            $.post(delete_program_under_age_range_url, {_token: token, ids: ids}, function (data) {
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
            $.post(delete_accomm_age_range_url, {_token: token, ids: ids}, function (data) {
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
                _token: token, ids: ids
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
            $.post(delete_accomm_under_range_url, {_token: token, ids: ids}, function (data) {
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
* Visa Form ADd Field function
* ends
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
* function for getting contents of
*
* tinymce
*
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
            console.log(data)
            for (errors in rees.errors) {
                toastr.error(rees.errors[errors])
            }
        }
    });
}