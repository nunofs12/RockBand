<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Album extends Model
{
    protected $fillable = ['album_name', 'album_cover', 'release_date', 'record_lable', 'band_id'];

    protected function casts(): array
    {
        return ['release_date' => 'date'];
    }

    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class);
    }
}
