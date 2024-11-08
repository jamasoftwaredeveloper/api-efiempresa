<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function login(array $credentials)
    {
        if ($this->userRepository->attemptLogin($credentials)) {
            $user = Auth::user();
            return $user->createToken('API Token')->plainTextToken;
        }

        return null;
    }
}
