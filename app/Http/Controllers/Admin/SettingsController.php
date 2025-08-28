<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Affiche la page des paramètres
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Dans une application réelle, ces données seraient chargées depuis la base de données
        // ou un fichier de configuration
        
        // Pour l'instant, nous utilisons des données statiques pour la démonstration
        $settings = [
            'general' => [
                'site_name' => 'The Elom Tours',
                'site_url' => 'https://www.elomtours.com',
                'admin_email' => 'admin@elomtours.com',
                'timezone' => 'Europe/Paris',
                'date_format' => 'd/m/Y',
                'currency' => 'EUR',
                'maintenance_mode' => false,
            ],
            'company' => [
                'name' => 'The Elom Tours SARL',
                'address' => '123 Avenue de la Liberté',
                'city' => 'Lomé',
                'country' => 'Togo',
                'phone' => '+228 90 12 34 56',
                'email' => 'contact@elomtours.com',
                'description' => 'The Elom Tours est une agence de voyages spécialisée dans les circuits touristiques au Togo et en Afrique de l\'Ouest. Nous proposons des expériences authentiques et inoubliables depuis 2010.',
                'logo' => '/assets/images/logo.png',
                'favicon' => '/assets/images/favicon.ico',
            ],
            'seo' => [
                'meta_title' => 'The Elom Tours - Découvrez le Togo authentique',
                'meta_description' => 'The Elom Tours vous propose des circuits touristiques authentiques au Togo et en Afrique de l\'Ouest. Découvrez des paysages magnifiques, une culture riche et des expériences inoubliables.',
                'meta_keywords' => 'tourisme, Togo, Afrique de l\'Ouest, circuit, voyage, safari, Kpalimé, Lomé',
                'google_analytics' => 'UA-XXXXXXXXX-X',
                'robots_txt' => "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /private/\n\nSitemap: https://www.elomtours.com/sitemap.xml",
                'sitemap_last_generated' => '15/06/2023 à 10:30',
            ],
            'social' => [
                'facebook_url' => 'https://www.facebook.com/elomtours',
                'instagram_url' => 'https://www.instagram.com/elomtours',
                'twitter_url' => 'https://www.twitter.com/elomtours',
                'youtube_url' => 'https://www.youtube.com/elomtours',
                'linkedin_url' => 'https://www.linkedin.com/company/elomtours',
                'pinterest_url' => '',
                'og_title' => 'The Elom Tours - Voyages authentiques au Togo',
                'og_description' => 'Découvrez nos circuits touristiques au Togo et vivez une expérience inoubliable avec The Elom Tours.',
                'og_image' => '/assets/images/og-image.jpg',
            ],
            'email' => [
                'driver' => 'smtp',
                'host' => 'smtp.mailtrap.io',
                'port' => '2525',
                'encryption' => 'tls',
                'username' => '123456789',
                'password' => '********',
                'from_address' => 'noreply@elomtours.com',
                'from_name' => 'The Elom Tours',
            ],
            'api' => [
                'key' => 'elom_api_12345678901234567890',
                'secret' => 'elom_secret_12345678901234567890',
                'rate_limit' => 60,
                'permissions' => ['read', 'write'],
                'resources' => ['circuits', 'reservations', 'clients', 'blog'],
            ],
        ];
        
        return view('admin.settings.index', compact('settings'));
    }
    
    /**
     * Met à jour les paramètres généraux
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateGeneral(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_url' => 'required|url|max:255',
            'admin_email' => 'required|email|max:255',
            'timezone' => 'required|string|max:255',
            'date_format' => 'required|string|max:20',
            'currency' => 'required|string|max:10',
            'maintenance_mode' => 'boolean',
        ]);
        
        // Dans une application réelle, nous sauvegarderions ces données
        // dans la base de données ou un fichier de configuration
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Les paramètres généraux ont été mis à jour avec succès.');
    }
    
    /**
     * Met à jour les paramètres de l'entreprise
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCompany(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_city' => 'required|string|max:100',
            'company_country' => 'required|string|max:100',
            'company_phone' => 'required|string|max:20',
            'company_email' => 'required|email|max:255',
            'company_description' => 'required|string|max:1000',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);
        
        // Traitement des fichiers uploadés
        if ($request->hasFile('company_logo')) {
            // Sauvegarde du logo
            $logoPath = $request->file('company_logo')->store('public/assets/images');
            // Dans une application réelle, nous sauvegarderions ce chemin
        }
        
        if ($request->hasFile('company_favicon')) {
            // Sauvegarde du favicon
            $faviconPath = $request->file('company_favicon')->store('public/assets/images');
            // Dans une application réelle, nous sauvegarderions ce chemin
        }
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Les paramètres de l\'entreprise ont été mis à jour avec succès.');
    }
    
    /**
     * Met à jour les paramètres SEO
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSeo(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'google_analytics' => 'nullable|string|max:20',
            'robots_txt' => 'nullable|string|max:2000',
        ]);
        
        // Dans une application réelle, nous sauvegarderions ces données
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Les paramètres SEO ont été mis à jour avec succès.');
    }
    
    /**
     * Génère le sitemap du site
     *
     * @return \Illuminate\Http\Response
     */
    public function generateSitemap()
    {
        // Dans une application réelle, nous générerions le sitemap ici
        // et le sauvegarderions dans le dossier public
        
        // Simuler un délai pour la génération
        sleep(1);
        
        return response()->json([
            'success' => true,
            'message' => 'Le sitemap a été généré avec succès.',
            'timestamp' => now()->format('d/m/Y à H:i'),
        ]);
    }
    
    /**
     * Met à jour les paramètres des réseaux sociaux
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSocial(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'pinterest_url' => 'nullable|url|max:255',
            'og_title' => 'required|string|max:60',
            'og_description' => 'required|string|max:160',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Traitement de l'image Open Graph
        if ($request->hasFile('og_image')) {
            // Sauvegarde de l'image
            $imagePath = $request->file('og_image')->store('public/assets/images');
            // Dans une application réelle, nous sauvegarderions ce chemin
        }
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Les paramètres des réseaux sociaux ont été mis à jour avec succès.');
    }
    
    /**
     * Met à jour les paramètres d'email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateEmail(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'mail_driver' => 'required|string|max:20',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|string|max:10',
            'mail_encryption' => 'nullable|string|max:10',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string|max:255',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);
        
        // Dans une application réelle, nous sauvegarderions ces données
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Les paramètres d\'email ont été mis à jour avec succès.');
    }
    
    /**
     * Envoie un email de test
     *
     * @return \Illuminate\Http\Response
     */
    public function sendTestEmail()
    {
        // Dans une application réelle, nous enverrions un email de test ici
        
        // Simuler un délai pour l'envoi
        sleep(1);
        
        return response()->json([
            'success' => true,
            'message' => 'L\'email de test a été envoyé avec succès.',
        ]);
    }
    
    /**
     * Met à jour les paramètres de l'API
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateApi(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'api_key' => 'required|string|max:255',
            'api_secret' => 'required|string|max:255',
            'api_rate_limit' => 'required|integer|min:1|max:1000',
            'api_permissions' => 'required|array',
            'api_resources' => 'required|array',
        ]);
        
        // Dans une application réelle, nous sauvegarderions ces données
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Les paramètres de l\'API ont été mis à jour avec succès.');
    }
    
    /**
     * Génère une nouvelle clé API
     *
     * @return \Illuminate\Http\Response
     */
    public function generateApiKey()
    {
        // Dans une application réelle, nous générerions une nouvelle clé API ici
        $newApiKey = 'elom_api_' . bin2hex(random_bytes(10));
        
        return response()->json([
            'success' => true,
            'api_key' => $newApiKey,
        ]);
    }
    
    /**
     * Génère un nouveau secret API
     *
     * @return \Illuminate\Http\Response
     */
    public function generateApiSecret()
    {
        // Dans une application réelle, nous générerions un nouveau secret API ici
        $newApiSecret = 'elom_secret_' . bin2hex(random_bytes(10));
        
        return response()->json([
            'success' => true,
            'api_secret' => $newApiSecret,
        ]);
    }
}