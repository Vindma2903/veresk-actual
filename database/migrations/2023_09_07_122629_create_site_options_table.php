<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_options', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->text('body')->nullable();
            $table->json('body_json')->nullable();
            $table->string('type', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_options');
    }
};
