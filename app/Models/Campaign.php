<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{

	use SoftDeletes;

    protected $table = 'campaign';
    public $timestamps = true;
    protected $fillable = array('start', 'end');

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