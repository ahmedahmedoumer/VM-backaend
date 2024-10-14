<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID as primary key
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->uuid('company_id')->nullable(); // Use uuid instead of foreignId
            $table->uuid('role_id')->nullable(); // Use uuid instead of foreignId
            $table->rememberToken();
            $table->timestamps();
        
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null'); // Define foreign key constraint
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null'); // Define foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
