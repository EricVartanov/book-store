<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        return back()->with('success', 'Форма отправлена!');
    }
}
