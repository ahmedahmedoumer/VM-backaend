<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Visitor extends Model
{
    use HasFactory,UsesUuid; // Add the UsesUuid trait

    protected $fillable = [
        'id',                       // UUID primary key
        'name',                     // Name of the visitor
        'contact_number',           // Contact number
        'identification_type',      // Type of identification
        'identification_number',    // Unique identification number
        'admin_approval',           // Approval status
        'purpose',                  // Purpose of the visit
        'status',                   // Status of the visitor
        'expected_start_date',      // Expected start date
        'expected_end_date',        // Expected end date
        'company_id',               // Company ID (UUID)
        'approved_by',              // Approved by user ID (UUID)
        'rejection_reason_id',      // Rejection reason ID (UUID)
    ];



    public function properties()
    {
        return $this->hasMany(Property::class, 'visitor_id'); // Assuming 'visitor_id' is the foreign key in the properties table
    }
    // Scope methods for status
    public function scopeApproved($query) {
        return $query->where('status', 'Approved');
    }

    public function scopePending($query) {
        return $query->where('status', 'Pending');
    }

    public function scopeRejected($query) {
        return $query->where('status', 'Rejected');
    }

    // Scope methods for check-in and check-out
    public function scopeCheckedIn($query) {
        return $query->where('status', 'Checked In');
    }

    public function scopeCheckedOut($query) {
        return $query->where('status', 'Checked Out');
    }

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'); // Format as desired
    }

    // Accessor for updated_at
    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'); // Format as desired
    }
    public function visitorLogs()
    {
        return $this->hasMany(VisitorLog::class, 'visitor_id');
    }
}
