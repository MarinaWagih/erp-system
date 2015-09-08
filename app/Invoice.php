<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoices';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'installation',
        'additional_discount_percentage',
        'total_after_sales_tax', 'client_id'];
    /**
     * @var array Of dates to be treated as Carbon Object
     */
    protected $dates = ['date'];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item')
            ->withPivot('quantity', 'price', 'discount_percent');
    }
//    public function item()
//    {
//        return $this->hasManyThrough('App\Invoice','App\InvoiceItem');
//    }
    public function total()
    {
        return 0;
    }
}

