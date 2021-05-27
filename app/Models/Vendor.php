<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /**
     * This Model relationship with Address Model.
     *
     * @function belongsTo
     */
    public function getAddress()
    {
        return $this->belongsTo('App\Models\Address', 'address');
    }

    /**
     * This Model relationship with Payment Model.
     *
     * @function belongsTo
     */
    public function getPayment()
    {
        return $this->belongsTo('App\Models\Paymentmethod', 'payment_method');
    }
}
