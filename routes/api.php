<?php

use App\Http\Controllers\Api\SearchUsersContextController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Teste manual:
 *
 * curl --header 'Authorization: Bearer gpp_PREFIX.SECRET' \
 *   '/toolkit/public/api/teste-api/users/USER_ID'
 */
// Rota para testar a autenticação e autorização da API Key de um usuário.
Route::middleware('uspdevApiKeys')
    ->get('/teste-api/users/{user}', function (Request $request, User $user) {
        /** @var \Uspdev\ApiKeys\Models\ApiKey|null $apiKey */
        $apiKey = $request->attributes->get(
            config('api-keys.middleware.request_attribute', 'apiKey')
        );

        abort_unless($apiKey?->owner?->is($user), 403);
        abort_unless($apiKey?->allows('user.read'), 403);

        return response()->json([
            'authenticated' => true,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'purpose' => $apiKey->purpose,
            'role' => $apiKey->role,
        ]);
    });

Route::middleware('uspdevApiKeys')->group(function (): void {
    Route::get('/notebooklm/users', SearchUsersContextController::class);
});

// Route::get('{nameSpace}', [UspdevController::class, 'listarClasses']);
// Route::get('{nameSpace}/{classe}', [UspdevController::class, 'listarMetodos']);

// Route::match(['get', 'post'], 'Replicado/{classe}/{metodo}',[UspdevController::class, 'show']);
