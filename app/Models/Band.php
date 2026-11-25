<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Band extends Model
{
    protected $fillable = ['name_of_band', 'photo_of_band', 'number_of_albuns'];

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}
