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

<script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.7.1/tinymce.min.js" integrity="sha512-RnlQJaTEHoOCt5dUTV0Oi0vOBMI9PjCU7m+VHoJ4xmhuUNcwnB5Iox1es+skLril1C3gHTLbeRepHs1RpSCLoQ==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

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

<script>
    var token = "{{csrf_token()}}";
    var delete_on_confirm = "{{__('SuperAdmin/backend.confirm_delete')}}";
    
    if ($('table') && $('table').length) {
        for (var table_index = 0; table_index < $('table').length; table_index++) {
            var table_el = $($('table')[table_index]);
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
                                    $(cell).html('<input type="checkbox" onclick="toggleAllCheck(' + table_index + ')"/>');
                                } else {
                                    $(cell).html('<p></p>');
                                }
                            } else {
                                $(cell).html('<p></p>');
                            }
                        });
                    }
                });
            } else {
                table_el.DataTable();
            }
        }
    }

    function toggleAllCheck(table_index) {
        var table_el = $($('table')[table_index]);
        var header_select_el = table_el.find('thead th[data-filter="checkbox"] input[type="checkbox"]');
        var body_select_els = table_el.find('tbody tr td input[type="checkbox"]');

        for (var select_index = 0; select_index < body_select_els.length; select_index++) {
            if (header_select_el.is(':checked')) {
                $(body_select_els[select_index]).prop('checked', true);
            } else {                
                $(body_select_els[select_index]).prop('checked', false);
            }
        }
    }
</script>
<!-- End custom js for this page -->
@yield('js')