<?php

namespace App;

use Carbon\Carbon;
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
    protected $fillable = ['date', 'type',
        'additional_discount_percentage','duration_expire','price_type',
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

    public function getDateAttribute()
    {

        return Carbon::parse($this->attributes['date'])->toDateString();
    }
    public function totalBeforeDiscount()
    {
        $sum=0;
        foreach($this->items as $item)
        {
            $sum+=$item->pivot->price*$item->pivot->quantity;
        }
        return $sum;
    }
    public function totalDiscount()
    {
        $sum=0;
        foreach($this->items as $item)
        {
            $sum+=($item->pivot->price*$item->pivot->quantity)
                                            *($item->pivot->discount_percent/100);
        }
        return $sum;
    }
    public function totalAfterDiscount()
    {
        $sum=0;
        foreach($this->items as $item)
        {
            $sum+=($item->pivot->price-(($item->pivot->price)*
                    ($item->pivot->discount_percent/100)))*$item->pivot->quantity;
        }
        return $sum;
    }
    public function num($num)
    {
        $eArr = array('0','1','2','3','4','5','6','7','8','9','.');
        $aArr = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩','٫');
        return str_ireplace($eArr, $aArr, $num);
    }

    public function adate($format, $timestamp = null)
    {

        if($timestamp != null)
        {
            if(preg_match('/[^0-9]/',$timestamp))
            {
                $timestamp = strtotime($timestamp);
            }
            else
            {
                $timestamp = (int)$timestamp;
            }
        }
        $eArr = array(	'Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday',
            'January','February','March','April','May','June','July','August','September','October','November','December',
            'am','pm','AM','PM'
        );
        $aArr = array(	'الأحد','الإثنين','الثلاثاء','الأربعاء','الخميس','الجمعة','السبت',
            'يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر',
            'صباحاً','مساءاً','صباحاً','مساءاً'
        );
        if($timestamp === null)
        {
            return $this->num(str_ireplace($eArr, $aArr, date($format)));
        }
        else
        {
            return $this->num(str_ireplace($eArr, $aArr, date($format, $timestamp)));
        }
    }
}

