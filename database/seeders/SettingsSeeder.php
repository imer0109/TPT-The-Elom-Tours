<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Paramètres généraux
        $generalSettings = [
            'site_name' => 'The Elom Tours',
            'site_url' => 'https://www.elomtours.com',
            'admin_email' => 'admin@elomtours.com',
            'timezone' => 'Europe/Paris',
            'date_format' => 'd/m/Y',
            'currency' => 'EUR',
            'maintenance_mode' => false,
        ];
        
        foreach ($generalSettings as $key => $value) {
            Setting::setValue($key, $value, 'general');
        }
        
        // Paramètres de l'entreprise
        $companySettings = [
            'name' => 'The Elom Tours SARL',
            'address' => '123 Avenue de la Liberté',
            'city' => 'Lomé',
            'country' => 'Togo',
            'phone' => '+228 90 12 34 56',
            'email' => 'contact@elomtours.com',
            'description' => 'The Elom Tours est une agence de voyages spécialisée dans les circuits touristiques au Togo et en Afrique de l\'Ouest. Nous proposons des expériences authentiques et inoubliables depuis 2010.',
            'logo' => '/assets/images/logo.png',
            'favicon' => '/assets/images/favicon.ico',
        ];
        
        foreach ($companySettings as $key => $value) {
            Setting::setValue($key, $value, 'company');
        }
        
        // Paramètres SEO
        $seoSettings = [
            'meta_title' => 'The Elom Tours - Découvrez le Togo authentique',
            'meta_description' => 'The Elom Tours vous propose des circuits touristiques authentiques au Togo et en Afrique de l\'Ouest. Découvrez des paysages magnifiques, une culture riche et des expériences inoubliables.',
            'meta_keywords' => 'tourisme, Togo, Afrique de l\'Ouest, circuit, voyage, safari, Kpalimé, Lomé',
            'google_analytics' => 'UA-XXXXXXXXX-X',
            'robots_txt' => "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /private/\n\nSitemap: https://www.elomtours.com/sitemap.xml",
            'sitemap_last_generated' => '15/06/2023 à 10:30',
        ];
        
        foreach ($seoSettings as $key => $value) {
            Setting::setValue($key, $value, 'seo');
        }
        
        // Paramètres des réseaux sociaux
        $socialSettings = [
            'facebook_url' => 'https://www.facebook.com/elomtours',
            'instagram_url' => 'https://www.instagram.com/elomtours',
            'twitter_url' => 'https://www.twitter.com/elomtours',
            'youtube_url' => 'https://www.youtube.com/elomtours',
            'linkedin_url' => 'https://www.linkedin.com/company/elomtours',
            'pinterest_url' => '',
            'og_title' => 'The Elom Tours - Voyages authentiques au Togo',
            'og_description' => 'Découvrez nos circuits touristiques au Togo et vivez une expérience inoubliable avec The Elom Tours.',
            'og_image' => '/assets/images/og-image.jpg',
        ];
        
        foreach ($socialSettings as $key => $value) {
            Setting::setValue($key, $value, 'social');
        }
        
        // Paramètres d'email
        $emailSettings = [
            'driver' => 'smtp',
            'host' => 'smtp.mailtrap.io',
            'port' => '2525',
            'encryption' => 'tls',
            'username' => '123456789',
            'password' => '********',
            'from_address' => 'noreply@elomtours.com',
            'from_name' => 'The Elom Tours',
        ];
        
        foreach ($emailSettings as $key => $value) {
            Setting::setValue($key, $value, 'email');
        }
        
        // Paramètres de l'API
        $apiSettings = [
            'key' => 'elom_api_12345678901234567890',
            'secret' => 'elom_secret_12345678901234567890',
            'rate_limit' => 60,
            'permissions' => ['read', 'write'],
            'resources' => ['circuits', 'reservations', 'clients', 'blog'],
        ];
        
        foreach ($apiSettings as $key => $value) {
            Setting::setValue($key, $value, 'api');
        }
    }
}