<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UsesUuid; // Add the UsesUuid trait

    protected $keyType = 'string'; // Specify key type
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', // UUID primary key
        'name',
        'email',
        'email_verified_at',
        'password',
        'company_id',
        'remember_token',
        'role_id', // Foreign key for the role
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Accessor for created_at
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'); // Format as desired
    }

    // Accessor for updated_at
    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'); // Format as desired
    }

    // Define the relationship with the Visitor model
    public function visitors(): HasMany {
        return $this->hasMany(Visitor::class, 'approved_by');
    }

    // Define the relationship with the Role model (one-to-one)
    public function role(): BelongsTo {
        return $this->belongsTo(Role::class); // Each user belongs to one role
    }

    // Check if the user has a specific role
    public function hasRole($role) {
        return $this->role->name === $role; // Check if the user's role matches the given role
    }
}
