<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRatingStoreRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookRatingController extends Controller
{
    public function store(BookRatingStoreRequest $request, Book $book)
    {
        $user = $request->user();

        // запрет повторного голосования
        if ($book->ratings()->where('user_id', $user->id)->exists()) {
            return back()->withErrors([
                'rating' => 'Вы уже оценили эту книгу'
            ]);
        }

        $book->ratings()->create([
            'user_id' => $user->id,
            'rating' => $request->rating
        ]);

        return back();
    }
}
