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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 100);
            $table->longText('description')->nullable();
            $table->string('age_limit', length: 2);
            $table->string('banner', length: 255);
            $table->string('trailer', length: 255)->nullable();
            $table->boolean('add_to_slide')->nullable()->default(0);
            $table->unsignedBigInteger('director_id')->nullable()->comment('giám đốc SX');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
