@extends('layouts.public')

@section('title', 'Orden #' . $order->order_number . ' - ' . ($website->name ?? 'Tienda'))

@section('content')
    @include('checkout.order-content', ['website' => $website, 'order' => $order])
@endsection

