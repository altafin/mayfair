<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
