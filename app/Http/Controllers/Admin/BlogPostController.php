<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['user', 'category', 'image']);

        // Filtrage par catégorie
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filtrage par statut
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filtrage par date de publication
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('published_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('published_at', '<=', $request->date_to);
        }

        // Recherche par titre
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $blogPosts = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();

        return view('admin.blog.index', compact('blogPosts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->except('image');
        
        // Vérifier si un utilisateur est authentifié
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } else {
            // Rechercher un utilisateur admin par défaut
            $adminUser = \App\Models\User::where('role', \App\Enums\RoleEnum::ADMIN->value)->first();
            if ($adminUser) {
                $data['user_id'] = $adminUser->id;
            } else {
                // Créer un utilisateur admin si aucun n'existe
                $adminUser = \App\Models\User::create([
                    'firstName' => 'Admin',
                    'lastName' => 'System',
                    'email' => 'admin@elomtours.com',
                    'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                    'role' => \App\Enums\RoleEnum::ADMIN,
                ]);
                $data['user_id'] = $adminUser->id;
            }
        }
        
        $data['slug'] = Str::slug($request->title);

        // Vérifier si le slug existe déjà et le rendre unique si nécessaire
        $slug = $data['slug'];
        $count = 1;

        while (BlogPost::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $slug . '-' . $count++;
        }

        $blogPost = BlogPost::create($data);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('blog', $filename, 'public');

            File::create([
                'owner_id' => $blogPost->id,
                'owner_type' => BlogPost::class,
                'path' => $path,
                'name' => $filename,
                'filename' => $filename,
                'mime_type' => $image->getClientMimeType(),
                'size' => $image->getSize(),
            ]);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article de blog créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        $blogPost->load(['user', 'category', 'image', 'comments']);
        return view('admin.blog.show', compact('blogPost'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost)
    {
        $categories = Category::all();
        return view('admin.blog.edit', compact('blogPost', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['image', '_token', '_method']);

        // Mise à jour du slug uniquement si le titre a changé
        if ($blogPost->title !== $request->title) {
            $data['slug'] = Str::slug($request->title);
            
            // Vérifier si le slug existe déjà et le rendre unique si nécessaire
            $slug = $data['slug'];
            $count = 1;

            while (BlogPost::where('slug', $data['slug'])->where('id', '!=', $blogPost->id)->exists()) {
                $data['slug'] = $slug . '-' . $count++;
            }
        }

        $blogPost->update($data);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($blogPost->image) {
                Storage::disk('public')->delete($blogPost->image->path);
                $blogPost->image->delete();
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('blog', $filename, 'public');

            File::create([
                'owner_id' => $blogPost->id,
                'owner_type' => BlogPost::class,
                'path' => $path,
                'name' => $filename,
                'filename' => $filename,
                'mime_type' => $image->getClientMimeType(),
                'size' => $image->getSize(),
            ]);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article de blog mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        // Supprimer l'image associée si elle existe
        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image->path);
            $blogPost->image->delete();
        }

        // Supprimer les commentaires associés
        $blogPost->comments()->delete();

        // Supprimer l'article de blog
        $blogPost->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Article de blog supprimé avec succès.');
    }

    /**
     * Toggle the active status of the specified resource.
     */
    public function toggleActive(BlogPost $blogPost)
    {
        $blogPost->is_active = !$blogPost->is_active;
        $blogPost->save();

        $status = $blogPost->is_active ? 'activé' : 'désactivé';

        return redirect()->route('admin.blog.index')
            ->with('success', "L'article de blog a été {$status} avec succès.");
    }

    /**
     * Toggle the featured status of the specified resource.
     */
    public function toggleFeatured(BlogPost $blogPost)
    {
        $blogPost->is_featured = !$blogPost->is_featured;
        $blogPost->save();

        $status = $blogPost->is_featured ? 'mis en avant' : 'retiré de la mise en avant';

        return redirect()->route('admin.blog.index')
            ->with('success', "L'article de blog a été {$status} avec succès.");
    }
}