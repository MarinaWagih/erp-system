<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoice_item';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_id', 'item_id', 'quantity',
                            'price', 'discount_percent'];
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
