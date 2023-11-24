<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{

	use SoftDeletes;

    protected $table = 'voucher';
    public $timestamps = true;
    protected $fillable = array('name','image','qty','chance');

    protected $dates = ['created_at','updated_at'];

    public function code() {
		return $this->hasMany('App\Models\VoucherCodes', 'voucher_id', 'id');
    }
    public function consumed() {
		return $this->belongsTo('App\Models\VoucherCodes', 'id', 'voucher_id')->where('status',1)->selectRaw('voucher_id, count(*) as count');
    }

}