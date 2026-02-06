<?php
namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Создание книги — любой авторизованный
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Редактирование
     */
    public function update(User $user, Book $book): bool
    {
        return $user->role === 'admin'
            || $book->author_id === $user->id;
    }

    /**
     * Удаление
     */
    public function delete(User $user, Book $book): bool
    {
        return $user->role === 'admin'
            || $book->author_id === $user->id;
    }
}
