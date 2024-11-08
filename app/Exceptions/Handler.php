<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        /*
        if ($request->is('api/register') || $request->is('api/login') || $request->is('api/products')) {
            return parent::render($request, $exception);
        }  */
        if ($request->is('/')) {
            return redirect('/api/documentation');
        }
        if ($exception instanceof ValidationException) {
            return response()->json([
                'errors' => $exception->errors(),
            ], 422);
        }
        if ($request->is('api/*')) {
            // Verificar si el token está presente
            if (!$request->bearerToken()) {
                return response()->json([
                    'error' => 'Unauthorized, token is missing or invalid.'
                ], 401);
            }

            // Intentar autenticar al usuario con el token
            if (!Auth::guard('sanctum')->check()) {
                return response()->json([
                    'error' => 'Unauthorized, invalid token.'
                ], 401);
            }
        }


        return parent::render($request, $exception);
    }
}
