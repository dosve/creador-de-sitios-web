@extends('layouts.public')

@section('title', 'Orden #' . $order->order_number . ' - ' . ($website->name ?? 'Tienda'))

@section('content')
    @include('checkout.order-content', ['website' => $website, 'order' => $order])
    
    @if(session('payment_success') || $order->payment_status === 'paid')
    <script>
        // Limpiar carrito cuando el pago fue exitoso
        (function() {
            console.log('✅ Pago exitoso detectado, limpiando carrito...');
            
            // Limpiar carrito del localStorage
            localStorage.setItem('cart', JSON.stringify([]));
            localStorage.removeItem('cartCheckoutData');
            
            // Limpiar carrito del estado si existe
            if (window.getCartState) {
                const cartState = window.getCartState();
                if (cartState) {
                    cartState.items = [];
                    console.log('✅ Carrito limpiado desde CartState');
                }
            }
            
            // Disparar evento para actualizar la UI
            window.dispatchEvent(new CustomEvent('cartUpdated'));
            
            console.log('✅ Carrito limpiado completamente');
        })();
    </script>
    @endif
@endsection

