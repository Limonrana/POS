<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stock', 'title', 'subtitle',
    ];

    /**
     * This Model relationship with Category Model.
     *
     * @function belongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    /**
     * This Model relationship with Unit Model.
     *
     * @function belongsTo
     */
    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'unit_id');
    }

    /**
     * This Model relationship with Photo Model.
     *
     * @function belongsTo
     */
    public function photo()
    {
        return $this->belongsTo('App\Models\Photo', 'image');
    }
}
