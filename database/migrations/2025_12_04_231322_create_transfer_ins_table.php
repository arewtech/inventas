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
        // Surat keterangan mutasi terima
        Schema::create('transfer_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // yang mengajukan surat
            $table->foreignId('response_by')->nullable()->constrained('users')->onDelete('cascade'); // penyetuju surat
            $table->string('letter')->nullable(); // nama surat
            $table->string('type')->nullable(); // transfer_incoming
            $table->string('number')->unique()->nullable(); // nomor surat
            // format data surat
            $table->string('student_name'); // nama siswa
            $table->string('birth_place'); // tempat lahir
            $table->date('birth_date'); // tanggal lahir
            $table->enum('gender', ['male', 'female']); // jenis kelamin
            $table->string('religion'); // agama
            $table->string('class'); // kelas (1, 2, 3, dst)
            $table->string('previous_school'); // sekolah asal / sebelumnya (mutasi dari)
            $table->text('student_address'); // alamat siswa
            $table->string('status')->default('pending'); // pending, success
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_ins');
    }
};
