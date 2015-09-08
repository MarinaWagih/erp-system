<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'representatives';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone'];

    public function clients()
    {
        return $this->hasMany('App\Client');
    }
}
