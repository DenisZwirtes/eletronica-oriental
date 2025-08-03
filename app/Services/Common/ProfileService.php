<?php

namespace App\Services\Common;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    /**
     * Atualiza o perfil do usuário
     */
    public function updateProfile(User $user, array $data): bool
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);

        return true;
    }

    /**
     * Atualiza a senha do usuário
     */
    public function updatePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return true;
    }

    /**
     * Atualiza a foto do perfil
     */
    public function updateProfilePhoto(User $user, UploadedFile $photo): bool
    {
        // Remove foto anterior se existir
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Salva nova foto
        $path = $photo->store('profile-photos', 'public');

        $user->update([
            'profile_photo_path' => $path,
        ]);

        return true;
    }

    /**
     * Remove a foto do perfil
     */
    public function removeProfilePhoto(User $user): bool
    {
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);

            $user->update([
                'profile_photo_path' => null,
            ]);
        }

        return true;
    }

    /**
     * Obtém dados do perfil para exibição
     */
    public function getProfileData(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
                        'profile_photo_url' => $user->profile_photo_path
                ? asset('storage/' . $user->profile_photo_path)
                : null,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }

    /**
     * Verifica se o email já está em uso
     */
    public function isEmailInUse(string $email, ?User $excludeUser = null): bool
    {
        $query = User::where('email', $email);

        if ($excludeUser) {
            $query->where('id', '!=', $excludeUser->id);
        }

        return $query->exists();
    }
}
