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
        Schema::create('target_layers', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('from', 15, 2);
            $table->unsignedDecimal('to', 15, 2);
            $table->unsignedTinyInteger('percentage');
            $table->foreignId('target_type_id')->constrained('target_types', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sales_target_id')->constrained('sales_targets', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_layers');
    }
};
