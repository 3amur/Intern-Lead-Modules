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
        Schema::create('potential_account_details', function (Blueprint $table) {
            $table->id();
            $table->date('starting_date')->nullable();
            $table->enum('current_insurer',['yes','no'])->nullable();
            $table->enum('utilization',['yes','no'])->nullable();
            $table->unsignedDecimal('potential_premium', 15, 2)->nullable();
            $table->unsignedTinyInteger('chance_of_sale')->nullable();
            $table->unsignedDecimal('price_range_min', 15, 2)->nullable();
            $table->unsignedDecimal('price_range_max', 15, 2)->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('potential_account_id')->constrained('lead_accounts','id')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('potential_customer_details');
    }
};
