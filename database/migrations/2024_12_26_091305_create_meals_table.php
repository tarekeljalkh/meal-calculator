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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Meal name
            $table->text('description')->nullable(); // Meal description
            $table->integer('preparation_time')->nullable(); // Time in minutes
            $table->text('preparation_method')->nullable(); // Cooking/preparation instructions
            $table->decimal('total_calories', 10, 2)->nullable(); // Total calories for the meal
                    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
