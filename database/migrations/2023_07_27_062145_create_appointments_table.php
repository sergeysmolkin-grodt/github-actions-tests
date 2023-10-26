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
        Schema::create('appointments', function (Blueprint $table) {
            $statuses = array_values(config('app.appointment_statuses'));

            $table->id();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('teacher_id')->unsigned();
            $table->date('date');
            $table->time('from');
            $table->time('to');
            $table->enum('status', $statuses)->default(reset($statuses));
            $table->string('cancelled_by')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['date', 'from', 'status']);
            $table->unique(['teacher_id', 'date', 'from']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
