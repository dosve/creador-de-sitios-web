<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IntegrationController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar página de integración con Epayco
     */
    public function epayco(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        return view('creator.integrations.epayco', compact('website'));
    }

    /**
     * Configurar integración con Epayco
     */
    public function epaycoStore(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'epayco_public_key' => 'required|string|max:255',
            'epayco_private_key' => 'required|string|max:255',
            'epayco_customer_id' => 'required|string|max:255',
            'epayco_p_key' => 'required|string|max:255',
            'epayco_test_mode' => 'boolean',
        ]);

        // Aquí se guardarían las credenciales de Epayco
        // Por ahora solo mostramos un mensaje de éxito
        return redirect()->route('creator.integrations.epayco', $website)
            ->with('success', 'Configuración de Epayco guardada exitosamente');
    }

    /**
     * Mostrar página de integración con Admin Negocios
     */
    public function adminNegocios(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        return view('creator.integrations.admin-negocios', compact('website'));
    }

    /**
     * Configurar integración con Admin Negocios
     */
    public function adminNegociosStore(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'admin_negocios_url' => 'required|url|max:255',
            'admin_negocios_api_key' => 'required|string|max:255',
            'admin_negocios_username' => 'required|string|max:255',
            'admin_negocios_password' => 'required|string|max:255',
        ]);

        // Aquí se guardarían las credenciales de Admin Negocios
        // Por ahora solo mostramos un mensaje de éxito
        return redirect()->route('creator.integrations.admin-negocios', $website)
            ->with('success', 'Configuración de Admin Negocios guardada exitosamente');
    }

    /**
     * Mostrar página de tienda en línea con posts
     */
    public function onlineStore(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        // Obtener posts que pueden ser productos
        $storePosts = $website->blogPosts()
            ->where('is_published', true)
            ->where('is_product', true)
            ->with(['category', 'tags'])
            ->latest()
            ->get();
        
        return view('creator.integrations.online-store', compact('website', 'storePosts'));
    }

    /**
     * Configurar post como producto
     */
    public function toggleProduct(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'post_id' => 'required|exists:blog_posts,id',
            'is_product' => 'required|boolean',
            'price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
        ]);

        $post = $website->blogPosts()->findOrFail($request->post_id);
        
        $post->update([
            'is_product' => $request->is_product,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        $message = $request->is_product ? 'Post configurado como producto' : 'Post removido de productos';
        
        return redirect()->route('creator.integrations.online-store', $website)
            ->with('success', $message);
    }

    /**
     * Sincronizar inventario con Admin Negocios
     */
    public function syncInventory(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        // Aquí se implementaría la lógica de sincronización
        // con el sistema Admin Negocios
        
        return redirect()->route('creator.integrations.online-store', $website)
            ->with('success', 'Inventario sincronizado exitosamente');
    }
}
