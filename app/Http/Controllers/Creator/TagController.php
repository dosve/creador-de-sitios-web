<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TagController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $tags = $website->tags()->latest()->get();
        
        return view('creator.tags.index', compact('website', 'tags'));
    }

    public function create(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        return view('creator.tags.create', compact('website'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $website->tags()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('creator.tags.index', $website)
            ->with('success', 'Etiqueta creada exitosamente');
    }
}
