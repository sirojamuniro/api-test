<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\CreateRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $limit = abs($request->input('limit', 10));

        $results = Book::where('title', 'LIKE', "%{$search}%")
            ->orderBy('updated_at', 'desc')
            ->paginate($limit);

        return $this->handleResponse(true, 'get data books', $results, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();
        $createAuthor = Book::create($validated);
        return $this->handleResponse(true, 'success create book', null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('author');
        return $this->handleResponse(true, 'success get detail book', null, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRequest $request, Book $book)
    {
        $validated = $request->validated();
        $book->update($validated);
        return $this->handleResponse(true, 'success update book', null, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return $this->handleResponse(true, 'deleted author ', null, 200);
    }
}
