<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Waktu produk terakhir diaktifkan — diisi otomatis saat status → 'Aktif'
            $table->timestamp('activated_at')->nullable()->after('status');
        });

        // Isi activated_at untuk produk yang sudah Aktif menggunakan updated_at sebagai fallback
        DB::statement("UPDATE products SET activated_at = updated_at WHERE status = 'Aktif'");
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('activated_at');
        });
    }
};
