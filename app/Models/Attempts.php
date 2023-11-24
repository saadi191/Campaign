<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attempts extends Model
{

    protected $table = 'attempts';
    protected $fillable = array('mobile', 'attempts');
    public $timestamps = true;

}