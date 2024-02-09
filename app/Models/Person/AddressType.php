<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressType extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'people_address_types';
    protected $fillable = [
        'name',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
