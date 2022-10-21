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
        Schema::create('videoconsultations', function (Blueprint $table) {
            $table->id();
            $table->string('secret', '40')->unique();
            $table->string('medic_secret', '10');
            $table->dateTime('appointment_date');
            $table->dateTime('expiration_date');
            $table->dateTime('medic_attendance_date')->nullable();
            $table->dateTime('patient_attendance_date')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->enum('status', ['Valid', 'Finished', 'Cancelled'])->default('Valid');
            $table->string('patient_id')->nullable();
            $table->string('patient_number')->nullable();
            $table->string('patient_name');
            $table->string('medic_name');
            $table->text('evolution')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videoconsultations');
    }
};
