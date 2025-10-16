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
                    @if(config('paypal.sandbox.client_id'))
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
                    @else
                        <div class="alert alert-warning">
                            PayPal configuration is missing. Please configure your PayPal credentials in the .env file.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Area End-->
    <!-- Cta Area End -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fonction pour mettre à jour le total d'un item
            function updateItemTotal(itemId, quantity, price) {
                const totalCell = document.querySelector(`tr:has(#quantity-${itemId}) td[data-title="Total"] .amount bdi`);
                if (totalCell) {
                    const newTotal = (quantity * price).toFixed(2);
                    totalCell.innerHTML = `<span>$</span>${newTotal}`;
                }
            }

            // Fonction pour mettre à jour le total général du panier
            function updateCartTotal() {
                let cartTotal = 0;
                const quantityInputs = document.querySelectorAll('.qty-input');
                
                quantityInputs.forEach(input => {
                    const quantity = parseInt(input.value);
                    const row = input.closest('tr');
                    const priceText = row.querySelector('td[data-title="Price"] .amount bdi').textContent;
                    const price = parseFloat(priceText.replace('$', ''));
                    cartTotal += quantity * price;
                });

                // Mettre à jour le sous-total et le total
                const subtotalElements = document.querySelectorAll('td[data-title="Cart Subtotal"] .amount bdi, td[data-title="Total"] .amount bdi');
                subtotalElements.forEach(element => {
                    element.innerHTML = `<span>$</span>${cartTotal.toFixed(2)}`;
                });
            }

            // Supprimer les anciens gestionnaires d'événements pour éviter les conflits
            $('.quantity-plus, .quantity-minus').off('click');
            
            // Gestionnaire pour les boutons +
            document.querySelectorAll('.quantity-plus').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const input = this.parentElement.querySelector('.qty-input');
                    const currentValue = parseInt(input.value);
                    const maxValue = parseInt(input.getAttribute('max')) || 100;
                    
                    if (currentValue < maxValue) {
                        input.value = currentValue + 1;
                        
                        // Mettre à jour le total de l'item
                        const itemId = input.id.replace('quantity-', '');
                        const row = input.closest('tr');
                        const priceText = row.querySelector('td[data-title="Price"] .amount bdi').textContent;
                        const price = parseFloat(priceText.replace('$', ''));
                        
                        updateItemTotal(itemId, currentValue + 1, price);
                        updateCartTotal();
                    }
                });
            });

            // Gestionnaire pour les boutons -
            document.querySelectorAll('.quantity-minus').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const input = this.parentElement.querySelector('.qty-input');
                    const currentValue = parseInt(input.value);
                    const minValue = parseInt(input.getAttribute('min')) || 1;
                    
                    if (currentValue > minValue) {
                        input.value = currentValue - 1;
                        
                        // Mettre à jour le total de l'item
                        const itemId = input.id.replace('quantity-', '');
                        const row = input.closest('tr');
                        const priceText = row.querySelector('td[data-title="Price"] .amount bdi').textContent;
                        const price = parseFloat(priceText.replace('$', ''));
                        
                        updateItemTotal(itemId, currentValue - 1, price);
                        updateCartTotal();
                    }
                });
            });

            // Gestionnaire pour les changements directs dans l'input
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function() {
                    const value = parseInt(this.value);
                    const minValue = parseInt(this.getAttribute('min')) || 1;
                    const maxValue = parseInt(this.getAttribute('max')) || 100;
                    
                    // Valider la valeur
                    if (value < minValue) {
                        this.value = minValue;
                    } else if (value > maxValue) {
                        this.value = maxValue;
                    }
                    
                    // Mettre à jour les totaux
                    const itemId = this.id.replace('quantity-', '');
                    const row = this.closest('tr');
                    const priceText = row.querySelector('td[data-title="Price"] .amount bdi').textContent;
                    const price = parseFloat(priceText.replace('$', ''));
                    
                    updateItemTotal(itemId, parseInt(this.value), price);
                    updateCartTotal();
                });
            });
        });
    </script>
@endsection