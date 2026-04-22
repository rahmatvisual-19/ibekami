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
        // Only create the table when it does not already exist (e.g. seeding/dev DBs)
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->string('username')->primary();
                $table->string('name');
                $table->string('password');
                $table->timestamps();
            });
        }

        if (Schema::hasColumn('users', 'id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
