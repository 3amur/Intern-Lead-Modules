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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('phone',20);
            $table->string('national_id',20);
            $table->string('relationship',50);
            $table->date('birth_date');
            $table->enum('status',['active','inactive','draft'])->default('active');
            $table->foreignId('potential_account_id')->constrained('lead_accounts','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('head_member_id')->constrained('head_family_members','id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('family_members');
    }
};
