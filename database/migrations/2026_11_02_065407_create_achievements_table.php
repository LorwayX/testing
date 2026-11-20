<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('category'); // Akademik, Teknologi, Olahraga, Seni, Organisasi, Sosial, Lainnya
            $table->string('title'); 
            $table->string('organizer')->default('Sekolah / Panitia'); 
            $table->string('level'); // Internasional, Nasional, Provinsi, Kabupaten/Kota, Sekolah
            $table->string('result'); // Juara 1, Juara 2, Juara 3, Peserta/Finalis
            $table->date('achievement_date')->nullable();
            $table->text('description')->nullable();
            $table->string('evidence_path')->nullable(); 
            $table->string('visibility')->default('public'); // public, school, private
            $table->string('verification_status')->default('pending'); // pending, approved, rejected
            $table->integer('points')->default(0); // Poin otomatis dihitung
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};