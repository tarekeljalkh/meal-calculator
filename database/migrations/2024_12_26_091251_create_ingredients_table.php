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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ingredient name
            $table->enum('unit', ['gram', 'spoon', 'piece']); // Unit of measurement
            $table->decimal('calories_per_unit', 10, 2)->default(0); // Calories per unit
            $table->decimal('protein_per_unit', 10, 2)->default(0); // Protein per unit
            $table->decimal('carbs_per_unit', 10, 2)->default(0); // Carbs per unit
            $table->decimal('fats_per_unit', 10, 2)->default(0); // Fats per unit
            $table->decimal('price_per_unit', 10, 2); // Price per unit
            $table->decimal('waste_percentage', 5, 2)->default(0); // Waste percentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
