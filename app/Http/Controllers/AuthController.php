<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="Registro de usuario",
     *     description="Permite registrar un nuevo usuario.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos",
     *     )
     * )
     */
    public function register(AuthRequest $request)
    {
        $this->authService->register($request->all());
        return response()->json(['message' => 'User created successfully'], 201);
    }
    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="Inicio de sesión",
     *     description="Permite a un usuario iniciar sesión y obtener un token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoxMjM0NTY3ODkwLCJleHBpcnkiOjE2MzY1NzMwMzJ9.WVgqOjkVUwYXOkQpR3jtZJ9bwY_YdYwY2bOpwAq7alA")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales inválidas",
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $token = $this->authService->login($credentials);

        if ($token) {
            return response()->json(['token' => $token, "roles" => $request->user()->getRoleNames(), "permissions" => $request->user()->getAllPermissions(), 'user'=>$request->user()]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }


    public function checkToken(Request $request)
    {
        return response()->json([
            'authenticated' => auth()->check(),
            'user' => auth()->user()
        ]);
    }
}
