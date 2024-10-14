<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Use UUID as the primary key
            $table->string('name');
            $table->string('contact_number');
            $table->string('identification_type');
            $table->string('identification_number');
            $table->boolean('admin_approval')->nullable()->default(false);
            $table->text('purpose');
            
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->date('expected_start_date');
            $table->date('expected_end_date');
            $table->timestamps();

            // Foreign key constraints

            $table->uuid('company_id')->nullable(); // Use UUID instead of foreignId
            $table->uuid('approved_by')->nullable(); // Use UUID instead of foreignId
            $table->uuid('rejection_reason_id')->nullable(); // Use UUID instead of foreignId

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejection_reason_id')->references('id')->on('reasons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
