<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class LeafletsModeration extends Model
{
	use SoftDeletes;
    protected $table = 'leaflets_moderation';
    public $timestamps = true;

    protected $fillable = [
        'leaflet_id',  'leaflet_upload', 'approved', 'approved_by', 'rejected_by','uploaded'
    ];
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

		public function leaflets() {
			 return $this->hasManyThrough('App\Models\Participant','App\Models\Leaflets', 'id', 'id', 'leaflet_id', 'participant_id');
		}



		 public function leaflet()
		{
				return $this->belongsTo('App\Models\Leaflets', 'leaflet_id', 'id');
		}

		public function upload()
	 {
			 return $this->belongsTo('App\Models\LeafletsUpload', 'leaflet_upload', 'id');
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
