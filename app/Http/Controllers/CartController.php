<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('book')->get();
        return view('pages.cart', compact('cartItems'));
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Please log in to add items to your cart.', 'redirect' => route('signin')], 401);
        }

        $book = Book::findOrFail($request->book_id);

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('book_id', $book->id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'quantity' => $request->quantity,
                'price' => $book->price,
            ]);
        }

        return response()->json(['message' => 'Book added to cart successfully!', 'redirect' => route('cart')], 200);
    }

    public function update(Request $request, Cart $cartItem)
    {
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('cart')->with('success', 'Cart updated!');
    }

    public function remove(Cart $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart')->with('success', 'Book removed from cart!');
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        }
        return 0;
    }
}
