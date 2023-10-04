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
        Schema::create('appointment_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('appointment_id')->unsigned();
            $table->bigInteger('subscription_id')->unsigned()->nullable();
            $table->boolean('is_free_unlimited_session')->default(0);
            $table->boolean('is_trial_session')->default(0);
            $table->boolean('is_gift_session')->default(0);
            $table->boolean('is_gift_recurring_session')->default(0);
            $table->boolean('is_auto_schedule_session')->default(0);
            $table->timestamp('auto_complete_time');
            $table->boolean('is_summary_session')->default(0);
            $table->boolean('is_company_session')->default(0);
            $table->boolean('is_company_recurring_session')->default(0);
            $table->text('zoom_data');
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_details');
    }
};
