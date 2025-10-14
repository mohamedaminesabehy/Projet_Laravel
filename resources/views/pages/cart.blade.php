@extends('layouts.app')

@section('content')
    <!--==============================
    Breadcrumb
============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Cart</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Area Start-->
    <div class="vs-cart-wrapper space-top space-extra-bottom">
        <div class="container">
            <div class="woocommerce-notices-wrapper">
                <div class="woocommerce-message">Shipping costs updated.</div>
            </div>
            <form id="bulk-form" action="{{ route('cart.bulkUpdate') }}" method="POST" class="woocommerce-cart-form">
                @csrf
                <table class="cart_table">
                    <thead>
                    <tr>
                        <th class="cart-col-image">Image</th>
                        <th class="cart-col-productname">Product Name</th>
                        <th class="cart-col-price">Price</th>
                        <th class="cart-col-quantity">Quantity</th>
                        <th class="cart-col-total">Total</th>
                        <th class="cart-col-remove">Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $total = 0; @endphp
                    @foreach($cartItems as $item)
                        <tr class="cart_item">
                            <td data-title="Product"><a class="cart-productimage" href="{{ route('shop-details', $item->book->id) }}"><img width="100" height="95" src="{{ asset('' . $item->book->cover_image) }}" alt="Image"></a></td>
                            <td data-title="Name"><a class="cart-productname" href="{{ route('shop-details', $item->book->id) }}">{{ $item->book->title }}</a></td>
                            <td data-title="Price"><span class="amount"><bdi><span>$</span>{{ number_format($item->price, 2) }}</bdi></span></td>
                            <td data-title="Quantity">
                                <div class="quantity style2">
                                    <div class="quantity__field quantity-container">
                                        <div class="quantity__buttons">
                                            <button type="button" class="quantity-plus qty-btn"><i class="fal fa-plus"></i></button>
                                            <input type="number" id="quantity-{{ $item->id }}" class="qty-input" step="1" min="1" max="100" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" title="Qty">
                                            <button type="button" class="quantity-minus qty-btn"><i class="fal fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Total"><span class="amount"><bdi><span>$</span>{{ number_format($item->price * $item->quantity, 2) }}</bdi></span></td>
                            <td data-title="Remove">
                                <button type="submit" class="remove" form="remove-{{ $item->id }}"><i class="fal fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        @php $total += $item->price * $item->quantity; @endphp
                    @endforeach
                    <tr>
                        <td colspan="6" class="actions">
                            <div class="vs-cart-coupon">
                                <input type="text" class="form-control" placeholder="Coupon Code...">
                                <button type="submit" class="vs-btn">Apply Coupon</button>
                            </div>
                            <button type="submit" class="vs-btn">Update cart</button>
                            <a href="{{ route('shop') }}" class="vs-btn">Continue Shopping</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
-+            {{-- Hidden standalone forms for item removal to avoid nested forms inside the bulk update form --}}
-+            @foreach($cartItems as $item)
-+                <form id="remove-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:none;">
-+                    @csrf
-+                    @method('DELETE')
-+                </form>
-+            @endforeach
+            {{-- Hidden standalone forms for item removal to avoid nested forms inside the bulk update form --}}
+            @foreach($cartItems as $item)
+                <form id="remove-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:none;">
+                    @csrf
+                    @method('DELETE')
+                </form>
+            @endforeach
            <div class="row justify-content-end">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h2 class="h4 summary-title">Cart Totals</h2>
                    <table class="cart_totals">
                        <tbody>
                        <tr>
                            <td>Cart Subtotal</td>
                            <td data-title="Cart Subtotal"><span class="amount"><bdi><span>$</span>{{ number_format($total, 2) }}</bdi></span>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr class="order-total">
                            <td>Order Total</td>
                            <td data-title="Total"><strong><span class="amount"><bdi><span>$</span>{{ number_format($total, 2) }}</bdi></span></strong></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="wc-proceed-to-checkout">
                        <form action="{{ route('paypal.process') }}" method="POST">
                            @csrf
                            <button type="submit" class="vs-btn">Proceed to checkout with PayPal</button>
                        </form>
                    </div>
                    
                    <!-- PayPal SDK Integration -->
                    <div id="paypal-config" data-client-id="{{ config('paypal.sandbox.client_id') }}" style="display:none;"></div>
                    <script>
                        // Afficher le Client ID pour débogage sans insérer de Blade dans le JS
                        var cfgEl = document.getElementById('paypal-config');
                        var paypalClientId = cfgEl ? cfgEl.getAttribute('data-client-id') : '';
                        console.log('Client ID utilisé:', paypalClientId);
                    </script>
                    <script 
                        src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.sandbox.client_id') }}" 
                        data-namespace="paypal_sdk">
                    </script>
                    <script>
                        // Simple initialization to confirm SDK loading
                        document.addEventListener('DOMContentLoaded', function() {
                            console.log('PayPal SDK initialized');
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Area End-->
    <!-- Cta Area End -->
@endsection