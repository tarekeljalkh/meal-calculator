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
            $table->foreignId('meal_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->nullable()->index()->constrained()->onDelete('cascade');
            $table->foreignId('sub_meal_id')->nullable()->index()->constrained('meals')->onDelete('cascade');
            $table->decimal('quantity', 10, 2);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->decimal('total_calories', 15, 2)->default(0);
            $table->decimal('waste_percentage', 5, 2)->default(0);
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
