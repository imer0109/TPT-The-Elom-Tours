<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Affiche le formulaire de contact
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Récupérer les informations de contact depuis les paramètres
        $contactInfo = [
            'address' => Setting::getValue('contact_address', '123 Rue Principale, Lomé, Togo'),
            'email' => Setting::getValue('contact_email', 'contact@theelemtours.com'),
            'phone' => Setting::getValue('contact_phone', '+228 90 12 34 56'),
            'hours' => Setting::getValue('contact_hours', 'Lun-Ven: 9h-18h | Sam: 9h-13h')
        ];
        
        return view('contact.index', compact('contactInfo'));
    }

    /**
     * Traite l'envoi du formulaire de contact
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'required',
        ]);

        // Enregistrer le message dans la base de données
        $message = new Message([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'is_read' => false,
            'is_archived' => false,
        ]);
        
        $message->save();
        
        // Envoyer un email de notification si configuré
        // if (Setting::getValue('send_contact_notifications', true)) {
        //     $adminEmail = Setting::getValue('admin_email', 'contact@theelemtours.com');
        //     Mail::to($adminEmail)->send(new ContactFormMail($message));
        // }
        
        // Redirection avec message de succès
        return redirect()->route('contact.index')
            ->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}