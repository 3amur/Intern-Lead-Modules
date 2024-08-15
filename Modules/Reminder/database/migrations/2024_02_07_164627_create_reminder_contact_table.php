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
        Schema::create('reminders_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_id')->constrained('reminders', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('contact_id')->constrained('contacts', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

            $table->index('reminder_id');
            $table->index('contact_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_contact');
    }
};
