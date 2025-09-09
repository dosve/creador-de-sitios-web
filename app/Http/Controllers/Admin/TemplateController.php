<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->paginate(15);
        
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        $categories = [
            'business' => 'Negocios',
            'portfolio' => 'Portafolio',
            'blog' => 'Blog',
            'ecommerce' => 'E-commerce',
            'landing' => 'Landing Page',
            'corporate' => 'Corporativo',
        ];
        
        return view('admin.templates.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:255',
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
        ]);

        Template::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'blocks' => $request->blocks ? json_decode($request->blocks, true) : [],
            'is_premium' => $request->boolean('is_premium'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Plantilla creada exitosamente');
    }

    public function show(Template $template)
    {
        return view('admin.templates.show', compact('template'));
    }

    public function edit(Template $template)
    {
        $categories = [
            'business' => 'Negocios',
            'portfolio' => 'Portafolio',
            'blog' => 'Blog',
            'ecommerce' => 'E-commerce',
            'landing' => 'Landing Page',
            'corporate' => 'Corporativo',
        ];
        
        return view('admin.templates.edit', compact('template', 'categories'));
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:255',
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'is_premium' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $template->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'html_content' => $request->html_content,
            'css_content' => $request->css_content,
            'blocks' => $request->blocks ? json_decode($request->blocks, true) : [],
            'is_premium' => $request->boolean('is_premium'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Plantilla actualizada exitosamente');
    }

    public function destroy(Template $template)
    {
        // Verificar si tiene sitios web asociados
        if ($template->websites()->count() > 0) {
            return redirect()->route('admin.templates.index')
                ->with('error', 'No se puede eliminar la plantilla porque tiene sitios web asociados');
        }

        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Plantilla eliminada exitosamente');
    }

    public function toggleStatus(Template $template)
    {
        $template->update(['is_active' => !$template->is_active]);
        
        $status = $template->is_active ? 'activada' : 'desactivada';
        return redirect()->route('admin.templates.index')
            ->with('success', "Plantilla {$status} exitosamente");
    }
}
