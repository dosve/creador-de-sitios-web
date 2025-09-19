<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    protected $apiKey;
    public $baseUrl;

    public function __construct($apiKey, $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');

        // Si la URL base no termina en /api, agregarlo
        if (!str_ends_with($this->baseUrl, '/api')) {
            $this->baseUrl .= '/api';
        }
    }

    /**
     * Obtiene información del negocio
     */
    public function getBusiness()
    {
        $url = $this->baseUrl . '/api-key/business';

        Log::info('ExternalApiService: Intentando obtener información del negocio', [
            'url' => $url,
            'api_key' => substr($this->apiKey, 0, 10) . '...',
            'headers' => [
                'X-API-Key' => substr($this->apiKey, 0, 10) . '...',
                'Content-Type' => 'application/json'
            ]
        ]);

        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($url);

            Log::info('ExternalApiService: Respuesta del servidor', [
                'url' => $url,
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
                'successful' => $response->successful()
            ]);

            if ($response->successful()) {
                $jsonResponse = $response->json();
                Log::info('ExternalApiService: Respuesta JSON parseada', [
                    'json' => $jsonResponse
                ]);
                return $jsonResponse;
            }

            Log::error('ExternalApiService: Error al obtener información del negocio', [
                'url' => $url,
                'status' => $response->status(),
                'response' => $response->body(),
                'headers' => $response->headers()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('ExternalApiService: Excepción al obtener información del negocio', [
                'url' => $url,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Obtiene productos con filtros opcionales
     */
    public function getProducts($filters = [])
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/api-key/products', $filters);

            if ($response->successful()) {
                $data = $response->json();
                
                // Normalizar la respuesta - convertir objeto con claves numéricas a array
                if (isset($data['data']) && is_array($data['data'])) {
                    // Si data.data es un objeto con claves numéricas, convertirlo a array
                    if (array_keys($data['data']) !== range(0, count($data['data']) - 1)) {
                        $data['data'] = array_values($data['data']);
                    }
                }
                
                Log::info('ExternalApiService: Productos normalizados', [
                    'original_keys' => isset($data['data']) ? array_keys($data['data']) : 'no_data',
                    'normalized_count' => isset($data['data']) ? count($data['data']) : 0
                ]);
                
                return $data;
            }

            Log::error('Error al obtener productos', [
                'status' => $response->status(),
                'response' => $response->body(),
                'filters' => $filters
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al obtener productos', [
                'error' => $e->getMessage(),
                'filters' => $filters
            ]);
            return null;
        }
    }

    /**
     * Obtiene un producto específico por ID
     */
    public function getProduct($id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/api-key/products/' . $id);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al obtener producto', [
                'id' => $id,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al obtener producto', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Obtiene categorías con filtros opcionales
     */
    public function getCategories($filters = [])
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/api-key/categories', $filters);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al obtener categorías', [
                'status' => $response->status(),
                'response' => $response->body(),
                'filters' => $filters
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al obtener categorías', [
                'error' => $e->getMessage(),
                'filters' => $filters
            ]);
            return null;
        }
    }

    /**
     * Obtiene pedidos con filtros opcionales
     */
    public function getOrders($filters = [])
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/api-key/orders', $filters);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al obtener pedidos', [
                'status' => $response->status(),
                'response' => $response->body(),
                'filters' => $filters
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al obtener pedidos', [
                'error' => $e->getMessage(),
                'filters' => $filters
            ]);
            return null;
        }
    }

    /**
     * Obtiene un pedido específico por ID
     */
    public function getOrder($id)
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/api-key/orders/' . $id);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error al obtener pedido', [
                'id' => $id,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Excepción al obtener pedido', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Verifica si la API Key es válida
     */
    public function validateApiKey()
    {
        Log::info('ExternalApiService: Validando API Key');
        $business = $this->getBusiness();
        $isValid = $business !== null && isset($business['success']) && $business['success'];

        Log::info('ExternalApiService: Resultado de validación', [
            'is_valid' => $isValid,
            'business_response' => $business
        ]);

        return $isValid;
    }

    /**
     * Obtiene el nombre del negocio
     */
    public function getBusinessName()
    {
        $business = $this->getBusiness();
        if ($business && isset($business['data']['name'])) {
            return $business['data']['name'];
        }
        return null;
    }
}
