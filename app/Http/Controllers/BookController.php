<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBook;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllBooks(Request $request)
    {
        try {
            $books = Book::join('users', 'users.id', '=', 'books.user_id')
                            ->where('users.is_active', '=', 1);

            if(isset($request->search) &&  $request->search != ''){
                $books = $books->where('title', 'like' , '%'. $request->search . '%');
            }

            if(isset($request->user_id) &&  $request->user_id != ''){
                $books = $books->where('users.id', '=', $request->user_id);
            }

            $books = $books->select('books.*', 'users.name as created_by')->get();

            return response()->json([
                'error' => false,
                'data' => $books
            ], 200);

        } catch (\Throwable $th) {
             return response()->json([
                'error' => true,
                'data' => 'Internal Server Error'
            ], 500);
        }

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBook $request)
    {
        try {
            $book = Book::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => auth()->user()->id
            ]);


            return response()->json([
                'error' => false,
                'data' => $book
            ], 200);

        } catch (\Throwable $th) {
             return response()->json([
                'error' => true,
                'data' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
