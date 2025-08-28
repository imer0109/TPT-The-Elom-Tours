<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class MessageController extends Controller
{
    /**
     * Affiche la liste des messages
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Message::query();
        
        // Filtrage par statut
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'unread':
                    $query->where('is_read', false);
                    break;
                case 'read':
                    $query->where('is_read', true);
                    break;
                case 'archived':
                    $query->where('is_archived', true);
                    break;
                default:
                    break;
            }
        } else {
            // Par défaut, afficher les messages non archivés
            $query->where('is_archived', false);
        }
        
        // Filtrage par date
        if ($request->filled('date')) {
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $query->whereDate('created_at', $date);
        }
        
        // Recherche par expéditeur ou sujet
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        // Tri par date de création (plus récent d'abord)
        $query->orderBy('created_at', 'desc');
        
        $messages = $query->paginate(10);
        
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Affiche les détails d'un message
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        // Marquer le message comme lu s'il ne l'est pas déjà
        if (!$message->is_read) {
            $message->is_read = true;
            $message->save();
        }
        
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Marque un message comme lu ou non lu
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function toggleRead(Message $message)
    {
        $message->is_read = !$message->is_read;
        $message->save();
        
        return redirect()->back()->with('success', 'Statut du message mis à jour avec succès.');
    }

    /**
     * Marque un message comme archivé ou non archivé
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function toggleArchived(Message $message)
    {
        $message->is_archived = !$message->is_archived;
        $message->save();
        
        return redirect()->back()->with('success', 'Message ' . ($message->is_archived ? 'archivé' : 'désarchivé') . ' avec succès.');
    }

    /**
     * Répond à un message
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, Message $message)
    {
        $request->validate([
            'reply_content' => 'required|string',
        ]);
        
        // Logique pour envoyer l'email de réponse
        // Mail::to($message->email)->send(new ReplyMail($message, $request->reply_content));
        
        // Marquer le message comme lu
        $message->is_read = true;
        $message->save();
        
        return redirect()->route('admin.messages.show', $message)->with('success', 'Réponse envoyée avec succès.');
    }

    /**
     * Supprime un message
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        
        return redirect()->route('admin.messages.index')->with('success', 'Message supprimé avec succès.');
    }

    /**
     * Action groupée sur plusieurs messages
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:mark_read,mark_unread,archive,unarchive,delete',
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:messages,id',
        ]);
        
        $messageIds = $request->message_ids;
        $action = $request->action;
        
        switch ($action) {
            case 'mark_read':
                Message::whereIn('id', $messageIds)->update(['is_read' => true]);
                $message = 'Messages marqués comme lus avec succès.';
                break;
            case 'mark_unread':
                Message::whereIn('id', $messageIds)->update(['is_read' => false]);
                $message = 'Messages marqués comme non lus avec succès.';
                break;
            case 'archive':
                Message::whereIn('id', $messageIds)->update(['is_archived' => true]);
                $message = 'Messages archivés avec succès.';
                break;
            case 'unarchive':
                Message::whereIn('id', $messageIds)->update(['is_archived' => false]);
                $message = 'Messages désarchivés avec succès.';
                break;
            case 'delete':
                Message::whereIn('id', $messageIds)->delete();
                $message = 'Messages supprimés avec succès.';
                break;
            default:
                $message = 'Action non reconnue.';
                break;
        }
        
        return redirect()->route('admin.messages.index')->with('success', $message);
    }
}