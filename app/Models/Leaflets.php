<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Leaflets extends Model
{

    use Notifiable;
    use SoftDeletes;

    protected $table = 'leaflets';
    public $timestamps = true;
    protected $fillable = array('code','serial','participant_id','location_id','online_raffle','type','instant_gift');

    protected $dates = ['created_at','updated_at','deleted_at'];

    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }

    protected $appends = ['CreatedTime','UpdatedTime','createdDateHumanReadable','updatedDateHumanReadable'];


      public function getCreatedDateHumanReadableAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedDateHumanReadableAttribute()
    {
        return $this->updated_at->diffForHumans(null, false, false, 4);
    }

    public function getCreatedTimeAttribute()
    {
        return $this->created_at->format('M jS\\, Y h:i:s A');
    }

    public function getUpdatedTimeAttribute()
    {
        return $this->updated_at->format('M jS\\, Y h:i:s A');
    }


  	public function leafletsTrashed() {
  		return $this->hasMany('App\Models\Leaflets','participant_id','participant_id')->onlyTrashed();
  	}


    public function location() {
        return $this->hasOne('App\Models\Locations', 'id','location_id');
    }

    public function winners() {
        return $this->hasOne('App\Models\Winners', 'leaflet_id','id');
    }

     public function participant()
    {
        return $this->belongsTo('App\Models\Participant', 'participant_id', 'id');
    }

    public function upload()
	 {
			 return $this->hasOne('App\Models\LeafletsUpload', 'id', 'leaflet_id');
	 }

    public function document()
    {
        return $this->belongsTo('App\Models\Documents', 'document_id', 'id');
    }

    public function gift()
    {
        return $this->hasOne('App\Models\Gifts', 'id', 'online_raffle');
    }
    public function voucher()
    {
        return $this->hasOne('App\Models\VoucherCodes', 'id', 'online_raffle');
    }
}
