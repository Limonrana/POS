<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /**
     * This Model relationship with Vendor Model.
     *
     * @function belongsTo
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * This Model relationship with purchaseDetails Model.
     *
     * @function belongsTo
     */
    public function purchaseDetails()
    {
        return $this->hasMany(Purchasedetail::class);
    }
}
