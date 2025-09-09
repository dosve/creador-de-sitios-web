<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\User;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with(['user', 'pages', 'blogPosts'])
            ->withCount(['pages', 'blogPosts'])
            ->latest()
            ->paginate(15);

        return view('admin.websites.index', compact('websites'));
    }

    public function create()
    {
        $users = User::where('role', 'creator')->get();
        $templates = \App\Models\Template::where('is_active', true)->get();

        return view('admin.websites.create', compact('users', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'user_id' => 'required|exists:users,id',
            'domain' => 'nullable|string|max:255|unique:websites,domain',
            'subdomain' => 'nullable|string|max:255|unique:websites,subdomain',
            'template_id' => 'nullable|exists:templates,id',
            'is_published' => 'boolean',
        ]);

        // Generar slug único
        $baseSlug = \Illuminate\Support\Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;

        while (Website::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $website = Website::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'domain' => $request->domain,
            'subdomain' => $request->subdomain,
            'template_id' => $request->template_id,
            'is_published' => $request->boolean('is_published'),
        ]);

        // Crear página inicial automáticamente
        $website->pages()->create([
            'title' => 'Inicio',
            'slug' => 'inicio',
            'html_content' => '<h1>Bienvenido a ' . $website->name . '</h1><p>Esta es tu página de inicio. Puedes editarla desde el panel de administración.</p>',
            'is_published' => $website->is_published,
        ]);

        return redirect()->route('admin.websites.index')
            ->with('success', 'Sitio web creado exitosamente');
    }

    public function show(Website $website)
    {
        $website->load(['user', 'pages', 'blogPosts', 'categories', 'tags']);

        return view('admin.websites.show', compact('website'));
    }

    public function edit(Website $website)
    {
        $users = User::where('role', 'creator')->get();
        $templates = \App\Models\Template::where('is_active', true)->get();
        return view('admin.websites.edit', compact('website', 'users', 'templates'));
    }

    public function update(Request $request, Website $website)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'user_id' => 'required|exists:users,id',
            'domain' => 'nullable|string|max:255|unique:websites,domain,' . $website->id,
            'subdomain' => 'nullable|string|max:255|unique:websites,subdomain,' . $website->id,
            'template_id' => 'nullable|exists:templates,id',
            'is_published' => 'boolean',
        ]);

        // Generar slug único si el nombre cambió
        $newSlug = $website->slug; // Mantener slug actual por defecto

        if ($website->name !== $request->name) {
            $baseSlug = \Illuminate\Support\Str::slug($request->name);
            $slug = $baseSlug;
            $counter = 1;

            while (Website::where('slug', $slug)->where('id', '!=', $website->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $newSlug = $slug;
        }

        $website->update([
            'name' => $request->name,
            'slug' => $newSlug,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'domain' => $request->domain,
            'subdomain' => $request->subdomain,
            'template_id' => $request->template_id,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.websites.index')
            ->with('success', 'Sitio web actualizado exitosamente');
    }

    public function destroy(Website $website)
    {
        $website->delete();

        return redirect()->route('admin.websites.index')
            ->with('success', 'Sitio web eliminado exitosamente');
    }

    public function toggleStatus(Website $website)
    {
        $website->update(['is_published' => !$website->is_published]);

        $status = $website->is_published ? 'publicado' : 'despublicado';
        return redirect()->route('admin.websites.index')
            ->with('success', "Sitio web {$status} exitosamente");
    }
}
