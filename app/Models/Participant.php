<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{

	use SoftDeletes;

    protected $table = 'participants';
    public $timestamps = true;
    protected $fillable = array('mobile','fullname', 'age', 'city','gender','othercity','locale' ,'approved' ,'step', 'ban');

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $appends = ['CreatedTime','createdDateHumanReadable','updatedDateHumanReadable'];


    public function getCreatedDateHumanReadableAttribute()
    {
	    if($this->created_at){
	        return $this->created_at->diffForHumans();
        }
    }

    public function getCreatedTimeAttribute()
    {
	    if($this->created_at){
	        return $this->created_at->format('M jS\\, Y h:i:s A');
        }
    }


    public function getUpdatedDateHumanReadableAttribute()
    {
	    if($this->updated_at){
	        return $this->updated_at->diffForHumans();
        }
    }

    public function city() {
        return $this->belongsTo('App\Models\Cities', 'city');
    }

    public function location() {
        return $this->hasOne('App\Models\Locations', 'city_id','city');
    }

    public function leaflet() {
        return $this->hasOne('App\Models\Leaflets', 'participant_id','id')->latest();
    }

    public function getCity() {
        return $this->hasOne('App\Models\Cities', 'id','city');
    }

    public function getCityNameAttribute() {
        return $this->getcity->name;
	}

    public function files()
    {
        return $this->hasMany('App\Models\ParticipantFiles', 'participant_id', 'id');
    }

	public function participantTrashed() {
		return $this->hasMany('App\Models\ParticipantFiles','participant_id','id')->onlyTrashed();
	}

}
