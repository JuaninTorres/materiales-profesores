<?php

// app/Http/Controllers/MaterialController.php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\Response;

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

        $content = Storage::disk('public')->get($material->file_path);
        abort_if($content === null, 404);

        // Reescribir las URLs de assets de producción al servidor local.
        // Localmente: usa los assets del dev server (cambios CSS/JS se aplican de inmediato).
        // En producción: asset() devuelve la misma URL base → sin impacto.
        $content = str_replace(
            [
                'https://profenicolas.cl/assets_presentaciones/',
                'https://profenicolas.cl/assets_guias/',
            ],
            [
                asset('assets_presentaciones').'/',
                asset('assets_guias').'/',
            ],
            $content
        );

        return response($content, 200)->header('Content-Type', 'text/html; charset=utf-8');
    }

    public function pdf(Material $material, string $modo): Response
    {
        abort_unless($material->published && $material->type === 'html' && $material->file_path, 404);

        if ($modo === 'docente') {
            abort_unless(auth()->check(), 403);
        }

        $contentUrl = route('materials.content', $material).'?modo='.$modo;
        $filename = $material->code.'-'.$modo.'.pdf';

        $pdf = Browsershot::url($contentUrl)
            ->waitUntilNetworkIdle()
            ->setDelay(3000)
            ->emulateMedia('print')
            ->showBackground()
            ->format('Letter')
            ->margins(15, 15, 15, 15)
            ->addChromiumArguments(['--no-sandbox', '--disable-setuid-sandbox'])
            ->pdf();

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    public function show(Material $material)
    {
        $related = Material::where('published', true)
            ->where('course', $material->course)
            ->whereKeyNot($material->getKey())
            ->latest('id')
            ->take(4)
            ->get();

        $materialSubType = null;
        if ($material->type === 'html' && $material->file_path) {
            $materialSubType = $this->parseMaterialSubType($material);
        }

        return view('materiales.show', compact('material', 'related', 'materialSubType'));
    }

    /**
     * Lee el bloque MATERIAL_META del HTML y extrae el campo material_type.
     * Retorna 'guia' si está explícito, 'presentacion' en cualquier otro caso.
     */
    private function parseMaterialSubType(Material $material): string
    {
        $path = Storage::disk('public')->path($material->file_path);
        $handle = @fopen($path, 'r');
        if (! $handle) {
            return 'presentacion';
        }
        $header = fread($handle, 1024);
        fclose($handle);

        if (preg_match('/<!--\s*MATERIAL_META(.*?)-->/s', $header, $block)
            && preg_match('/material_type:\s*(\S+)/', $block[1], $m)) {
            return strtolower(trim($m[1]));
        }

        return 'presentacion';
    }
}
