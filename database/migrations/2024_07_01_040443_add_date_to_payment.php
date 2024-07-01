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
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->date('tanggal')->after('penjualan_id');
            $table->string('bank')->after('tanggal');
            $table->string('atas_nama')->after('bank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('tanggal');
            $table->dropColumn('bank');
            $table->dropColumn('atas_nama');
        });
    }
};
