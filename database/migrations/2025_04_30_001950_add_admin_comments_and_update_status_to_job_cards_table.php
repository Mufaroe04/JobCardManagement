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
        Schema::table('job_cards', function (Blueprint $table) {
            $table->text('admin_comments')->nullable()->after('status'); // Add the new column
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->change(); // Modify the status column
            $table->text('job_description')->nullable()->change(); // Modify job_description to be nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_cards', function (Blueprint $table) {
            $table->dropColumn('admin_comments'); // Reverse the addition
            // For reversing the enum change, it's more complex and might involve reverting to the previous type if known.
            // For this evaluation, a simple rollback of the entire migration might be sufficient if needed.
        });
    }
};
