<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchasedetail extends Model
{
    /**
     * This Model relationship with Product Model.
     *
     * @function belongsTo
     */
    public function getProduct()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
