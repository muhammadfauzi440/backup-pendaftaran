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
        Schema::create('anggota_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->onDelete('cascade');

            $table->string('nim_nisn', 30);
            $table->string('jurusan');

            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');  
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);

            $table->string('kontak');
            $table->text('alamat');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_pendaftarans');
    }
};
