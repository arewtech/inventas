<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferIn extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function getStatusColorAttribute()
    {
        if ($this->status === 'pending') {
            return 'bg-warning-subtle text-warning';
        }

        return 'bg-success-subtle text-success';
        // cara manggilnya di blade: {{ $complaint->status_color }}
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responseBy()
    {
        return $this->belongsTo(User::class, 'response_by');
    }

    /**
     * Generate electronic signature QR code URL
     *
     * @param string $signerName
     * @param string $signerPosition
     * @return string
     */
    public function generateSignatureQR($signerName, $signerPosition)
    {
        $baseUrl = env('APP_URL', 'http://localhost');
        $baseIpUrl = 'http://192.168.1.4:8080';
        $signatureUrl = $baseIpUrl . '/signature/verify/' . $this->id . '/transfer-in';

        // Update signer information
        $this->update([
            'signer_name' => $signerName,
            'signer_position' => $signerPosition,
            'signed_at' => now(),
            'signature_qr' => $signatureUrl,
        ]);

        return $signatureUrl;
    }
}