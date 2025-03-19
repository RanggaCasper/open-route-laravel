<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseFormatter
{
    public static function created(string $message = "Data berhasil ditambahkan.", mixed $data = null): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 201);
    }

    public static function success(string $message, mixed $data = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error(string $message, mixed $errors = null, int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    public static function redirected(string $message, string $redirect_url, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'redirect_url' => $redirect_url
        ], $code);
    }

    public static function handleError(\Exception $e, string $message = 'Terjadi kesalahan internal server. Silakan coba lagi nanti.'): JsonResponse  
    {  
        $errors = config('app.debug') ? $e->getMessage() : null;
        return self::error($message, $errors, 500);
    }  
}