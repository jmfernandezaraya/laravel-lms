@extends('frontend.layouts.app')

@if (!session()->has('visa_form'))
    @include('frontend.apply_visa_fetch_view.apply_visa_form1')
@else
    @include('frontend.apply_visa_fetch_view.apply_visa_form2')
@endif
