<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('genres')
            ->withAvg('ratings', 'rating')
            ->withExists([
                'ratings as user_rated' => fn ($q) =>
                $q->where('user_id', auth()->id())
            ])
            ->get();
        $genres = Genre::all();
        $booksCount = Book::count();

        return Inertia::render('Page/Home', [
            'books' => $books,
            'genres' => $genres,
            'booksCount' => $booksCount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request, Book $book)
    {
        Gate::authorize('create', $book);

        $coverPath = null;

        // сохраняем картинку
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $book = Book::create([
            ...$request->safe()->except(['genres', 'cover']),
            'cover' => $coverPath,
            'author_id' => auth()->id(),
            'rating' => 0,
        ]);

        if ($request->filled('genres')) {
            $genreIds = Genre::whereIn('slug', $request->genres)->pluck('id');
            $book->genres()->sync($genreIds);
        }

        return redirect()->back()->with('success', 'Книга создана');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        Gate::authorize('update', $book);

        $data = $request->validated();

        if ($request->hasFile('cover')) {
            // удаляем старую обложку, если она есть
            if ($book->cover && Storage::exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            // сохраняем новую
            $data['cover'] = $request->file('cover')->store('covers', 'public');

        }

        $book->update($data);

        if (array_key_exists('genres', $data)) {
            $genreIds = Genre::whereIn('slug', $data['genres'])->pluck('id');
            $book->genres()->sync($genreIds);
        }

        return redirect()->back()->with('success', 'Книга обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        Gate::authorize('delete', $book);

        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->forceDelete();

        return redirect()->back()->with('success', 'Книга удалена');
    }
}
