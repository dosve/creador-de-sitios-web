<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSubmission;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar lista de formularios
     */
    public function index(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('view', $website);
        
        $forms = $website->forms()
            ->withCount(['submissions as total_submissions', 'submissions as unread_submissions' => function($query) {
                $query->where('is_read', false);
            }])
            ->orderBy('sort_order')
            ->get();
        
        return view('creator.forms.index', compact('website', 'forms'));
    }

    /**
     * Mostrar formulario específico del blog
     */
    public function blogIndex(Request $request, BlogPost $blogPost)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('view', $website);
        
        // Verificar que el blog post pertenece al sitio web
        if ($blogPost->website_id !== $website->id) {
            abort(403);
        }
        
        $forms = $blogPost->forms()
            ->withCount(['submissions as total_submissions', 'submissions as unread_submissions' => function($query) {
                $query->where('is_read', false);
            }])
            ->orderBy('sort_order')
            ->get();
        
        return view('creator.forms.blog-index', compact('website', 'blogPost', 'forms'));
    }

    /**
     * Mostrar formulario para crear
     */
    public function create(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        $blogPostId = $request->get('blog_post_id');
        $blogPost = null;
        
        if ($blogPostId) {
            $blogPost = BlogPost::where('website_id', $website->id)
                ->where('id', $blogPostId)
                ->firstOrFail();
        }
        
        return view('creator.forms.create', compact('website', 'blogPost'));
    }

    /**
     * Almacenar nuevo formulario
     */
    public function store(Request $request)
    {
        $selectedWebsiteId = session('selected_website_id');
        $website = Website::findOrFail($selectedWebsiteId);
        
        $this->authorize('update', $website);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:contact,custom',
            'blog_post_id' => 'nullable|exists:blog_posts,id',
            'submit_button_text' => 'nullable|string|max:100',
            'success_message' => 'nullable|string|max:500',
            'error_message' => 'nullable|string|max:500',
            'email_to' => 'nullable|email',
            'email_subject' => 'nullable|string|max:255',
        ]);

        // Verificar que el blog post pertenece al sitio web si se especifica
        $blogPostId = $request->blog_post_id;
        if ($blogPostId) {
            $blogPost = BlogPost::where('website_id', $website->id)
                ->where('id', $blogPostId)
                ->firstOrFail();
        }

        // Generar slug único
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;

        while (Form::where('website_id', $website->id)
            ->where('slug', $slug)
            ->when($blogPostId, function($query) use ($blogPostId) {
                return $query->where('blog_post_id', $blogPostId);
            })
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $emailSettings = [
            'to' => $request->email_to,
            'subject' => $request->email_subject ?: 'Nuevo mensaje desde el formulario',
        ];

        $form = $website->forms()->create([
            'blog_post_id' => $blogPostId,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'type' => $request->type,
            'submit_button_text' => $request->submit_button_text ?: 'Enviar',
            'success_message' => $request->success_message ?: '¡Formulario enviado exitosamente!',
            'error_message' => $request->error_message ?: 'Hubo un error al enviar el formulario.',
            'email_settings' => $emailSettings,
            'sort_order' => $website->forms()->max('sort_order') + 1,
        ]);

        $redirectRoute = $blogPostId 
            ? route('creator.forms.blog-builder', [$website, $blogPost, $form])
            : route('creator.forms.builder', [$website, $form]);

        return redirect($redirectRoute)
            ->with('success', 'Formulario creado exitosamente. Ahora puedes agregar campos.');
    }

    /**
     * Mostrar formulario para editar
     */
    public function edit(Request $request, Website $website, Form $form)
    {
        $this->authorize('update', $website);
        
        // Verificar que el formulario pertenece al sitio web
        if ($form->website_id !== $website->id) {
            abort(403);
        }
        
        return view('creator.forms.edit', compact('website', 'form'));
    }

    /**
     * Mostrar constructor de formularios
     */
    public function builder(Request $request, Website $website, Form $form)
    {
        $this->authorize('view', $website);
        
        // Verificar que el formulario pertenece al sitio web
        if ($form->website_id !== $website->id) {
            abort(403);
        }
        
        $form->load('fields');
        
        return view('creator.forms.builder', compact('website', 'form'));
    }

    /**
     * Mostrar constructor de formularios para blog
     */
    public function blogBuilder(Request $request, Website $website, BlogPost $blogPost, Form $form)
    {
        $this->authorize('view', $website);
        
        // Verificar que el blog post y formulario pertenecen al sitio web
        if ($blogPost->website_id !== $website->id || $form->website_id !== $website->id) {
            abort(403);
        }
        
        // Verificar que el formulario pertenece al blog post
        if ($form->blog_post_id !== $blogPost->id) {
            abort(403);
        }
        
        $form->load('fields');
        
        return view('creator.forms.blog-builder', compact('website', 'blogPost', 'form'));
    }

    /**
     * Mostrar envíos del formulario
     */
    public function submissions(Request $request, Website $website, Form $form)
    {
        $this->authorize('view', $website);
        
        // Verificar que el formulario pertenece al sitio web
        if ($form->website_id !== $website->id) {
            abort(403);
        }
        
        $submissions = $form->submissions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('creator.forms.submissions', compact('website', 'form', 'submissions'));
    }

    /**
     * Mostrar envío específico
     */
    public function showSubmission(Request $request, Website $website, Form $form, FormSubmission $submission)
    {
        $this->authorize('view', $website);
        
        // Verificar que el formulario y envío pertenecen al sitio web
        if ($form->website_id !== $website->id || $submission->form_id !== $form->id) {
            abort(403);
        }
        
        // Marcar como leído
        if (!$submission->is_read) {
            $submission->markAsRead();
        }
        
        return view('creator.forms.show-submission', compact('website', 'form', 'submission'));
    }

    /**
     * Actualizar formulario
     */
    public function update(Request $request, Website $website, Form $form)
    {
        $this->authorize('update', $website);
        
        // Verificar que el formulario pertenece al sitio web
        if ($form->website_id !== $website->id) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:contact,custom',
            'submit_button_text' => 'nullable|string|max:100',
            'success_message' => 'nullable|string|max:500',
            'error_message' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'email_to' => 'nullable|email',
            'email_subject' => 'nullable|string|max:255',
        ]);

        $emailSettings = [
            'to' => $request->email_to,
            'subject' => $request->email_subject,
        ];

        $form->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'submit_button_text' => $request->submit_button_text,
            'success_message' => $request->success_message,
            'error_message' => $request->error_message,
            'is_active' => $request->boolean('is_active'),
            'email_settings' => $emailSettings,
        ]);

        return redirect()->back()
            ->with('success', 'Formulario actualizado exitosamente.');
    }

    /**
     * Eliminar formulario
     */
    public function destroy(Request $request, Website $website, Form $form)
    {
        $this->authorize('update', $website);
        
        // Verificar que el formulario pertenece al sitio web
        if ($form->website_id !== $website->id) {
            abort(403);
        }
        
        $form->delete();

        $redirectRoute = $form->blog_post_id 
            ? route('creator.forms.blog-index', [$website, $form->blogPost])
            : route('creator.forms.index', $website);

        return redirect($redirectRoute)
            ->with('success', 'Formulario eliminado exitosamente.');
    }
}