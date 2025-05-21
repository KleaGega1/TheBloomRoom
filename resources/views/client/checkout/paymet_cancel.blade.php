
@extends('layouts.main')

@section('content')
<div class="container py-5">
    <h2 class="text-danger">Payment Cancelled</h2>
    <p>You cancelled the PayPal payment. If this was a mistake, please try again.</p>
    <a href="/cart" class="btn btn-primary mt-3">Back to Cart</a>
</div>
@endsection
