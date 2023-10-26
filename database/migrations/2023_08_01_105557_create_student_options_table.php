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
        Schema::create('student_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->boolean('has_free_unlimited_sessions')->default(false);
            $table->boolean('has_free_sessions_for_company')->default(false);
            $table->boolean('has_free_recurring_sessions_for_company')->default(false);
            $table->boolean('has_gift_sessions')->default(false);
            $table->boolean('has_recurring_gift_sessions')->default(false);
            $table->boolean('has_email_notification')->default(true);
            $table->integer('count_trial_sessions')->unsigned()->default(1);
            $table->integer('count_company_sessions')->unsigned()->default(0);
            $table->integer('count_gift_sessions')->unsigned()->default(0);
            $table->integer('count_recurring_gift_sessions')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_options');
    }
};
