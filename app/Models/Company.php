<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Company extends Model
{
    use HasFactory, UsesUuid; // Add the UsesUuid trait

    protected $keyType = 'string'; // Specify key type
    public $incrementing = false; // Disable auto-incrementing
    protected $fillable = ['name', 'address', 'contact_number'];


        // Scope methods for filtering companies
        public function scopeWithName($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        }
    
        public function scopeWithContactNumber($query, $contactNumber) {
            return $query->where('contact_number', $contactNumber);
        }
    
        public function scopeWithAddress($query, $address) {
            return $query->where('address', 'like', '%' . $address . '%');
        }
}
