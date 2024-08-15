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
        Schema::create('sales_targets', function (Blueprint $table) {
            $table->id();
            $table->string('target_name',100);
            $table->unsignedDecimal('target_value',15,2);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('target_calc_method',['separate','group']);
            $table->enum('status',['active','inactive','draft'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['start_date', 'end_date', 'status']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_targets');
    }
};
