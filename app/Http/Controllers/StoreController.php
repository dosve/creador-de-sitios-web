<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreController extends Controller
{
    use AuthorizesRequests;


    /**
     * Lista de productos
     */
    public function products(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $products = $website->blogPosts()
            ->where('is_product', true)
            ->with(['category', 'tags'])
            ->latest()
            ->get();
        
        return view('creator.store.products', compact('website', 'products'));
    }

    /**
     * Categorías de productos
     */
    public function categories(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $categories = $website->categories()
            ->withCount('blogPosts')
            ->latest()
            ->get();
        
        return view('creator.store.categories', compact('website', 'categories'));
    }

    /**
     * Lista de pedidos
     */
    public function orders(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $orders = $website->orders()
            ->with(['customer', 'items'])
            ->latest()
            ->get();
        
        return view('creator.store.orders', compact('website', 'orders'));
    }


}
