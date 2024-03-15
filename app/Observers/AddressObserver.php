<?php

namespace App\Observers;

use App\Models\Person\Address;

class AddressObserver
{
    private $arrAddressFields = array('zip_code', 'street', 'number', 'complement', 'uf', 'city', 'district', 'reference');

    /**
     * Handle the Address "created" event.
     */
    public function created(Address $address): void
    {
        //
    }

    /**
     * Handle the Address "updated" event.
     */
    public function updated(Address $address): void
    {
        //
    }

    /**
     * Handle the Address "deleted" event.
     */
    public function deleted(Address $address): void
    {
        //Calculate the delete integrity code
        $crc32Calculed = $address->person_id;
        foreach ($address as $key => $value) {
            if (in_array($key, $this->arrAddressFields))
                $crc32Calculed .= '-' . crc32($value);
        }
        $address->deleted_integrity = crc32($crc32Calculed);
        $address->save();
    }

    /**
     * Handle the Address "restored" event.
     */
    public function restored(Address $address): void
    {
        //
    }

    /**
     * Handle the Address "force deleted" event.
     */
    public function forceDeleted(Address $address): void
    {
        //
    }
}
