<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectWebsiteController extends Controller
{
    public function index()
    {
        $websites = Auth::user()->websites()->latest()->get();
        
        if ($websites->count() == 0) {
            return redirect()->route('creator.websites.create');
        }
        
        return view('creator.select-website', compact('websites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_id' => 'required|exists:websites,id'
        ]);

        $website = Auth::user()->websites()->findOrFail($request->website_id);
        
        // Guardar el sitio web seleccionado en la sesión
        session(['selected_website_id' => $website->id]);
        
        return redirect()->route('creator.dashboard')
            ->with('success', "Ahora estás trabajando con: {$website->name}");
    }
}
