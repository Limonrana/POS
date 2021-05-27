<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_name', 'street', 'city', 'state', 'zip', 'country','type', 'remarks', 'created_by', 'updated_by',
    ];
}
