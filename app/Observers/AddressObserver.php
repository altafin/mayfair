<?php

namespace App\Observers;

use App\Models\Person\Address;

class AddressObserver
{
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
        $address->deleted_integrity = $address->generateDeleteIntegrityCode();
        $address->save();
    }

    /**
     * Handle the Address "restored" event.
     */
    public function restored(Address $address): void
    {
        $address->deleted_integrity = null;
        $address->save();
    }

    /**
     * Handle the Address "force deleted" event.
     */
    public function forceDeleted(Address $address): void
    {
        //
    }
}
