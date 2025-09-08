<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();

            $table->string('subject')->index();
            $table->enum('level', ['colegio','cft','particulares'])->index();
            $table->string('course')->nullable()->index();
            $table->smallInteger('year')->nullable()->index();
            $table->tinyInteger('semester')->nullable()->index();
            $table->string('unit')->nullable();

            $table->enum('type', ['pdf','image','video','html','latex','link','other'])->index();

            $table->string('file_path')->nullable();
            $table->string('file_mime')->nullable();
            $table->integer('size_kb')->nullable();
            $table->string('link_url')->nullable();

            $table->boolean('published')->default(true)->index();
            $table->timestamps();

            // FULLTEXT para MySQL 8 (InnoDB)
            $table->fullText(['title', 'description']);
            $table->fullText(['subject', 'course', 'unit']); // opcional pero útil
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
