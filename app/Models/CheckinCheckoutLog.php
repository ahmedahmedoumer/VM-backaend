<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CheckinCheckoutLog extends Model
{
    use HasFactory,UsesUuid; // Add the UsesUuid trait

    protected $keyType = 'string'; // Specify key type
    public $incrementing = false; // Disable auto-incrementing

    protected $fillable = [
        'id',
        'visitor_id',
        'checked_by',
        'checkin_at',
        'checkout_at',
    ];
}
