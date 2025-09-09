<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::withCount('users')
            ->orderBy('price', 'asc')
            ->paginate(20);
        
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'max_websites' => 'required|integer|min:1',
            'max_pages' => 'required|integer|min:1',
            'custom_domain' => 'boolean',
            'ecommerce' => 'boolean',
            'seo_tools' => 'boolean',
            'analytics' => 'boolean',
            'is_active' => 'boolean',
        ]);

        Plan::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'max_websites' => $request->max_websites,
            'max_pages' => $request->max_pages,
            'custom_domain' => $request->boolean('custom_domain'),
            'ecommerce' => $request->boolean('ecommerce'),
            'seo_tools' => $request->boolean('seo_tools'),
            'analytics' => $request->boolean('analytics'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan creado exitosamente');
    }

    public function show(Plan $plan)
    {
        $plan->load('users');
        return view('admin.plans.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly',
            'max_websites' => 'required|integer|min:1',
            'max_pages' => 'required|integer|min:1',
            'custom_domain' => 'boolean',
            'ecommerce' => 'boolean',
            'seo_tools' => 'boolean',
            'analytics' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $plan->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'max_websites' => $request->max_websites,
            'max_pages' => $request->max_pages,
            'custom_domain' => $request->boolean('custom_domain'),
            'ecommerce' => $request->boolean('ecommerce'),
            'seo_tools' => $request->boolean('seo_tools'),
            'analytics' => $request->boolean('analytics'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan actualizado exitosamente');
    }

    public function destroy(Plan $plan)
    {
        // Verificar si tiene usuarios asociados
        if ($plan->users()->count() > 0) {
            return redirect()->route('admin.plans.index')
                ->with('error', 'No se puede eliminar el plan porque tiene usuarios asociados');
        }

        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan eliminado exitosamente');
    }

    public function toggleStatus(Plan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);
        
        $status = $plan->is_active ? 'activado' : 'desactivado';
        return redirect()->route('admin.plans.index')
            ->with('success', "Plan {$status} exitosamente");
    }
}