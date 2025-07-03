<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->integer('topics_count');
        $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade'); // 👈 این مهمه
        $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
