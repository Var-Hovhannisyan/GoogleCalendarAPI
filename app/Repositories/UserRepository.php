<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function saveOrUpdate(?User $user, $data): User
    {
        if (!$user) {
            $user = User::create([
                'name' => $data->getName(),
                'email' => $data->getEmail(),
                'google_id' => $data->getId(),
                'password' => bcrypt(uniqid()),
                'avatar' => $data->getAvatar(),
            ]);
        } else {
            $user->update([
                'name' => $data->getName(),
                'google_id' => $data->getId(), // Ensure latest Google ID is stored
                'avatar' => $data->getAvatar(), // Update profile picture
            ]);
        }

        return $user;
    }
}
