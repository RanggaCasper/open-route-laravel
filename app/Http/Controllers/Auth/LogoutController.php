<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ResponseFormatter::redirected('Logout berhasil, session anda telah dihapus!', route('login'));
    }

}
