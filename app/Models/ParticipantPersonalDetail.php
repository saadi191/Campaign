<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipantPersonalDetail extends Model
{

	use SoftDeletes;

    protected $table = 'participant_personal_detail';
    public $timestamps = true;
    protected $fillable = array('participant_id', 'first_name', 'middle_name', 'last_name', 'city', 'locale');

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $appends = ['createdDateHumanReadable','updatedDateHumanReadable'];

    public function getCreatedDateHumanReadableAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedDateHumanReadableAttribute()
    {
        return $this->updated_at->diffForHumans();
    }
}