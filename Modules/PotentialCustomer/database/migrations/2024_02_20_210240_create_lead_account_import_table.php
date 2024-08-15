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
        Schema::create('lead_account_import', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('account_contact_name');
            $table->string('personal_number');
            $table->enum('condition',['lead','potential','customer'])->default('lead');
            $table->enum('created_as',['lead','potential','customer'])->default('lead');
            $table->string('old_condition')->nullable();
            $table->string('old_contact_account_name')->nullable();
            $table->string('old_account_name')->nullable();
            $table->string('old_personal_number')->nullable();
            $table->boolean('is_new');
            $table->boolean('has_changes');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_account_imports');
    }
};
