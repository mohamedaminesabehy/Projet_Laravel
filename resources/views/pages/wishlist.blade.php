@extends('layouts.app')

@section('content')
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.png') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">wishlist</h1>
                <div class="breadcumb-menu-wrap">
                    <div class="breadcumb-menu">
                        <span><a href="{{ route('home') }}">Home</a></span>
                        <span>wishlist</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
  

<!--======== Wishlist Section ========-->
    <div class="wishlist-area space">
        <div class="container">
            <div class="tinv-wishlist woocommerce tinv-wishlist-clear">
                <div class="tinv-header">
                    <h2 class="mb-30">Wishlist</h2>
                </div>
                <form action="#" method="post" autocomplete="off">
                    <table class="tinvwl-table-manage-list">
                        <thead>
                            <tr>
                                <th class="product-cb">
                                    <input type="checkbox" class="global-cb" title="Select all for bulk action">
                                </th>
                                <th class="product-remove"></th>
                                <th class="product-thumbnail">Images</th>
                                <th class="product-name">
                                    <span class="tinvwl-full">Product Name</span><span class="tinvwl-mobile">Product</span>
                                </th>
                                <th class="product-price">Unit Price</th>
                                <th class="product-date">Date Added</th>
                                <th class="product-stock">Stock Status</th>
                                <th class="product-action">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="wishlist_item">
                                <td class="product-cb">
                                    <input type="checkbox" name="wishlist_pr[]" value="58" title="Select for bulk action">
                                </td>
                                <td class="product-remove">
                                    <button type="submit" name="tinvwl-remove" value="58" title="Remove"><i class="fal fa-times"></i>
                                    </button>
                                </td>
                                <td class="product-thumbnail">
                                    <a href="{{ route('shop') }}"><img src="{{ asset('assets/img/product/p-thumb-1.jpg') }}" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="image"></a>
                                </td>
                                <td class="product-name">
                                    <a href="{{ route('shop') }}">Vqirk Teur Mocgkcup</a>
                                </td>
                                <td class="product-price">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>45.00</bdi></span>
                                </td>
                                <td class="product-date">
                                    <time class="entry-date" datetime="2024-11-21 03:54:24">November 21, 2024</time>
                                </td>
                                <td class="product-stock">
                                    <p class="stock in-stock">
                                        <span><i class="fas fa-check"></i></span><span class="tinvwl-txt">In stock</span>
                                    </p>
                                </td>
                                <td class="product-action">
                                    <button class="button vs-btn alt" name="tinvwl-add-to-cart" value="58" title="Add to Cart">
                                        <i class="fal fa-shopping-cart"></i><span class="tinvwl-txt">Add to Cart</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="wishlist_item">
                                <td class="product-cb">
                                    <input type="checkbox" name="wishlist_pr[]" value="60" title="Select for bulk action">
                                </td>
                                <td class="product-remove">
                                    <button type="submit" name="tinvwl-remove" value="60" title="Remove"><i class="fal fa-times"></i>
                                    </button>
                                </td>
                                <td class="product-thumbnail">
                                    <a href="{{ route('shop') }}"><img src="{{ asset('assets/img/product/p-thumb-2.jpg') }}" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="image"></a>
                                </td>
                                <td class="product-name">
                                    <a href="{{ route('shop') }}">Hd Pry Balir Ptonnrnle</a>
                                </td>
                                <td class="product-price">
                                    <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></ins>
                                    <del><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>20.00</bdi></span></del>
                                </td>
                                <td class="product-date">
                                    <time class="entry-date" datetime="2024-11-21 03:54:24">November 21, 2024</time>
                                </td>
                                <td class="product-stock">
                                    <p class="stock in-stock"><span><i class="fas fa-check"></i></span><span class="tinvwl-txt">In stock</span></p>
                                </td>
                                <td class="product-action">
                                    <button class="button vs-btn alt" name="tinvwl-add-to-cart" value="60" title="Add to Cart">
                                        <i class="fal fa-shopping-cart"></i><span class="tinvwl-txt">Add to Cart</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="wishlist_item">
                                <td class="product-cb">
                                    <input type="checkbox" name="wishlist_pr[]" value="60" title="Select for bulk action">
                                </td>
                                <td class="product-remove">
                                    <button type="submit" name="tinvwl-remove" value="60" title="Remove"><i class="fal fa-times"></i>
                                    </button>
                                </td>
                                <td class="product-thumbnail">
                                    <a href="{{ route('shop') }}"><img src="{{ asset('assets/img/product/p-thumb-3.jpg') }}" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="image"></a>
                                </td>
                                <td class="product-name">
                                    <a href="{{ route('shop') }}">Beuto minimal Cork</a>
                                </td>
                                <td class="product-price">
                                    <ins><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></ins>
                                    <del><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>20.00</bdi></span></del>
                                </td>
                                <td class="product-date">
                                    <time class="entry-date" datetime="2024-11-21 03:54:24">November 21, 2024</time>
                                </td>
                                <td class="product-stock">
                                    <p class="stock in-stock"><span><i class="fas fa-check"></i></span><span class="tinvwl-txt">In stock</span></p>
                                </td>
                                <td class="product-action">
                                    <button class="button vs-btn alt" name="tinvwl-add-to-cart" value="60" title="Add to Cart">
                                        <i class="fal fa-shopping-cart"></i><span class="tinvwl-txt">Add to Cart</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <div class="social-buttons">
                    <span>Share on</span>
                    <ul>
                        <li><a href="#" class="social social-facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" class="social social-twitter " title="Twitter"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href="#" class="social social-pinterest " title="Pinterest"><i class="fab fa-pinterest-p"></i></a></li>
                        <li><a href="#" class="social social-whatsapp " title="WhatsApp"><i class="fab fa-whatsapp"></i></a></li>
                        <li><a href="#" class="social social-clipboard " title="Clipboard"><i class="far fa-clipboard"></i></a></li>
                        <li><a href="#" class="social social-email " title="Email"><i class="far fa-envelope"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection