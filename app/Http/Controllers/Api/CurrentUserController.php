<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrentUserController extends Controller
{
    /** Retorna em JSON somente o usuário proprietário da API Key autenticada. */
    public function __invoke(Request $request): JsonResponse
    {
        // Pega a API Key do request, que foi adicionada pelo middleware de autenticação de API Key.
        /** @var \Uspdev\ApiKeys\Models\ApiKey|null $apiKey */
        $apiKey = $request->attributes->get(
            config('api-keys.middleware.request_attribute', 'apiKey')
        );

        abort_unless($apiKey?->owner instanceof User, Response::HTTP_FORBIDDEN);
        abort_unless($apiKey->allows('user.read'), Response::HTTP_FORBIDDEN);

        $user = $apiKey->owner;

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}
