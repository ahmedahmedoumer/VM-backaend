<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckinCheckoutLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_checkout_logs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Use UUID as the primary key

            $table->uuid('visitor_id')->nullable(); // Use UUID instead of foreignId
            $table->uuid('checked_by')->nullable(); // Use UUID instead of foreignId

            $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('set null'); 
            $table->foreign('checked_by')->references('id')->on('users')->onDelete('set null'); 

            $table->timestamp('checkin_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
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
        Schema::dropIfExists('checkin_checkout_logs');
    }
}
