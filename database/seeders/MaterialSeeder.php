<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        // Ejemplos concretos
        Material::factory()->create([
            'code' => 'CFTPUCV-MAT-101',
            'title' => 'Media, Mediana y Moda (PDF)',
            'description' => 'Guía resumida con ejercicios.',
            'subject' => 'Estadística',
            'level' => 'cft',
            'course' => 'Estadística I',
            'year' => 2025,
            'semester' => 2,
            'unit' => 'Tendencia Central',
            'type' => 'pdf',
            'file_path' => 'materials/2025/09/medidas_tendencia_central.pdf',
            'file_mime' => 'application/pdf',
            'size_kb' => 850,
            'published' => true,
        ]);

        Material::factory()->create([
            'code' => 'COLEGIO-MAT-202',
            'title' => 'Funciones Lineales (HTML)',
            'description' => 'Presentación HTML con gráficos (Chart.js).',
            'subject' => 'Matemática',
            'level' => 'colegio',
            'course' => 'III° Medio',
            'year' => 2025,
            'semester' => 2,
            'unit' => 'Funciones',
            'type' => 'html',
            'file_path' => 'materials/2025/09/funciones_lineales.html',
            'file_mime' => 'text/html',
            'size_kb' => 500,
            'published' => true,
        ]);

        Material::factory(20)->create();
    }
}
