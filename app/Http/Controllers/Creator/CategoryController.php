<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $categories = $website->categories()->latest()->get();
        
        return view('creator.categories.index', compact('website', 'categories'));
    }

    public function create(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        return view('creator.categories.create', compact('website'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $website->categories()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('creator.categories.index', $website)
            ->with('success', 'Categoría creada exitosamente');
    }
}
