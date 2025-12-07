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
        Schema::create('asset_borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('borrower_name');
            $table->string('borrower_phone');
            $table->string('borrower_address')->nullable();
            $table->datetime('borrowed_at');
            $table->datetime('expected_return_date');
            $table->datetime('actual_return_date')->nullable();
            $table->string('status')->default('borrowed'); // borrowed, returned, lost
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // created_by login user ( admin / staff )
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_borrowings');
    }
};