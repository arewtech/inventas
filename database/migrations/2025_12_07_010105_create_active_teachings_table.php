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
        Schema::create('active_teachings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // yang mengajukan surat
            $table->foreignId('response_by')->nullable()->constrained('users')->onDelete('cascade'); // penyetuju surat
            $table->string('letter')->nullable(); // nama surat
            $table->string('type')->nullable(); // transfer_incoming
            $table->string('number')->nullable(); // nomor surat
            // format data surat
            $table->string('teacher_name'); // nama guru
            $table->string('birth_place'); // tempat lahir
            $table->date('birth_date'); // tanggal lahir
            $table->string('nuptk'); // NUPTK
            $table->string('education'); // pendidikan
            $table->string('teaching_hours'); // jumlah jam mengajar
            $table->text('teacher_address'); // alamat guru
            $table->date('tmt'); // terhitunng mulai tanggal

            $table->string('status')->default('pending'); // pending, success
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('active_teachings');
    }
};
