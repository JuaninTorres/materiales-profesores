<?php

namespace App\Http\Controllers;

use App\Models\Material;

class PageController extends Controller
{
    public function home()
    {
        $recentMaterials = Material::where('published', true)
            ->latest()
            ->take(4)
            ->get();

        return view('pages.home', compact('recentMaterials'));
    }

    public function sitemap()
    {
        $materials = Material::where('published', true)
            ->select('code', 'updated_at')
            ->latest()
            ->get();

        $staticPages = [
            'home' => ['route' => 'home', 'changefreq' => 'weekly', 'priority' => 1.0],
            'materials' => ['route' => 'materials.index', 'changefreq' => 'daily', 'priority' => 0.9],
            'about' => ['route' => 'about', 'changefreq' => 'monthly', 'priority' => 0.7],
            'services' => ['route' => 'services', 'changefreq' => 'monthly', 'priority' => 0.7],
            'contact' => ['route' => 'contact', 'changefreq' => 'monthly', 'priority' => 0.6],
        ];

        return response()
            ->view('sitemap', compact('materials', 'staticPages'))
            ->header('Content-Type', 'application/xml');
    }
}
