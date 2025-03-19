<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Helpers\ExceptionHandler;
use Illuminate\Routing\Controller;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }
    
    /**
     * Handle an incoming login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return ResponseFormatter::redirected('Login berhasil', route("dashboard"));
            }
            return ResponseFormatter::error('Kredensial yang anda masukan salah', code: 422);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);  

        }
    }
}
