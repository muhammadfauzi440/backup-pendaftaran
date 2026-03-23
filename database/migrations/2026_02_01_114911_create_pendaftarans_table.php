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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('instansi_id')->constrained()->onDelete('cascade');

            $table->string('kode_pendaftaran', 20)->unique()->index();
            $table->enum('tipe_pendaftaran', ['individu', 'kelompok'])->default('individu');
            $table->enum('kategori', ['siswa', 'mahasiswa']);

            $table->string('nim_nisn', 30)->unique();
            $table->string('kelas_semester');
            $table->string('jurusan');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi_bulan');

            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('agama');
            $table->string('kontak');

            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->string('catatan_admin')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};