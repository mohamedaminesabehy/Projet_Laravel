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
            <form action="#" class="woocommerce-cart-form">
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
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="quantity style2">
                                        <div class="quantity__field quantity-container">
                                            <div class="quantity__buttons">
                                                <button type="button" class="quantity-plus qty-btn"><i class="fal fa-plus"></i></button>
                                                <input type="number" id="quantity-{{ $item->id }}" class="qty-input" step="1" min="1" max="100" name="quantity" value="{{ $item->quantity }}" title="Qty" onchange="this.form.submit()">
                                                <button type="button" class="quantity-minus qty-btn"><i class="fal fa-minus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td data-title="Total"><span class="amount"><bdi><span>$</span>{{ number_format($item->price * $item->quantity, 2) }}</bdi></span></td>
                            <td data-title="Remove">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove"><i class="fal fa-trash-alt"></i></button>
                                </form>
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
                        <tr class="shipping">
                            <th>Shipping and Handling</th>
                            <td data-title="Shipping and Handling">
                                <ul class="woocommerce-shipping-methods list-unstyled">
                                    <li>
                                        <input type="radio" id="free_shipping" name="shipping_method" class="shipping_method"> <label for="free_shipping">Free shipping</label>
                                    </li>
                                    <li><input type="radio" id="flat_rate" name="shipping_method" class="shipping_method" checked="checked"> <label for="flat_rate">Flat rate</label></li>
                                </ul>
                                <p class="woocommerce-shipping-destination">Shipping options will be updated during checkout.</p>
                                <form action="#" method="post"><a href="#" class="shipping-calculator-button">Change address</a>
                                    <div class="shipping-calculator-form">
                                        <p class="form-row">
                                            <select class="form-select">
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="BD" selected="selected">Bangladesh</option>
                                            </select>
                                        </p>
                                        <p>
                                            <select class="form-select">
                                                <option value="">Select an option…</option>
                                                <option value="BD-05">Bagerhat</option>
                                                <option value="BD-01">Bandarban</option>
                                                <option value="BD-02">Barguna</option>
                                                <option value="BD-06">Barishal</option>
                                            </select>
                                        </p>
                                        <p class="form-row"><input type="text" class="form-control" placeholder="Town / City"></p>
                                        <p class="form-row"><input type="text" class="form-control" placeholder="Postcode / ZIP"></p>
                                        <p><button class="vs-btn">Update</button></p>
                                    </div>
                                </form>
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
                    <script>
                        // Afficher le Client ID pour débogage
                        console.log('Client ID utilisé:', '{{ config('paypal.sandbox.client_id') }}');
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