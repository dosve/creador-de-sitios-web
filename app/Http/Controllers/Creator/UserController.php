<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Lista de usuarios (clientes)
     */
    public function index(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $customers = $website->customers()
            ->withCount('orders')
            ->latest()
            ->get();
        
        return view('creator.users.index', compact('website', 'customers'));
    }
}
