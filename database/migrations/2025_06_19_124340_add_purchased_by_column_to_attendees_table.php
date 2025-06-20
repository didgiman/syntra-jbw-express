<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendees', function (Blueprint $table) {
            // Add the new column, allowing NULL temporarily
            $table->foreignIdFor(User::class, 'purchased_by')->nullable();

            // Add a foreign key constraint
            $table->foreign('purchased_by')->references('id')->on('users');
        });

        // Update all existing records to set purchased_by to user_id
        DB::statement('UPDATE attendees SET purchased_by = user_id');

        // Make the purchased_by column not nullable, now that's it properly filled
        Schema::table('attendees', function (Blueprint $table) {
            $table->unsignedBigInteger('purchased_by')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->dropColumn('purchased_by');
        });
    }
};
