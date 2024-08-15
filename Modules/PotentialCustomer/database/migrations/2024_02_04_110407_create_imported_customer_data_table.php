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
        Schema::create('imported_customer_data', function (Blueprint $table) {
            $table->id();
            $table->string('policy_holder', 100)->nullable();
            $table->string('member_name', 100)->nullable();
            $table->string('employee_code', 100)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->unsignedInteger('medical_code')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('marital_status', ['single', 'married'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('insurance_category', ['a', 'b', 'c'])->nullable();
            $table->string('room_type',50)->nullable();
            $table->string('optical', 100)->nullable();
            $table->string('dental', 100)->nullable();
            $table->string('maternity', 100)->nullable();
            $table->string('medication', 100)->nullable();
            $table->string('labs_and_radiology', 100)->nullable();
            $table->enum('hof_id', ['s', 'e', 'c'])->nullable();
            $table->text('notes')->nullable();
            $table->enum('status',['active','inactive','draft'])->default('active');
            $table->foreignId('potential_account_id')->constrained('lead_accounts', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collected_customer_data_from_excel');
    }
};
