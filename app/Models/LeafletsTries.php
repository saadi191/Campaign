<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class LeafletsTries extends Model
{

    use Notifiable;
    use SoftDeletes;

    protected $table = 'leaflets_tries';
    public $timestamps = true;
    protected $fillable = array('code','participant_id');

    protected $dates = ['created_at','updated_at','deleted_at'];

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


    public function participant(){
        return $this->belongsTo('App\Models\Participant', 'participant_id', 'id');
    }
}
