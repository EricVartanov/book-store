<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function home()
    {
        return Inertia::render('/Page/Home');
    }

    public function about()
    {
        return Inertia::render('Page/About', [
            'number' => 42,
            'text' => 'Hello, World!',
            'items' => ['Vue', 'Laravel', 'Inertia'],
            'user' => [
                'name' => 'Eric',
                'age' => 30,
                'role' => 'admin',
            ],
        ]);
    }
}
