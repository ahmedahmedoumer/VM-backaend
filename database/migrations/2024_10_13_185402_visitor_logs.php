<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VisitorLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Use UUID as the primary key

            $table->uuid('visitor_id'); // Reference to the visitor
            $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('cascade');

            $table->timestamp('checkin_time')->nullable(); // Check-in time
            $table->timestamp('checkout_time')->nullable(); // Check-out time
            $table->boolean('isAvailable')->default(true); // Availability status

            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_logs');
    }
}
