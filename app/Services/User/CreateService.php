<?php

namespace App\Services\User;

use App\Models\UserSettings;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CreateService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function run(Request $request) {
        $user = $this->userRepository->findByPhone($request->phone);

        if ($user) {
            throw ValidationException::withMessages([
                'phone' => ['User already exists'],
            ]);
        }

        $user = $this->userRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password
        ]);

        $this->createUserSettings($user->id);

        return $user->createToken($request->phone)->plainTextToken;
    }

    private function createUserSettings($userId)
    {
        $userSettings = new UserSettings();
        $userSettings->user_id = $userId;
        $userSettings->save();
    }
}