<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salesdetail extends Model
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
