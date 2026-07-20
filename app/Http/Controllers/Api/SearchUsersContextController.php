<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchUsersContextController extends Controller
{
    public function __invoke(Request $request): Response
    {
        /** @var \Uspdev\ApiKeys\Models\ApiKey|null $apiKey */
        $apiKey = $request->attributes->get(
            config('api-keys.middleware.request_attribute', 'apiKey')
        );

        abort_unless(
            $apiKey?->owner instanceof User,
            Response::HTTP_FORBIDDEN
        );

        abort_unless(
            $apiKey?->purpose === 'ai',
            Response::HTTP_FORBIDDEN
        );

        abort_unless(
            $apiKey?->allows('notebooklm.users.search'),
            Response::HTTP_FORBIDDEN
        );

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $search = trim($validated['search'] ?? '');
        $users = collect();

        if ($search !== '') {
            $users = User::query()
                ->select(['id', 'name', 'email'])
                ->where(function ($query) use ($search): void {
                    $query
                        ->whereLike('name', "%{$search}%")
                        ->orWhereLike('email', "%{$search}%");
                })
                ->orderBy('name')
                ->limit(50)
                ->get();
        }

        return response()
            ->view('api.users-search-context', [
                'search' => $search,
                'users' => $users,
                'generatedAt' => now(),
            ])
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Cache-Control', 'private, no-store')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
