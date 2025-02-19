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
        Schema::create('sales_targets_target_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_target_id')->constrained('sales_targets','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('target_type_id')->constrained('target_types','id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

            $table->index(['sales_target_id', 'target_type_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_targets_target_types');
    }
};
