<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'trading_name',
        'trading_address',
        'date',
        'date',
        'mobile',
        'fax',
        'representative_id'
    ];
    /**
     * @var array Of dates to be treated as Carbon Object
     */
    protected $dates = ['date'];

    /**
     * Client Have one  representative
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function representative()
    {
        return $this->belongsTo('App\Representative');
    }
    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }
}
