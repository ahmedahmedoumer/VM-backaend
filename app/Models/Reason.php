<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Reason extends Model
{
    use HasFactory, UsesUuid; // Add the UsesUuid trait

    protected $keyType = 'string'; // Specify key type
    public $incrementing = false;

    protected $fillable = [
        'id', // UUID primary key
        'reason',
        'description', // Optional: add if you want to include a description for the role
    ];



    
    // Scope methods for filtering properties
    public function scopeWithPropertyName($query, $name) {
        return $query->where('property_name', 'like', '%' . $name . '%');
    }

    public function scopeWithPropertyType($query, $type) {
        return $query->where('property_type', $type);
    }

    public function scopeWithQuantity($query, $quantity) {
        return $query->where('quantity', $quantity);
    }
    public function visitor(): BelongsTo {
        return $this->belongsTo(Visitor::class);
    }
}
