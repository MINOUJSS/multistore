@php
 $payment_data= session('payment_data') ; 
@endphp
<div class="container">
    <h1>بيانات الدفع</h1>
    <div class="messages">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{route('chargilypay.redirect')}}" method="POST">
                @csrf
                <input type="hidden" name="plan_id" value="{{$payment_data['plan']}}">
                <input type="hidden" name="amount" value="{{$payment_data['plan_price']}}">
                <input type="hidden" name="supplier_id" value="{{get_supplier_data(Auth::user()->tenant->id)->id}}">
                {{-- <input type="hidden" name="email" value="{{$payment_data['email']}}">
                <input type="hidden" name="full_name" value="{{$payment_data['full_name']}}">
                <input type="hidden" name="phone_number" value="{{$payment_data['phone_number']}}"> --}}

                <input type="submit" class="btn btn-primary" value="دفع">
            </form>
        </div>
    </div>
</div>