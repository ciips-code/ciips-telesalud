<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videoconsultation_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('videoconsultation_id');
            $table->string('file_name');
            $table->string('description');
            $table->boolean('medic');

            $table->timestamps();
            $table->foreign('videoconsultation_id')->references('id')->on('videoconsultations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videoconsultation_files');
    }
};
