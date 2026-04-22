<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->text('description')->nullable()->after('title');
            $table->string('alt')->nullable()->after('description');
            $table->string('image_url')->nullable()->after('alt');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'alt', 'image_url']);
        });
    }
};
