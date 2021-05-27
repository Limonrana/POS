<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * This Model relationship with Vendor Model.
     *
     * @function belongsTo
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    /**
     * This Model relationship with purchaseDetails Model.
     *
     * @function belongsTo
     */
    public function salesDetails()
    {
        return $this->hasMany('App\Models\Salesdetail', 'sales_id');
    }
}
