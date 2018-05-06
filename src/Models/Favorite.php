<?php

namespace Viviniko\Favorite\Models;

use Viviniko\Support\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $tableConfigKey = 'favorite.favorites_table';

    protected $fillable = [
        'favoritable_type', 'favoritable_id', 'user_id'
    ];

    /**
     * Get all of the owning favoritable models.
     */
    public function favoritable()
    {
        return $this->morphTo();
    }
}