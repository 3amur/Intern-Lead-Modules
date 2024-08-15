<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Extension\DescriptionList\Node\Description;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('reminder_title', 100);
            $table->dateTime('reminder_start_date')->default(now());
            $table->dateTime('reminder_end_date')->default(now());
            $table->text('description')->nullable();
            $table->enum('reminder_relation', ['leads'])->nullable();
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->enum('reminder_type', ['note', 'call', 'meeting']);
            $table->foreignId('lead_id')->nullable()->constrained('lead_accounts','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            //Indexes
            $table->index('created_by');
            $table->index('updated_by');
            $table->index('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
