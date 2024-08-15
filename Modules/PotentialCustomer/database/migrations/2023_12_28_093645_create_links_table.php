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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('subject',150);
            $table->string('url');
            $table->dateTime('expired_at');
            $table->enum('status',['active','inactive','draft'])->default('active');
            $table->foreignId('account_id')->nullable()->constrained('lead_accounts','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('links');
    }
};
