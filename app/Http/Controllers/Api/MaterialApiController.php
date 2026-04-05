<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMaterialRequest;
use App\Http\Requests\Api\UpdateMaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use App\Services\MaterialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MaterialApiController extends Controller
{
    public function __construct(private readonly MaterialService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Material::query();

        if ($level = $request->get('level')) {
            $query->where('level', $level);
        }
        if ($course = $request->get('course')) {
            $query->where('course', $course);
        }
        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
        if ($subject = $request->get('subject')) {
            $query->where('subject', $subject);
        }
        if ($year = $request->get('year')) {
            $query->where('year', (int) $year);
        }
        if ($sem = $request->get('semester')) {
            $query->where('semester', (int) $sem);
        }

        $perPage = min($request->integer('per_page', 15), 100);

        return MaterialResource::collection(
            $query->latest('id')->paginate($perPage)
        );
    }

    public function store(StoreMaterialRequest $request): JsonResponse
    {
        $data = $request->except('archivo_html');
        $material = $this->service->store($data, $request->file('archivo_html'));

        return (new MaterialResource($material))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateMaterialRequest $request, Material $material): MaterialResource
    {
        $data = $request->except('archivo_html');
        $updated = $this->service->update($material, $data, $request->file('archivo_html'));

        return new MaterialResource($updated);
    }
}
