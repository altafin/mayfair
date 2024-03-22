<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ZipCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'zip_code',
        'street',
        'district',
        'city',
        'state',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

}
