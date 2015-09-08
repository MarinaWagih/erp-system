<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[ 'name', 'picture', 'price_31_a',
                           'price_32_b', 'price_1050', 'price_1250',
                           'price_1034'];
    public function invoices()
    {
        return $this->belongsToMany('App\Invoice')
            ->withPivot('quantity','price', 'discount_percent');
    }
}

