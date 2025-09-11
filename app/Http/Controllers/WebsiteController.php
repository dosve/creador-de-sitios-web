<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\Page;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WebsiteController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        return redirect()->route('creator.select-website');
    }

    public function create()
    {
        // Verificar si el usuario ya tiene un sitio web (solo para usuarios no admin)
        if (!Auth::user()->isAdmin()) {
            $existingWebsite = Auth::user()->websites()->first();
            if ($existingWebsite) {
                return redirect()->route('creator.select-website')
                    ->with('error', 'Solo puedes crear un sitio web. Ya tienes un sitio web creado.');
            }
        }

        $templates = Template::active()->get();
        return view('creator.websites.create', compact('templates'));
    }

    public function store(Request $request)
    {
        // Verificar si el usuario ya tiene un sitio web (solo para usuarios no admin)
        if (!Auth::user()->isAdmin()) {
            $existingWebsite = Auth::user()->websites()->first();
            if ($existingWebsite) {
                return redirect()->route('creator.select-website')
                    ->with('error', 'Solo puedes crear un sitio web. Ya tienes un sitio web creado.');
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'template_type' => 'required|in:blank,template',
            'template_id' => 'nullable|exists:templates,id',
        ]);

        // Determinar qué plantilla usar basado en la selección del usuario
        $templateId = null;
        if ($request->template_type === 'template') {
            $templateId = $request->template_id;
            if (!$templateId) {
                // Si seleccionó usar plantilla pero no eligió una específica, usar la primera disponible
                $defaultTemplate = Template::active()->first();
                $templateId = $defaultTemplate ? $defaultTemplate->id : null;
            }
        }
        // Si template_type es 'blank', templateId permanece null

        // Generar slug único
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;

        while (Website::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $website = Auth::user()->websites()->create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug,
            'template_id' => $templateId,
            'is_published' => false,
        ]);

        // Crear página de inicio automáticamente
        $website->pages()->create([
            'title' => 'Inicio',
            'slug' => 'inicio',
            'html_content' => '<h1>Bienvenido a ' . $website->name . '</h1><p>Esta es tu página de inicio. ¡Comienza a editarla!</p>',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        return redirect()->route('creator.websites.show', $website)
            ->with('success', 'Sitio web creado exitosamente');
    }

    public function show(Website $website)
    {
        $this->authorize('view', $website);
        $pages = $website->pages()->orderBy('sort_order')->get();
        return view('creator.websites.show', compact('website', 'pages'));
    }

    public function edit(Website $website)
    {
        $this->authorize('update', $website);
        return view('creator.websites.edit', compact('website'));
    }

    public function update(Request $request, Website $website)
    {
        $this->authorize('update', $website);

        $newSlug = Str::slug($request->name);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Verificar si el slug ya existe para otro sitio web
        if ($newSlug !== $website->slug) {
            $existingWebsite = Website::where('slug', $newSlug)
                ->where('id', '!=', $website->id)
                ->first();

            if ($existingWebsite) {
                // Si el slug ya existe, agregar un número al final
                $counter = 1;
                $originalSlug = $newSlug;
                do {
                    $newSlug = $originalSlug . '-' . $counter;
                    $counter++;
                } while (Website::where('slug', $newSlug)
                    ->where('id', '!=', $website->id)
                    ->exists()
                );
            }
        }

        $website->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $newSlug,
        ]);

        return redirect()->route('creator.websites.show', $website)
            ->with('success', 'Sitio web actualizado exitosamente');
    }

    public function destroy(Website $website)
    {
        $this->authorize('delete', $website);
        $website->delete();

        return redirect()->route('creator.select-website')
            ->with('success', 'Sitio web eliminado exitosamente');
    }
}
