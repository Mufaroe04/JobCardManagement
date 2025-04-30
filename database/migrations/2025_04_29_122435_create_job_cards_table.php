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
        Schema::create('job_cards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('job_title');
            $table->string('client_name');
            $table->text('job_description');
            $table->string('assigned_technician')->nullable();
            $table->date('estimated_completion_date')->nullable();
            $table->string('status')->default('Pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_cards');
    }
};
