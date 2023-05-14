<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SaveTrace extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'record_id', 'table_name', 'data_type', 'action'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function targetable(): MorphTo
    {
        return $this->morphTo();
    }
}
