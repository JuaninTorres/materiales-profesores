<?php

// app/Http/Controllers/MaterialController.php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $q = Material::query();

        // (Opcional) filtros rápidos
        if ($search = $request->string('q')) {
            $q->where(function ($qq) use ($search) {
                $qq->where('title', 'like', "%{$search}%")
                    ->orWhere('course', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($course = $request->string('course')) {
            $q->where('course', $course);
        }
        if ($type = $request->string('type')) {
            $q->where('type', $type);
        }
        if ($sem = $request->string('semester')) {
            $q->where('semester', $sem);
        }

        $materials = $q->publicado()->latest('id')->paginate($request->integer('per_page', 12))->withQueryString();

        return view('materiales.index', compact('materials'));
    }

    public function content(Material $material)
    {
        abort_unless($material->published && $material->type === 'html' && $material->file_path, 404);

        $content = \Illuminate\Support\Facades\Storage::disk('public')->get($material->file_path);
        abort_if($content === null, 404);

        return response($content, 200)->header('Content-Type', 'text/html; charset=utf-8');
    }

    public function show(Material $material)
    {
        $related = Material::where('published', true)
            ->where('course', $material->course)
            ->whereKeyNot($material->getKey())
            ->latest('id')
            ->take(4)
            ->get();

        return view('materiales.show', compact('material', 'related'));
    }
}
