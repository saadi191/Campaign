<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Temporary extends Model
{

    protected $table = 'temporary';
    public $timestamps = false;
    protected $fillable = array('mobile', 'gift', 'week');
}