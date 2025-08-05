<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadImport extends Model
{
    protected $guarded = [];

    public const STATUS_PENDING = 0;
    public const STATUS_PROCESSED = 1;

    public function scopePending($query)
    {
        return $query->where('is_processed', self::STATUS_PENDING);
    }
}
