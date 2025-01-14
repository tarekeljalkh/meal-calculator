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
        Schema::create('meal_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->onDelete('cascade'); // Meal being defined
            $table->foreignId('ingredient_id')->nullable()->constrained()->onDelete('cascade'); // Standard ingredient
            $table->foreignId('sub_meal_id')->nullable()->constrained('meals')->onDelete('cascade'); // Sub-meal as an ingredient
            $table->decimal('quantity', 10, 2); // Quantity of ingredient or sub-meal
            $table->decimal('total_cost', 10, 2)->nullable(); // Pre-calculated cost for this ingredient/sub-meal
            $table->decimal('total_calories', 10, 2)->nullable(); // Total calories for the meal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_ingredient');
    }
};
