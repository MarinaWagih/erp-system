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
    public function setNameAttribute($name)
    {
        $this->attributes['name']=trim($name);
    }
    /**
     * Client Have one  representative
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function representative()
    {
        return $this->belongsTo('App\User','representative_id','id');
    }
    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }
}
