<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetBorrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'quantity',
        'borrower_name',
        'borrower_phone',
        'borrower_address',
        'borrowed_at',
        'expected_return_date',
        'actual_return_date',
        'status',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'expected_return_date' => 'datetime',
        'actual_return_date' => 'datetime',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}