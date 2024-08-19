<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;

class ResponseHelper
{
    public static function handleRequest(callable $callback, ...$params)
    {
        try {
            return $callback(...$params);
        } catch (Exception $e) {
            Log::error('Bir hata oluştu: ' . $e->getMessage());
            return response()->json(['messages' => 'Beklenmedik bir hata oluştu.'], 500);
        }
    }
}
