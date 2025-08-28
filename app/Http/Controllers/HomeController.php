<?php

namespace App\Http\Controllers;

use App\Models\Circuit;
use App\Models\Destination;
use App\Models\BlogPost;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Récupérer les destinations populaires
        $popularDestinations = Destination::where('is_popular', true)
            ->where('is_active', true)
            ->take(3)
            ->get();
            
        // Récupérer les circuits en vedette
        $featuredCircuits = Circuit::where('est_actif', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        // Récupérer les articles de blog récents
        $recentPosts = BlogPost::where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        // Récupérer les témoignages approuvés
        $testimonials = Review::where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        // Récupérer les paramètres du site
        $heroTitle = Setting::get('hero_title', 'Découvrez l\'Afrique Authentique');
        $heroSubtitle = Setting::get('hero_subtitle', 'Des expériences de voyage uniques au Togo et en Afrique de l\'Ouest');
        $heroImage = Setting::get('hero_image', 'https://images.pexels.com/photos/1660995/pexels-photo-1660995.jpeg?auto=compress&cs=tinysrgb&w=1600');
        
        return view('home', compact(
            'popularDestinations',
            'featuredCircuits',
            'recentPosts',
            'testimonials',
            'heroTitle',
            'heroSubtitle',
            'heroImage'
        ));
    }
}