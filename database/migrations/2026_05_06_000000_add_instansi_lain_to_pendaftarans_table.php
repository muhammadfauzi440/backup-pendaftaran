<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->unsignedBigInteger('instansi_id')->nullable()->change();

            $table->string('instansi_lain')->nullable()->after('instansi_id');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->unsignedBigInteger('instansi_id')->nullable(false)->change();
            $table->dropColumn('instansi_lain');
        });
    }
};
