<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Permission extends Model
{
    use HasFactory, UsesUuid; // Add the UsesUuid trait

    protected $keyType = 'string'; // Specify key type
    public $incrementing = false;


    protected $fillable = [
        'id', // UUID primary key
        'name',
        'slug',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
