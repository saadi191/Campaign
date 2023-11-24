<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ParticipantFiles extends Model
{

	use SoftDeletes;

    protected $table = 'participant_files';
    public $timestamps = true;
    protected $fillable = array('participant_id', 'file_id','duplicate', 'duplicate_by', 'finalist', 'approved', 'approved_by', 'rejected_by','created_at');

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $appends = ['RejectedTime','ModeratorTime','ModeratorDeletedTime','CreatedTime','UpdatedTime','createdDateHumanReadable','updatedDateHumanReadable','deletedDateHumanReadable'];

    public function getCreatedDateHumanReadableAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedDateHumanReadableAttribute()
    {
        return $this->updated_at->diffForHumans(null, false, false, 4);
    }

     public function getDeletedDateHumanReadableAttribute()
    {
	    if($this->deleted_at){
	        return $this->deleted_at->diffForHumans(null, false, false, 4);
        }
    }

    public function getCreatedTimeAttribute()
    {
        return $this->created_at->format('M jS\\, Y h:i:s A');
    }

    public function getUpdatedTimeAttribute()
    {
        return $this->updated_at->format('M jS\\, Y h:i:s A');
    }

    public function getRejectedTimeAttribute()
    {
	    if($this->deleted_at){
	        return $this->deleted_at->format('M jS\\, Y h:i:s A');
	    }
    }

    public function getModeratorTimeAttribute()
    {
        $from = Carbon::parse($this->updated_at);
	    $to = Carbon::parse($this->created_at);
	    return $to->diffForHumans($from, true, false, 3);
    }

    public function getModeratorDeletedTimeAttribute()
    {
        $from = Carbon::parse($this->deleted_at);
	    $to = Carbon::parse($this->created_at);
	    if($this->deleted_at){
		    return $to->diffForHumans($from, true, false, 3);
	    }
    }


    public function uploads()
    {
        return $this->belongsTo('App\Models\Files', 'file_id', 'id');
    }

     public function gifts()
    {
        return $this->belongsTo('App\Models\Winners', 'participant_id', 'participant_id');
    }

    public function participant()
    {
        return $this->belongsTo('App\Models\Participant', 'participant_id', 'id');
    }

    public function winner()
    {
        return $this->belongsTo('App\Models\Winners', 'id', 'participant_id');
    }

    public function moderator_duplicated()
    {
        return $this->belongsTo('App\Models\User', 'duplicate_by', 'id');
    }

    public function moderator_accepted()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }
    public function moderator_rejected()
    {
        return $this->belongsTo('App\Models\User', 'rejected_by', 'id');
    }
}