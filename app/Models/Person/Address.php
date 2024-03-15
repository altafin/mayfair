<?php

namespace App\Models\Person;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'people_addresses';
    protected $fillable = [
        'zip_code',
        'street',
        'number',
        'complement',
        'state',
        'city',
        'district',
        'reference',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function addressType(): BelongsTo
    {
        return $this->belongsTo(AddressType::class);
    }

    public function generateDeleteIntegrityCode(): string
    {
        $crc32Calculed = sprintf('%s-%s'
            , $this->person_id
            , $this->address_type_id
        );
        foreach ($this->attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $crc32Calculed .= '-' . (is_null($value) ? '0' : crc32($value));
            }
        }
        return str_pad(dechex(crc32($crc32Calculed)), 8, '0', STR_PAD_LEFT);
    }

}
