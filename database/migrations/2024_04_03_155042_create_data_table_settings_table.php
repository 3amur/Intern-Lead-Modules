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
        Schema::create('data_table_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key_name',100);
            $table->string('table_name',100);
            $table->text('table_settings');
            $table->foreignId('created_by')->constrained('users','id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_table_settings');
    }
};
