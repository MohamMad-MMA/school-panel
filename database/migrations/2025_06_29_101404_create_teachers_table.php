<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('national_code')->unique();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('education_level');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
