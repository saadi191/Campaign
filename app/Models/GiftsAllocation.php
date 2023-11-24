<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftsAllocation extends Model
{
	use SoftDeletes;

    protected $table = 'gifts_allocation';
    public $timestamps = true;
    protected $fillable = array('gift_id', 'location_id', 'qty');

    protected $dates = ['created_at','updated_at'];

    public function gifts() {
        return $this->belongsTo('App\Models\Gifts', 'gift_id', 'id');
    }

    public function consumed() {
		return $this->belongsTo('App\Models\Leaflets', 'gift_id', 'online_raffle')->where('type','gift')->selectRaw('online_raffle, count(*) as count');
    }

}