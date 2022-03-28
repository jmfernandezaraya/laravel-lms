@extends('superadmin.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
<div class="card">
<div class="card-body table table-responsive">
<div style="text-align: center;"><h1 class="card-title">{{__('SuperAdmin/backend.payment_received')}}</h1></div>

<table class="table table-hover table-bordered">
<thead>
<tr>
<th>#</th>
<th>Order Id</th>
    <th>Amount</th>
    <th>Description</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Billing Address</th>
    <th>Billing City</th>
    <th>Billing Region</th>
    <th>Billing Country</th>
    <th>Billing Zip</th>
    <th>Billing Email</th>
    <th>Transaction Reference</th>
    <th>Status</th>

    <th>Dated</th>

</tr>
</thead>
<tbody>

@foreach($payments as $payment)
<tr>

<td>{{$loop->iteration}}</td>
        <td>{{$payment->order_id}}</td>
        <td>{{$payment->amount}}</td>
        <td>{{$payment->description}}</td>
        <td>{{$payment->billing_fname}}</td>
        <td>{{$payment->billing_sname}}</td>
        <td>{{$payment->billing_address_1 . " " . $payment->billing_address_2}}</td>
        <td>{{$payment->billing_city}}</td>
        <td>{{$payment->billing_region}}</td>
        <td>{{$payment->billing_country}}</td>
        <td>{{$payment->billing_zip}}</td>
        <td>{{$payment->billing_email}}</td>
        <td>{{$payment->trx_reference}}</td>
        <td>{{$payment->status == 1 ? __('SuperAdmin/backend.success') :__('SuperAdmin/backend.failed')}}</td>
        <td>{{$payment->created_at}}</td>




  {{--

<td>
<div class="btn-group">
<a href  = "" class="btn btn-info btn-sm fa fa-pencil"></a>
 <form action="" method="post">

<button onclick="return confirmDelete()" class="btn btn-danger btn-sm fa fa-trash"></button>

</form>
</div>
</td>--}}

</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>



@endsection
