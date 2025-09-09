<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Affiche la liste des commentaires avec filtres.
     */
    public function index(Request $request): View
    {
        $query = Comment::with('blogPost')->latest();

        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        if ($request->filled('search')) {
            $search = '%'.$request->search.'%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('email', 'like', $search)
                  ->orWhere('comment', 'like', $search);
            });
        }

        $comments = $query->paginate(12)->withQueryString();

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Approuve ou désapprouve un commentaire.
     */
    public function toggleApproval(Comment $comment, bool $approve = true)
    {
        $comment->update(['is_approved' => $approve]);
        $status = $approve ? 'approuvé' : 'mis en attente';
        return redirect()->route('admin.comments.index')->with('success', "Commentaire {$status} avec succès.");
    }

    /**
     * Supprime un commentaire.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Commentaire supprimé avec succès.');
    }
}


