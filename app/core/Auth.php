<?php

namespace App\Core;

use App\Repositories\UserRepository;

class Auth
{
    protected static ?array $user = null;
    protected static bool $resolved = false;

    public static function attempt(string $email, string $password): bool
    {
        $repo = new UserRepository();
        $user = $repo->findByEmail($email);

        if (!$user || $user['status'] !== 'active') {
            return false;
        }

        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }

        self::login($user);
        return true;
    }

    public static function login(array $user): void
    {
        Session::regenerate();
        Session::put('user_id', $user['id']);
        self::$user = $user;
        self::$resolved = true;
    }

    public static function logout(): void
    {
        Session::forget('user_id');
        self::$user = null;
        self::$resolved = true;
        Session::destroy();
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function user(): ?array
    {
        if (self::$resolved) {
            return self::$user;
        }

        self::$resolved = true;
        $id = Session::get('user_id');

        if (!$id) {
            return null;
        }

        $repo = new UserRepository();
        $user = $repo->find($id);

        if (!$user || $user['status'] !== 'active') {
            return null;
        }

        self::$user = $user;
        return $user;
    }

    public static function id(): ?int
    {
        $user = self::user();
        return $user ? (int) $user['id'] : null;
    }

    public static function isAdmin(): bool
    {
        $user = self::user();
        return $user && (int) $user['role_id'] === 2;
    }
}
