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
        Schema::create('sales_commission_layers', function (Blueprint $table) {
            $table->id();
            $table->unsignedDecimal('from', 15, 2);
            $table->unsignedDecimal('to', 20, 2);
            $table->unsignedTinyInteger('percentage');
            $table->foreignId('sales_commission_id')->constrained('sales_commissions', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_commission_layers');
    }
};
