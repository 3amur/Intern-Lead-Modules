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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable();
            $table->integer('table_id')->default(0);
            $table->string('table_name')->nullable();
            $table->text('text')->nullable();
            $table->text('records_change')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('request_url')->nullable();
            $table->string('request_method')->nullable();
            $table->text('request_data')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
