<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'asset_number',
        'description',
        'category_id',
        'quantity',
        'condition',
        'location_id',
        'parent_asset_id',
        'qr_code',
        'image',
        'additional_info'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function borrowings()
    {
        return $this->hasMany(AssetBorrowing::class);
    }

    /**
     * Parent asset relationship (for damaged assets)
     */
    public function parentAsset()
    {
        return $this->belongsTo(Asset::class, 'parent_asset_id');
    }

    /**
     * Damaged assets relationship (children)
     */
    public function damagedAssets()
    {
        return $this->hasMany(Asset::class, 'parent_asset_id')->where('condition', 'rusak');
    }

    /**
     * Check if this asset is a damaged child asset
     */
    public function isDamagedChild()
    {
        return !is_null($this->parent_asset_id);
    }

    /**
     * Check if this asset is a parent (main) asset
     */
    public function isParentAsset()
    {
        return is_null($this->parent_asset_id);
    }

    /**
     * Get total damaged quantity for this asset
     */
    public function getTotalDamagedQuantityAttribute()
    {
        return $this->damagedAssets()->sum('quantity');
    }

    /**
     * Get original total quantity (current + damaged)
     */
    public function getOriginalQuantityAttribute()
    {
        if ($this->isParentAsset()) {
            return $this->quantity + $this->getTotalDamagedQuantityAttribute();
        }
        return $this->quantity;
    }

    public function getRouteKeyName()
    {
        return 'asset_number';
    }

    public function getStatusColorAttribute()
    {
        switch ($this->condition) {
            case 'baik':
                return 'bg-primary-subtle text-primary';
            case 'rusak':
                return 'bg-danger-subtle text-danger';
            default:
                return 'bg-secondary-subtle text-muted';
        }
    }

    /**
     * Generate a unique asset number
     *
     * @return string
     */
    public static function generateAssetNumber(): string
    {
        $prefix = 'as';
        $randomPart = strtolower(Str::random(8));
        $timestamp = now()->format('ymdHi');

        // Combine parts to create a unique 15-character asset number
        $assetNumber = $prefix . '-' . $randomPart . '-' . $timestamp;

        // Check if the asset number already exists (extremely unlikely, but just to be safe)
        while (self::where('asset_number', $assetNumber)->exists()) {
            $randomPart = strtolower(Str::random(8));
            $assetNumber = $prefix . '-' . $randomPart . '-' . $timestamp;
        }

        return $assetNumber;
    }
}
