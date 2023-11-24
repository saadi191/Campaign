<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherCodes extends Model
{

	use SoftDeletes;

    protected $table = 'voucher_codes';
    public $timestamps = true;
    protected $fillable = array('code','voucher_id','status');

    protected $dates = ['created_at','updated_at'];

    public function consumed() {
		return $this->belongsTo('App\Models\Leaflets', 'id', 'gift')->selectRaw('gift, count(*) as count');
    }

    public function voucher() {
		return $this->belongsTo('App\Models\Voucher', 'voucher_id', 'id');
    }
}
