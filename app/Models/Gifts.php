<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gifts extends Model
{

	use SoftDeletes;

    protected $table = 'gifts';
    public $timestamps = true;
    protected $fillable = array('name','image','chance');

    protected $dates = ['created_at','updated_at'];
    
	protected $appends = [
        'Claimed'
    ];


    public function consumed() {
		return $this->belongsTo('App\Models\Leaflets', 'id', 'online_raffle')->where('type','gift')->selectRaw('online_raffle, count(*) as count');
    }

    public function allocation() {
        return $this->hasMany('App\Models\GiftsAllocation', 'gift_id', 'id');
    }
    
    public function getClaimedAttribute() {
		$claimed = Leaflets::whereHas('winners', function($query){
	        $query->where('claimed',1);
		})->with('winners')
		->where('type','gift')
		->where('online_raffle', $this->id)
		->whereNotNull('online_raffle')->get();

		return $claimed;
	}
}