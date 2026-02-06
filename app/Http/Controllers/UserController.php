<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        app()->setLocale('ru');

        Gate::authorize('viewAny', Auth::user());

        $users = User::query()
            // Фильтрация через scopeFilter
            ->filter($request->only(['role', 'q']))
            ->orderBy('id', 'asc')
            ->paginate(5)
            // Добавляем параметры запроса к постраничной навигации
            ->appends($request->only(['role', 'q']))
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at,
            ]);

        $userRoles = ['admin', 'user'];

        return Inertia::render('User/Index', [
            'users' => $users,
            'userRoles' => $userRoles,
            'initialFilter' => $request->only(['role', 'q']),
        ]);
    }

    public function dashboard()
    {
        Gate::authorize('view', Auth::user());

        $books = Auth::user()->books()->with('genres')->get();
        $genres = Genre::all();
        $booksCount = $books->count();

        return Inertia::render('User/Dashboard', [
            'books' => $books,
            'booksCount' => $booksCount,
            'genres' => $genres,
        ]);
    }

    /**
     * Форма авторизации
     *
     * GET /login
     */
    public function login()
    {
        return Inertia::render('User/Login');
    }

    /**
     * Авторизация
     *
     * POST /login
     */
    public function loginPost(UserLoginRequest $request)
    {
        if (Auth::attempt($request->validated(), $request->remember)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'password' => 'Неверный пароль',
        ])->onlyInput('email');
    }

    /**
     * Выход из профиля
     *
     * POST /logout
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at->format('d.m.Y'),
        ];
        return Inertia::render('User/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];

        $roles = [['user', 'Пользователь'], ['admin', 'Админ']];

        return Inertia::render('User/Edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {

        $user->update($request->validated());

        return redirect()->route('users.show', $user)->with('success', 'Данные изменены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()->back()->with('success', 'Пользователь удален');
    }
}
