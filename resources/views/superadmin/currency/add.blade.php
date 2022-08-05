@extends('admin.layouts.app')

@section('title')
    {{__('Admin/backend.add_exchange_rate')}}
@endsection

@section('content')
    <div class="page-header">
        <div class="card">
            <div class="card-body">
                <div style="text-align: center;">
                    <h1 class="card-title">{{__('Admin/backend.add_exchange_rate')}}</h1>
                    @include('common.include.alert')
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <form id="formaction" class="forms-sample" method="post" action="{{route('superadmin.currency.store')}}">
                    {{csrf_field()}}
                    
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
                                <label for="name">{{__('Admin/backend.currency')}}</label>
                                <input name="name" type="text" class="form-control" value="{{old('name')}}">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exchange_rate">{{__('Admin/backend.exchange_rate')}}</label>
                                <input class="form-control" type="text" name="exchange_rate" value="{{old('exchange_rate')}}">
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-light" href="{{route('superadmin.currency.index')}}">{{__('Admin/backend.cancel')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Admin/backend.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection