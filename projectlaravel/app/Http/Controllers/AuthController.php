<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\AuthUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Проверяем соответствие логина и пароля в таблице 'auth_users'
        $user = AuthUser::where('username', $username)->first();

        if ($user && $user->password === $password) {
            // Пользователь найден и пароль совпадает

            if ($user->key === 0) {
                // Соответствие логина, пароля и ключа 0
                return response()->json(['success' => true, 'key' => $user->key]);
            } else if ($user->key === 1) {
                // Соответствие логина, пароля и ключа 1
                return response()->json(['success' => true, 'key' => $user->key]);
            } else if ($user->key === 2) {
                // Соответствие логина, пароля и ключа 1
                return response()->json(['success' => true, 'key' => $user->key]);
            } else {
                // Не соответствует ключу
                return response()->json(['success' => false, 'key' => $user->key]);
            }
        } else {
            // Неверный логин или пароль, или пользователь не найден
            return response()->json(['success' => false, 'key' => null]);
        }
    }

}