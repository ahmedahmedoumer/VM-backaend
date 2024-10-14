<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    use HasFactory,UsesUuid; // Add the UsesUuid trait

    protected $keyType = 'string'; // Specify key type
    public $incrementing = false;

    protected $fillable = [
        'id',            // UUID primary key
        'visitor_id',    // Foreign key referencing a visitor
        'property_name', // Name of the property
        'property_type', // Type of property (e.g., Tool, Equipment)
        'description',   // Optional description of the property
        'quantity',      // Quantity of the property, default is 1
    ];

    // Define the relationship with the Visitor model
    public function visitor(): BelongsTo {
        return $this->belongsTo(Visitor::class);
    }
}
