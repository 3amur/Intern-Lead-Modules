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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('title_type',['manger','team_leader','agent'])->after('image')->nullable();
            // Add department_id column
/*             $table->foreignId('department_id')->nullable()->after('title_type')->constrained('departments','id')->onDelete('cascade')->onUpdate('cascade');
            // Add team_id column
            $table->foreignId('team_id')->nullable()->after('department_id')->constrained('teams','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('parent_id')->nullable()->after('team_id')->constrained('users','id')->onDelete('cascade')->onUpdate('cascade'); */

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop department_id column
            $table->dropColumn('department_id');

            // Drop team_id column
            $table->dropColumn('team_id');
        });
    }
};
