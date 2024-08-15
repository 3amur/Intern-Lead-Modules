<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('iso', 2)->nullable();
            $table->string('nicename', 80)->nullable();
            $table->string('name', 80)->nullable();
            $table->string('iso3', 3)->nullable();
            $table->smallInteger('numcode')->nullable();
            $table->integer('code')->nullable();
            $table->string('arab_name', 80)->nullable();
            $table->integer('sort')->default(0);
            $table->integer('usa_sort')->default(0);
            $table->integer('tpay')->default(0);
            $table->string('flag_dir', 255)->nullable();
            $table->string('flag_size', 255)->nullable();
            $table->string('flag', 255)->nullable();
            $table->enum('status',['active','inactive','draft'])->default('inactive');
            $table->boolean('is_active')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
