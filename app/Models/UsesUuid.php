<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait UsesUuid
{
    /**
     * Boot the trait.
     */
    protected static function bootUsesUuid()
    {
        static::creating(function (Model $model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the incrementing property.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false; // Disable auto-incrementing
    }

    /**
     * Get the key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string'; // Set key type to string
    }
}
