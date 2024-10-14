<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory, UsesUuid;
    protected $table='visitor_logs';
    protected $fillable = [
        'visitor_id',
        'checkin_time',
        'checkout_time',
        'isAvailable',
    ];
    // Define the relationship with the Visitor model
    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }
}
