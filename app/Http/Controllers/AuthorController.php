<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\CreateRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $limit = abs($request->input('limit', 10));

        $results = Author::where('name', 'LIKE', "%{$search}%")
            ->orderBy('updated_at', 'desc')
            ->paginate($limit);

        return $this->handleResponse(true, 'get data authors', $results, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();
        $createAuthor = Author::create($validated);
        return $this->handleResponse(true, 'success create author', null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $author->load('books');
        return $this->handleResponse(true, 'success get detail author', null, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRequest $request, Author $author)
    {
        $validated = $request->validated();
        $author->update($validated);
        return $this->handleResponse(true, 'success update author', null, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return $this->handleResponse(true, 'deleted author ', null, 200);
    }
}
