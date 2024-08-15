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
        Schema::create('member_files', function (Blueprint $table) {
            $table->id();
            $table->string('national_id_card')->nullable();
            $table->string('personal_image')->nullable();
            $table->enum('status',['active','inactive','draft'])->default('active');
            $table->foreignId('head_member_id')->constrained('head_family_members','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('family_member_id')->nullable()->constrained('family_members','id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('members_files');
    }
};
