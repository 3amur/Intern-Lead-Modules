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
        Schema::create('lead_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_name',100);
            $table->string('account_contact_name',100);
            $table->string('lead_account_title',100)->nullable();
            $table->string('personal_number',20);
            $table->string('phone',20)->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('email',100)->nullable();
            $table->string('website',255)->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedMediumInteger('zip_code')->nullable();;
            $table->string('image')->nullable();
            $table->enum('status',['active','inactive','draft'])->default('active');
            $table->enum('condition',['lead','potential','customer'])->default('lead');
            $table->enum('created_as',['lead','potential','customer'])->default('lead');
            $table->foreignId('city_id')->nullable()->constrained('cities','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lead_source_id')->nullable()->constrained('lead_sources','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lead_status_id')->nullable()->constrained('lead_statuses','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lead_value_id')->nullable()->constrained('lead_values','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lead_type_id')->nullable()->constrained('lead_types','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sales_agent_id')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['lead_source_id','lead_status_id','lead_value_id','created_by','sales_agent_id'], 'lead_accounts_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_accounts');
    }
};
