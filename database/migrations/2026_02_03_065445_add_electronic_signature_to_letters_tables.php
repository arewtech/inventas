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
        // Add electronic signature fields to transfer_ins
        Schema::table('transfer_ins', function (Blueprint $table) {
            $table->string('signer_name')->nullable()->after('response_by');
            $table->string('signer_position')->nullable()->after('signer_name');
            $table->timestamp('signed_at')->nullable()->after('signer_position');
            $table->text('signature_qr')->nullable()->after('signed_at');
        });

        // Add electronic signature fields to transfer_outs
        Schema::table('transfer_outs', function (Blueprint $table) {
            $table->string('signer_name')->nullable()->after('response_by');
            $table->string('signer_position')->nullable()->after('signer_name');
            $table->timestamp('signed_at')->nullable()->after('signer_position');
            $table->text('signature_qr')->nullable()->after('signed_at');
        });

        // Add electronic signature fields to active_teachings
        Schema::table('active_teachings', function (Blueprint $table) {
            $table->string('signer_name')->nullable()->after('response_by');
            $table->string('signer_position')->nullable()->after('signer_name');
            $table->timestamp('signed_at')->nullable()->after('signer_position');
            $table->text('signature_qr')->nullable()->after('signed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfer_ins', function (Blueprint $table) {
            $table->dropColumn(['signer_name', 'signer_position', 'signed_at', 'signature_qr']);
        });

        Schema::table('transfer_outs', function (Blueprint $table) {
            $table->dropColumn(['signer_name', 'signer_position', 'signed_at', 'signature_qr']);
        });

        Schema::table('active_teachings', function (Blueprint $table) {
            $table->dropColumn(['signer_name', 'signer_position', 'signed_at', 'signature_qr']);
        });
    }
};