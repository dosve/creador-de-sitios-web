<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\Comment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Mostrar lista de comentarios
     */
    public function index(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);

        $query = $website->comments()->with(['blogPost', 'parent']);

        // Filtros
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'approved':
                    $query->approved();
                    break;
                case 'pending':
                    $query->pending();
                    break;
                case 'spam':
                    $query->spam();
                    break;
            }
        }

        if ($request->filled('blog_post_id')) {
            $query->where('blog_post_id', $request->blog_post_id);
        }

        $comments = $query->latest()->paginate(20);

        // Obtener posts del blog para el filtro
        $blogPosts = $website->blogPosts()->where('is_published', true)->get();

        return view('creator.comments.index', compact('comments', 'blogPosts'));
    }

    /**
     * Mostrar comentario específico
     */
    public function show(Request $request, Comment $comment)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);

        // Verificar que el comentario pertenece al sitio web
        if ($comment->website_id !== $website->id) {
            abort(403);
        }

        $comment->load(['blogPost', 'parent', 'replies']);

        // TODO: Crear vista creator.comments.show
        return view('creator.comments.show', compact('comment'));
    }

    /**
     * Aprobar comentario
     */
    public function approve(Request $request, Comment $comment)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        // Verificar que el comentario pertenece al sitio web
        if ($comment->website_id !== $website->id) {
            abort(403);
        }

        $comment->approve();

        return redirect()->back()
            ->with('success', 'Comentario aprobado exitosamente.');
    }

    /**
     * Desaprobar comentario
     */
    public function unapprove(Request $request, Comment $comment)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        // Verificar que el comentario pertenece al sitio web
        if ($comment->website_id !== $website->id) {
            abort(403);
        }

        $comment->unapprove();

        return redirect()->back()
            ->with('success', 'Comentario desaprobado exitosamente.');
    }

    /**
     * Marcar como spam
     */
    public function markAsSpam(Request $request, Comment $comment)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        // Verificar que el comentario pertenece al sitio web
        if ($comment->website_id !== $website->id) {
            abort(403);
        }

        $comment->markAsSpam();

        return redirect()->back()
            ->with('success', 'Comentario marcado como spam.');
    }

    /**
     * Marcar como no spam
     */
    public function markAsNotSpam(Request $request, Comment $comment)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        // Verificar que el comentario pertenece al sitio web
        if ($comment->website_id !== $website->id) {
            abort(403);
        }

        $comment->markAsNotSpam();

        return redirect()->back()
            ->with('success', 'Comentario marcado como no spam.');
    }

    /**
     * Eliminar comentario
     */
    public function destroy(Request $request, Comment $comment)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        // Verificar que el comentario pertenece al sitio web
        if ($comment->website_id !== $website->id) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()
            ->with('success', 'Comentario eliminado exitosamente.');
    }

    /**
     * Aprobar múltiples comentarios
     */
    public function bulkApprove(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id'
        ]);

        $comments = $website->comments()->whereIn('id', $request->comment_ids)->get();

        foreach ($comments as $comment) {
            $comment->approve();
        }

        return redirect()->back()
            ->with('success', count($comments) . ' comentarios aprobados exitosamente.');
    }

    /**
     * Eliminar múltiples comentarios
     */
    public function bulkDelete(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);

        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id'
        ]);

        $comments = $website->comments()->whereIn('id', $request->comment_ids)->get();

        foreach ($comments as $comment) {
            $comment->delete();
        }

        return redirect()->back()
            ->with('success', count($comments) . ' comentarios eliminados exitosamente.');
    }
}
