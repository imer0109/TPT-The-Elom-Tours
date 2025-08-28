<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Affiche la liste des articles de blog
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Récupérer les articles publiés et actifs
        $posts = BlogPost::published()
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        // Récupérer les catégories pour le filtre
        $categories = Category::active()->get();
        
        // Récupérer les articles en vedette
        $featuredPosts = BlogPost::published()
            ->where('is_featured', true)
            ->take(3)
            ->get();
        
        return view('blog.index', compact('posts', 'categories', 'featuredPosts'));
    }

    /**
     * Affiche un article spécifique
     *
     * @param string $slug Le slug de l'article
     * @return \Illuminate\View\View
     */
    public function show(string $slug): View
    {
        // Récupérer l'article avec ses relations
        $post = BlogPost::where('slug', $slug)
            ->published()
            ->with(['category', 'user', 'comments' => function($query) {
                $query->approved()->parents()->with('replies');
            }])
            ->firstOrFail();
            
        // Incrémenter le compteur de vues (à implémenter si nécessaire)
        
        // Récupérer les articles similaires
        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->take(3)
            ->get();
        
        return view('blog.show', compact('post', 'relatedPosts'));
    }
    
    /**
     * Soumet un commentaire sur un article
     *
     * @param Request $request
     * @param string $slug Le slug de l'article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitComment(Request $request, string $slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|min:10',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $comment = new Comment([
            'blog_post_id' => $post->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'is_approved' => false, // Nécessite une approbation par l'admin
        ]);
        
        $comment->save();
        
        return redirect()->back()->with('success', 'Merci pour votre commentaire ! Il sera publié après modération.');
    }
}