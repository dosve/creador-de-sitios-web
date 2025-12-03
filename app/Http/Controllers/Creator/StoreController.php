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
            Log::info('StoreController: Iniciando consulta a API externa', [
                'website_id' => $website->id,
                'api_key_length' => strlen($website->api_key),
                'api_base_url' => $website->api_base_url
            ]);
            
            try {
                $apiService = new ExternalApiService($website->api_key, $website->api_base_url);

                // Obtener parámetros de paginación de la request
                $perPage = $request->get('per_page', 12);
                $page = $request->get('page', 1);

                Log::info('StoreController: Parámetros de consulta', [
                    'per_page' => $perPage,
                    'page' => $page,
                    'estado' => 1
                ]);

                $apiResponse = $apiService->getProducts([
                    'paginate' => $perPage,
                    'page' => $page,
                    'estado' => 1
                ]);

                Log::info('StoreController: Respuesta de API recibida', [
                    'response_is_null' => is_null($apiResponse),
                    'response_type' => gettype($apiResponse),
                    'has_success_key' => isset($apiResponse['success']),
                    'success_value' => $apiResponse['success'] ?? 'no_key',
                    'has_data_key' => isset($apiResponse['data']),
                    'data_count' => isset($apiResponse['data']) ? count($apiResponse['data']) : 'no_data_key'
                ]);

                if ($apiResponse && isset($apiResponse['success']) && $apiResponse['success']) {
                    $externalProducts = $apiResponse['data'];
                    $pagination = $apiResponse['pagination'] ?? null;

                    Log::info('StoreController: Procesando productos de API', [
                        'products_count' => count($externalProducts),
                        'has_pagination' => !is_null($pagination)
                    ]);

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
                    
                    Log::info('StoreController: API externa configurada como activa', [
                        'useExternalApi' => $useExternalApi,
                        'final_products_count' => count($externalProducts)
                    ]);
                } else {
                    Log::warning('StoreController: API no devolvió datos válidos', [
                        'apiResponse' => $apiResponse,
                        'success_key_exists' => isset($apiResponse['success']),
                        'success_value' => $apiResponse['success'] ?? 'no_key'
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('StoreController: Error al conectar con API externa', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Si falla la API externa, usar productos locales
                $products = $website->blogPosts()
                    ->where('is_product', true)
                    ->with(['category', 'tags'])
                    ->latest()
                    ->get();
            }
        } else {
            Log::info('StoreController: No hay configuración de API', [
                'has_api_key' => !empty($website->api_key),
                'has_api_url' => !empty($website->api_base_url)
            ]);
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

        return view('creator.store.products', compact('products', 'externalProducts', 'useExternalApi', 'pagination', 'website'));
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

        return view('creator.store.categories', compact('categories', 'externalCategories', 'useExternalApi', 'pagination', 'website'));
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
                    ->with(['customer', 'items.product'])
                    ->latest()
                    ->get();
            }
        }

        // Si no hay API externa o falló, usar pedidos locales
        if (!$useExternalApi) {
            $orders = $website->orders()
                ->with(['customer', 'items.product'])
                ->latest()
                ->get();
        } else {
            // Si usa API externa pero no hay pedidos, también cargar los locales
            if (empty($externalOrders)) {
                $orders = $website->orders()
                    ->with(['customer', 'items.product'])
                    ->latest()
                    ->get();
            }
        }

        return view('creator.store.orders', compact('orders', 'externalOrders', 'useExternalApi', 'pagination', 'website'));
    }

    public function getOrderDetails($orderId)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return response()->json(['error' => 'Sitio web no encontrado'], 404);
        }
        
        $this->authorize('view', $website);

        // Buscar la orden en la base de datos local
        $order = $website->orders()
            ->with(['customer', 'items.product'])
            ->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Orden no encontrada'], 404);
        }

        // Renderizar la vista parcial con los detalles
        $html = view('creator.store.partials.order-details', compact('order'))->render();
        
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return response()->json(['error' => 'Sitio web no encontrado'], 404);
        }
        
        $this->authorize('view', $website);

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid,failed,refunded',
        ]);

        // Buscar la orden en la base de datos local
        $order = $website->orders()->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Orden no encontrada'], 404);
        }

        // Actualizar el estado
        $order->status = $request->status;
        
        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status;
        }
        
        $order->save();

        return response()->json([
            'success' => true, 
            'message' => 'Estado actualizado correctamente',
            'order' => $order
        ]);
    }
}
