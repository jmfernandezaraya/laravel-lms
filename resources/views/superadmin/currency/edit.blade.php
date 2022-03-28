@extends('superadmin.layouts.app')
@section('content')
    @section('css')
        <style>
            #formaction {
                width: 100%;
            }
        </style>
    @endsection
    <div class="col-12 grid-margin stretch-card">
        <form id="formaction" class="forms-sample" method="post" action = "{{route('superadmin.currency.update', $currency->id)}}">
            {{csrf_field()}}
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <center>
                                <h1 class="card-title">{{__('SuperAdmin/backend.update_exchange_rate')}}</h1>
                            </center>
                        </div>
                    </div>

                    @include('superadmin.include.alert')

                    <div id="show_form"></div>

                    @csrf

                    <div id="form1">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="name">{{__('SuperAdmin/backend.currency')}}</label>
                                <input value="{{$currency->name}}" name="name" type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exchange_rate">{{__('SuperAdmin/backend.exchange_rate')}}</label>
                                <input class="form-control" type="text" name="exchange_rate" value="{{$currency->exchange_rate}}">
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{route('superadmin.currency.index')}}">{{__('SuperAdmin/backend.cancel')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('SuperAdmin/backend.update')}}</button>
                </div>
            </div>
        </form>
    </div>
@endsection