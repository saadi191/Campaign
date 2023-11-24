<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Winners extends Model
{

	use SoftDeletes;

    protected $table = 'winners';
    public $timestamps = true;
    protected $fillable = array('promoter_id', 'leaflet_id', 'claim', 'verified','claimed','document_id');

    protected $dates = ['created_at','updated_at'];

    public function leaflet()
    {
        return $this->belongsTo('App\Models\Leaflets', 'leaflet_id', 'id');
    }

    public function document()
    {
        return $this->belongsTo('App\Models\Documents', 'document_id', 'id');
    }

    public function promoter()
    {
        return $this->belongsTo('App\Models\Promoter', 'promoter_id', 'id');
    }
}