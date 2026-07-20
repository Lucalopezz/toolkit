<?php

/*
|--------------------------------------------------------------------------
| Configuração da interface de API Keys
|--------------------------------------------------------------------------
| Este arquivo sobrescreve a configuração publicada pelo package para esta
| aplicação hospedeira.
*/

return [
    'owners' => [
        'user' => App\Models\User::class,
    ],

    'prefix' => 'api-keys',

    'credential_prefix' => env('API_KEYS_CREDENTIAL_PREFIX', 'gpp'),
    'public_prefix_length' => (int) env('API_KEYS_PUBLIC_PREFIX_LENGTH', 6),
    'secret_bytes' => (int) env('API_KEYS_SECRET_BYTES', 32),

    'middleware' => [
        'alias' => env('API_KEYS_MIDDLEWARE_ALIAS', 'uspdevApiKeys'),
        'request_attribute' => env('API_KEYS_REQUEST_ATTRIBUTE', 'apiKey'),
    ],

    'query_parameter' => [
        'enabled' => (bool) env('API_KEYS_QUERY_PARAMETER_ENABLED', false),
        'name' => env('API_KEYS_QUERY_PARAMETER_NAME', 'api_key'),
    ],

    'management' => [
        'middleware' => [
            'web',
            'auth',
        ],
        'ability' => 'manageApiKeys',
        'page' => [
            'enabled' => (bool) env('API_KEYS_MANAGEMENT_PAGE_ENABLED', true),
            'layout' => env('API_KEYS_MANAGEMENT_LAYOUT', 'laravel-usp-theme::master'),
        ],
    ],

    'theme' => [
        'menu' => [
            'enabled' => (bool) env('API_KEYS_USP_THEME_MENU_ENABLED', false),
            'item' => [
                'text' => '<i class="fas fa-key"></i> API Keys',
                'url' => 'api-keys',
            ],
        ],
    ],

    'interface' => [
        'purposes' => [
            'integration' => 'Integração',
            'ai' => 'IA',
        ],
        'roles' => [
            'viewer' => 'Visualizador (NotebookLM)',
            'user' => 'Usuário',
            'manager' => 'Gerente',
            'admin' => 'Administrador',
        ],
    ],
];
