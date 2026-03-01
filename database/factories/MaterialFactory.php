<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MaterialFactory extends Factory
{
    public function definition(): array
    {
        $levels = ['colegio','cft','particulares'];
        $types  = ['pdf','image','video','html','latex','link','other'];
        $subjects = ['Matemática','Álgebra','Cálculo','Probabilidad','Estadística'];

        $type = $this->faker->randomElement($types);
        $code = strtoupper($this->faker->lexify('CFT??-MAT-').$this->faker->numberBetween(100,999));

        $filePath = null; $fileMime = null; $sizeBytes = null; $linkUrl = null;

        if (in_array($type, ['pdf','html'])) {
            $filePath  = 'materials/demo/'.Str::slug($code).'.'.($type === 'pdf' ? 'pdf' : 'html');
            $fileMime  = $type === 'pdf' ? 'application/pdf' : 'text/html';
            $sizeBytes = $this->faker->numberBetween(102400, 2097152); // 100 KB – 2 MB en bytes
        } elseif ($type === 'link') {
            $linkUrl = $this->faker->url();
        }

        $allTags = ['álgebra','funciones','estadística','probabilidad','geometría','trigonometría','cálculo','números','PAES','prueba','guía','ejercicios'];

        return [
            'code'        => $code,
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'subject'     => $this->faker->randomElement($subjects),
            'level'       => $this->faker->randomElement($levels),
            'course'      => $this->faker->randomElement(['I° Medio','II° Medio','III° Medio','IV° Medio','Cálculo I','Álgebra I', null]),
            'year'        => $this->faker->randomElement([2023,2024,2025]),
            'semester'    => $this->faker->randomElement([1,2]),
            'unit'        => $this->faker->randomElement(['Números','Funciones','Estadística','Probabilidad', null]),
            'type'        => $type,
            'file_path'   => $filePath,
            'file_mime'   => $fileMime,
            'size_bytes'  => $sizeBytes,
            'link_url'    => $linkUrl,
            'tags'        => $this->faker->boolean(70) ? $this->faker->randomElements($allTags, $this->faker->numberBetween(1, 3)) : null,
            'published'   => $this->faker->boolean(90),
        ];
    }
}
