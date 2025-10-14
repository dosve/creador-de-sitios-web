<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class AuthEME10Service
{
    private Client $client;
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.auth_eme10.base_url', 'https://auth.eme10.com/api');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 10,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Iniciar sesión en Auth EME10
     */
    public function login(string $login, string $password): array
    {
        try {
            $response = $this->client->post('/auth/login', [
                'json' => [
                    'login' => $login,
                    'password' => $password,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!$data['success']) {
                return [
                    'success' => false,
                    'message' => $data['message'] ?? 'Error al iniciar sesión',
                ];
            }

            // Si requiere 2FA
            if (isset($data['requires_two_factor']) && $data['requires_two_factor']) {
                return [
                    'success' => true,
                    'requires_two_factor' => true,
                    'temp_token' => $data['temp_token'],
                    'message' => $data['message'],
                    'sent_to' => $data['sent_to'] ?? null,
                    'method' => $data['method'] ?? 'email',
                ];
            }

            // Login exitoso
            return [
                'success' => true,
                'requires_two_factor' => false,
                'user' => $data['data']['user'],
                'token' => $data['data']['token'],
                'roles' => $data['data']['roles'] ?? [],
                'permissions' => $data['data']['permissions'] ?? [],
            ];

        } catch (RequestException $e) {
            Log::error('Auth EME10 Login Error', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
            ]);

            return [
                'success' => false,
                'message' => 'Error de conexión con el servicio de autenticación',
            ];
        }
    }

    /**
     * Verificar código 2FA
     */
    public function verifyTwoFactor(string $tempToken, string $code): array
    {
        try {
            $response = $this->client->post('/two-factor/verify', [
                'json' => [
                    'temp_token' => $tempToken,
                    'code' => $code,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!$data['success']) {
                return [
                    'success' => false,
                    'message' => $data['message'] ?? 'Código inválido',
                ];
            }

            return [
                'success' => true,
                'user' => $data['data']['user'],
                'token' => $data['data']['token'],
                'roles' => $data['data']['roles'] ?? [],
                'permissions' => $data['data']['permissions'] ?? [],
            ];

        } catch (RequestException $e) {
            Log::error('Auth EME10 2FA Error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Error al verificar el código',
            ];
        }
    }

    /**
     * Registrar nuevo usuario en Auth EME10
     */
    public function register(array $data): array
    {
        try {
            $response = $this->client->post('/auth/register', [
                'json' => [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'password' => $data['password'],
                    'password_confirmation' => $data['password_confirmation'],
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (!$result['success']) {
                return [
                    'success' => false,
                    'message' => $result['message'] ?? 'Error al registrar usuario',
                    'errors' => $result['errors'] ?? [],
                ];
            }

            return [
                'success' => true,
                'user' => $result['data']['user'],
                'token' => $result['data']['token'],
            ];

        } catch (RequestException $e) {
            Log::error('Auth EME10 Register Error', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
            ]);

            $response = $e->hasResponse() ? json_decode($e->getResponse()->getBody()->getContents(), true) : null;

            return [
                'success' => false,
                'message' => $response['message'] ?? 'Error de conexión con el servicio de autenticación',
                'errors' => $response['errors'] ?? [],
            ];
        }
    }

    /**
     * Obtener información del usuario autenticado
     */
    public function getUser(string $token): array
    {
        try {
            $response = $this->client->get('/user', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!$data['success']) {
                return [
                    'success' => false,
                    'message' => $data['message'] ?? 'Error al obtener usuario',
                ];
            }

            return [
                'success' => true,
                'user' => $data['data'],
            ];

        } catch (RequestException $e) {
            Log::error('Auth EME10 Get User Error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Token inválido o expirado',
            ];
        }
    }

    /**
     * Cerrar sesión en Auth EME10
     */
    public function logout(string $token): array
    {
        try {
            $response = $this->client->post('/api/auth/logout', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => $data['success'] ?? true,
                'message' => $data['message'] ?? 'Sesión cerrada',
            ];

        } catch (RequestException $e) {
            Log::error('Auth EME10 Logout Error', [
                'message' => $e->getMessage(),
            ]);

            // Aunque falle, consideramos el logout exitoso localmente
            return [
                'success' => true,
                'message' => 'Sesión cerrada localmente',
            ];
        }
    }

    /**
     * Validar token con Auth EME10
     */
    public function validateToken(string $token): bool
    {
        $result = $this->getUser($token);
        return $result['success'];
    }

    /**
     * Crear sesión de app en Auth EME10
     */
    public function createAppSession(string $token): array
    {
        try {
            $response = $this->client->post('/sessions/create', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
                'json' => [
                    'app_name' => config('app.name', 'Creador de Sitios Web'),
                    'app_url' => config('app.url'),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => $data['success'] ?? true,
                'session_id' => $data['data']['session_id'] ?? null,
            ];

        } catch (RequestException $e) {
            Log::error('Auth EME10 Create Session Error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Error al crear sesión',
            ];
        }
    }

    /**
     * Actualizar perfil de usuario en Auth EME10
     */
    public function updateProfile(string $token, array $data): array
    {
        try {
            $payload = array_filter([
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'] ?? null,
                'password_confirmation' => $data['password_confirmation'] ?? null,
            ]);

            $response = $this->client->put('/user/update', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
                'json' => $payload,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (!$result['success']) {
                return [
                    'success' => false,
                    'message' => $result['message'] ?? 'Error al actualizar perfil',
                    'errors' => $result['errors'] ?? [],
                ];
            }

            return [
                'success' => true,
                'user' => $result['data']['user'],
                'message' => $result['message'] ?? 'Perfil actualizado',
            ];

        } catch (RequestException $e) {
            Log::error('Auth EME10 Update Profile Error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Error al actualizar perfil',
            ];
        }
    }
}

