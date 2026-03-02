<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return response()
            ->view('sitemap', compact('materials'))
            ->header('Content-Type', 'application/xml');
    }
}
