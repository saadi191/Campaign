<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeafletsRange extends Model
{

    protected $table = 'leaflets_range';
    public $timestamps = true;
    protected $fillable = array('from', 'to');

    protected $dates = ['created_at','updated_at'];
}