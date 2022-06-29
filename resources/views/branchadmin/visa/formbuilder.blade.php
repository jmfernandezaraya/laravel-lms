@extends('branchadmin.layouts.app')

@section('css')
    <style>
        .pl-3:hover {
            cursor: pointer;
        }

        .fa {
            cursor: pointer;
        }

        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none !important;
        }

        #ms-list-1, #ms-list-2, #ms-list-3, #ms-list-4, #ms-list-5, #ms-list-6, #ms-list-7, #ms-list-8, #ms-list-9, #ms-list-11, #ms-list-10 {
            padding: 10px 8px;
            border: 1px solid #ebedf2;
        }

        .ms-options-wrap > .ms-options {
            left: 21px;
            width: 87%;
        }

        button {
            border: none !important;
        }

        i.fa.fa-plus-circle {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 15px 15px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
        }

        i.fa.fa-minus {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 15px 15px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
        }

        i.fa.fa-plus {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 10px 15px 10px 0px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
            margin-left: 5px;
        }

        i.fa.fa-trash {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
            padding: 10px 15px 10px 0px;
            color: #fff;
            border-radius: 10px;
            font-size: 15px;
            margin-left: 5px;
        }

        ul.multiselect-container.dropdown-menu.show {
            width: 100%;
        }

        .multiselect-native-select .btn-group {
            width: 100%;
        }

        button.multiselect.dropdown-toggle.btn.btn-default {
            outline: 1px solid #ebedf2;
            color: #c9c8c8;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
        }

        span.multiselect-selected-text {
            font-size: 12px;
            font-family: sans-serif;
        }
    </style>
@endsection

@section('content')
    <div id="form_builder"></div>
    <div id="render-container"></div>
    <div class="modal fade" id="formsaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{route('visa.store')}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{__('Admin/backend.save_form_name')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="">{{__('Admin/backend.save_form_name')}}</label>
                            <input type="text" class="form-control" name="form_name">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-info">Close</button>
                        <input type="hidden" id="getvalue" name="formvalue">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
            integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
            crossorigin="anonymous"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/jQuery-formBuilder/3.4.2/form-render.min.js"></script>
    <script src="//formbuilder.online/assets/js/form-builder.min.js"></script>

    <script>
        $(document).ready(function () {
            jQuery($ => {
                var formBuilder = $('#form_builder').formBuilder()
                setTimeout(function () {
                    $('.save-template').attr('data-toggle', 'modal');
                    $('.save-template').attr('data-target', '#formsaveModal');
                    $('.save-template').on('click', function () {
                        $("#getvalue").val(formBuilder.actions.getData('json'));
                    });
                }, 1500);
            });
        });
    </script>
@endsection