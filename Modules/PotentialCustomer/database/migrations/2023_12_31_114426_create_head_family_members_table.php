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
        Schema::create('head_family_members', function (Blueprint $table) {
            $table->id();
            $table->string('head_name',100);
            $table->string('head_phone',20);
            $table->string('head_national_id',20)->nullable();
            $table->date('head_birth_date');
            $table->enum('status',['active','inactive','draft'])->default('active');
            $table->foreignId('link_id')->constrained('links','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('potential_account_id')->constrained('lead_accounts','id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('head_family_members');
    }
};
