<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded = [];

    public const SCORE_THRESHOLD = 80;
    public const STATUS_ASSIGNED = 1;
    public const STATUS_UNASSIGNED = 0;
}
