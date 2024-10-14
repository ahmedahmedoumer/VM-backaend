<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory, UsesUuid; // Add the UsesUuid trait

    protected $keyType = 'string'; // Specify key type
    public $incrementing = false;

    protected $fillable = [
        'id', // UUID primary key
        'name',
        'description', // Optional: add if you want to include a description for the role
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    // Define the many-to-many relationship with the User model
    public function users(): HasMany {
        return $this->hasMany(User::class);
    }



    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'); // Format as desired
    }

    // Accessor for updated_at
    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'); // Format as desired
    }

}
