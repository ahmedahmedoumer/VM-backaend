<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Use UUID as the primary key
            $table->uuid('visitor_id')->nullable(); // Use UUID instead of foreignId

            $table->string('property_name');
            $table->string('property_type');
            $table->string('property_status');
            $table->text('description')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('set null'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
