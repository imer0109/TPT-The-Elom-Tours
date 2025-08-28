<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Affiche la page à propos
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('about.index');
    }
}