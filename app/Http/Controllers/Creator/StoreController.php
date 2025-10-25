<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Order;
use App\Models\Customer;
use App\Services\ExternalApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreController extends Controller
{
    use AuthorizesRequests;


    /**
     * Lista de productos
     */
    public function products(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);

        $products = [];
        $externalProducts = [];
        $useExternalApi = false;
        $pagination = null;

        // Verificar si hay configuración de API externa
        if ($website->api_key && $website->api_base_url) {
            try {
                $apiService = new ExternalApiService($website->api_key, $website->api_base_url);

                // Obtener parámetros de paginación de la request
                $perPage = $request->get('per_page', 12);
                $page = $request->get('page', 1);

                $apiResponse = $apiService->getProducts([
                    'paginate' => $perPage,
                    'page' => $page,
                    'estado' => 1
                ]);

                if ($apiResponse && isset($apiResponse['success']) && $apiResponse['success']) {
                    $externalProducts = $apiResponse['data'];
                    $pagination = $apiResponse['pagination'] ?? null;

                    // Construir URLs completas para las imágenes
                    foreach ($externalProducts as &$product) {
                        if (!empty($product['img'])) {
                            // Construir URL completa de la imagen
                            $baseImageUrl = rtrim($website->api_base_url, '/api');
                            $product['img'] = $baseImageUrl . '/storage/productos/' . $product['img'];
                        }
                    }

                    // Corregir el current_page si la API no lo devuelve correctamente
                    if ($pagination && isset($pagination['current_page'])) {
                        $pagination['current_page'] = (int) $page;
                    }

                    $useExternalApi = true;
                }
            } catch (\Exception $e) {
                // Si falla la API externa, usar productos locales
                $products = $website->blogPosts()
                    ->where('is_product', true)
                    ->with(['category', 'tags'])
                    ->latest()
                    ->get();
            }
        }

        // Si no hay API externa o falló, usar productos locales
        if (!$useExternalApi) {
            $products = $website->blogPosts()
                ->where('is_product', true)
                ->with(['category', 'tags'])
                ->latest()
                ->get();
        }

        // Debug: Log para verificar qué está pasando
        Log::info('StoreController products', [
            'website_id' => $website->id,
            'useExternalApi' => $useExternalApi,
            'externalProducts_count' => count($externalProducts),
            'localProducts_count' => is_array($products) ? count($products) : $products->count(),
            'has_api_key' => !empty($website->api_key),
            'has_api_url' => !empty($website->api_base_url)
        ]);

        // Si es una petición AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            Log::info('StoreController: Respuesta AJAX para productos', [
                'useExternalApi' => $useExternalApi,
                'externalProducts_count' => count($externalProducts),
                'localProducts_count' => is_array($products) ? count($products) : $products->count(),
                'has_api_key' => !empty($website->api_key),
                'has_api_url' => !empty($website->api_base_url)
            ]);

            return response()->json([
                'success' => true,
                'products' => $useExternalApi ? $externalProducts : $products,
                'pagination' => $pagination,
                'useExternalApi' => $useExternalApi
            ]);
        }

        return view('creator.store.products', compact('products', 'externalProducts', 'useExternalApi', 'pagination'));
    }

    /**
     * Categorías de productos
     */
    public function categories(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);

        $categories = [];
        $externalCategories = [];
        $useExternalApi = false;
        $pagination = null;

        // Verificar si hay configuración de API externa
        if ($website->api_key && $website->api_base_url) {
            try {
                $apiService = new ExternalApiService($website->api_key, $website->api_base_url);

                // Obtener parámetros de paginación de la request
                $perPage = $request->get('per_page', 12);
                $page = $request->get('page', 1);


                $apiResponse = $apiService->getCategories([
                    'paginate' => $perPage,
                    'page' => $page
                ]);

                if ($apiResponse && isset($apiResponse['success']) && $apiResponse['success']) {
                    $externalCategories = $apiResponse['data'];
                    $pagination = $apiResponse['pagination'] ?? null;

                    // Corregir el current_page si la API no lo devuelve correctamente
                    if ($pagination && isset($pagination['current_page'])) {
                        $pagination['current_page'] = (int) $page;
                    }

                    $useExternalApi = true;
                }
            } catch (\Exception $e) {
                // Si falla la API externa, usar categorías locales
                $categories = $website->categories()
                    ->withCount('blogPosts')
                    ->latest()
                    ->get();
            }
        }

        // Si no hay API externa o falló, usar categorías locales
        if (!$useExternalApi) {
            $categories = $website->categories()
                ->withCount('blogPosts')
                ->latest()
                ->get();
        }

        return view('creator.store.categories', compact('categories', 'externalCategories', 'useExternalApi', 'pagination'));
    }

    /**
     * Lista de pedidos
     */
    public function orders(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);

        $orders = [];
        $externalOrders = [];
        $useExternalApi = false;
        $pagination = null;

        // Verificar si hay configuración de API externa
        if ($website->api_key && $website->api_base_url) {
            try {
                $apiService = new ExternalApiService($website->api_key, $website->api_base_url);
                $filters = [];

                // Aplicar filtros si existen
                if ($request->has('estado')) {
                    $filters['estado'] = $request->estado;
                }
                if ($request->has('fecha_desde')) {
                    $filters['fecha_desde'] = $request->fecha_desde;
                }
                if ($request->has('fecha_hasta')) {
                    $filters['fecha_hasta'] = $request->fecha_hasta;
                }

                // Obtener parámetros de paginación de la request
                $perPage = $request->get('per_page', 12);
                $page = $request->get('page', 1);

                $filters['paginate'] = $perPage;
                $filters['page'] = $page;

                $apiResponse = $apiService->getOrders($filters);

                if ($apiResponse && isset($apiResponse['success']) && $apiResponse['success']) {
                    $externalOrders = $apiResponse['data'];
                    $pagination = $apiResponse['pagination'] ?? null;

                    // Corregir el current_page si la API no lo devuelve correctamente
                    if ($pagination && isset($pagination['current_page'])) {
                        $pagination['current_page'] = (int) $page;
                    }

                    $useExternalApi = true;
                }
            } catch (\Exception $e) {
                // Si falla la API externa, usar pedidos locales
                $orders = $website->orders()
                    ->with(['customer', 'items'])
                    ->latest()
                    ->get();
            }
        }

        // Si no hay API externa o falló, usar pedidos locales
        if (!$useExternalApi) {
            $orders = $website->orders()
                ->with(['customer', 'items'])
                ->latest()
                ->get();
        }

        return view('creator.store.orders', compact('orders', 'externalOrders', 'useExternalApi', 'pagination'));
    }
}
