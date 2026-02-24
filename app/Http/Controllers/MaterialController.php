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
            $q->where(function($qq) use ($search) {
                $qq->where('title','like',"%{$search}%")
                   ->orWhere('course','like',"%{$search}%")
                   ->orWhere('type','like',"%{$search}%")
                   ->orWhere('description','like',"%{$search}%");
            });
        }
        if ($course = $request->string('course'))   $q->where('course',$course);
        if ($type   = $request->string('type'))     $q->where('type',$type);
        if ($sem    = $request->string('semester')) $q->where('semester',$sem);

        $materials = $q->publicado()->latest('id')->paginate($request->integer('per_page',12))->withQueryString();

        return view('materiales.index', compact('materials'));
    }

    public function show(Material $material)
    {
        // Aquí puedes cargar relacionados si quieres:
        // $related = Material::where('course',$material->course)
        //     ->whereKeyNot($material->getKey())
        //     ->latest('id')->take(6)->get();

        return view('materiales.show', [
            'material' => $material,
            // 'related'  => $related,
        ]);
    }
}
