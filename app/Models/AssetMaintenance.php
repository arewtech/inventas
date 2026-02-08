<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'condition',
        'nominal',
        'notes'
    ];

    protected $casts = [
        'nominal' => 'decimal:2'
    ];

    /**
     * Get the asset that this maintenance record belongs to
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
