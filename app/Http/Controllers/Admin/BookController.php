<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('admin.books', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:book|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:published,draft',
        ]);

        $book = Book::create($request->except('cover_image'));

        if ($request->hasFile('cover_image')) {
            $imageName = time().'.'.$request->cover_image->extension();
            $request->cover_image->move(public_path('images'), $imageName);
            $book->cover_image = 'images/'.$imageName;
            $book->save();
        }

        return redirect()->route('admin.books.index')->with('success', 'Livre ajouté avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json($book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:book,isbn,'.$book->id.'|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:published,draft',
        ]);

        $book->update($request->except('cover_image'));

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image && file_exists(public_path($book->cover_image))) {
                unlink(public_path($book->cover_image));
            }
            $imageName = time().'.'.$request->cover_image->extension();
            $request->cover_image->move(public_path('images'), $imageName);
            $book->cover_image = 'images/'.$imageName;
            $book->save();
        }

        return redirect()->route('admin.books.index')->with('success', 'Livre mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover_image && file_exists(public_path($book->cover_image))) {
            unlink(public_path($book->cover_image));
        }
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Livre supprimé avec succès!');
    }
}
