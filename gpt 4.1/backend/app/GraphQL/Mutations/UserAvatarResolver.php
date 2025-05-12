<?php
// app/GraphQL/Mutations/UserAvatarResolver.php
// Mutation clean, sécurisée, pour upload avatar utilisateur
// Ultra commenté, respecte la structure Laravel

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserAvatarResolver
{
    /**
     * Upload et met à jour l’avatar utilisateur
     * @param $_
     * @param array $args
     * @return \App\Models\User
     * @throws ValidationException
     */
    public function __invoke($_, array $args)
    {
        $user = Auth::user();
        $file = $args['avatar'] ?? null;

        // Validation stricte du fichier (image, taille, format)
        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages(['avatar' => 'Fichier invalide.']);
        }
        if (!in_array($file->extension(), ['jpg', 'jpeg', 'png', 'webp'])) {
            throw ValidationException::withMessages(['avatar' => 'Format non supporté.']);
        }
        if ($file->getSize() > 2 * 1024 * 1024) { // 2 Mo max
            throw ValidationException::withMessages(['avatar' => 'Image trop volumineuse.']);
        }

        // Suppression ancien avatar si présent
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Stockage du nouveau
        $path = $file->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        // Enregistrement de l’activité dans le journal (Activity)
        \App\Models\Activity::create([
            'user_id' => $user->id,
            'type' => 'avatar',
            'message' => 'Avatar mis à jour',
            'data' => [
                'avatar' => $path,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'updated_at' => now()->toDateTimeString(),
            ],
        ]);

        return $user;
    }
}
