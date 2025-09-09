<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::active()
            ->with(['websites' => function($query) {
                $query->where('user_id', Auth::id());
            }])
            ->get()
            ->groupBy('category');

        $categories = [
            'business' => 'Negocios',
            'portfolio' => 'Portafolio',
            'blog' => 'Blog',
            'ecommerce' => 'E-commerce',
            'landing' => 'Landing Page',
            'corporate' => 'Corporativo',
        ];

        return view('creator.templates.index', compact('templates', 'categories'));
    }

    public function show(Template $template)
    {
        $template->load('websites');
        return view('creator.templates.show', compact('template'));
    }

    public function apply(Request $request, Website $website, Template $template)
    {
        $this->authorize('update', $website);

        // Verificar si el usuario puede usar plantillas premium
        if ($template->is_premium && !$this->canUsePremiumTemplates()) {
            return redirect()->back()
                ->with('error', 'Necesitas un plan premium para usar esta plantilla');
        }

        // Aplicar la plantilla a la página de inicio
        $homePage = $website->pages()->where('slug', 'inicio')->first();
        
        if ($homePage) {
            $homePage->update([
                'html_content' => $template->html_content,
                'css_content' => $template->css_content,
            ]);
        }

        // Actualizar el sitio web con la plantilla
        $website->update([
            'template_id' => $template->id,
        ]);

        return redirect()->route('creator.websites.show', $website)
            ->with('success', 'Plantilla aplicada exitosamente');
    }

    public function preview(Template $template)
    {
        return view('creator.templates.preview', compact('template'));
    }

    private function canUsePremiumTemplates()
    {
        $user = Auth::user();
        
        // Verificar si el usuario tiene un plan que permita plantillas premium
        if ($user->plan) {
            return $user->plan->name !== 'Plan Gratuito';
        }
        
        return false;
    }
}
