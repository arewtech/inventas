<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferOut extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getStatusColorAttribute()
    {
        if ($this->status === 'pending') {
            return 'bg-warning-subtle text-warning';
        }

        return 'bg-success-subtle text-success';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responseBy()
    {
        return $this->belongsTo(User::class, 'response_by');
    }
}
