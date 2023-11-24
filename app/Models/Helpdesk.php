<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Helpdesk extends Model
{
	use SoftDeletes;
    protected $table = 'helpdesk';
    public $timestamps = true;

    protected $fillable = [
        'code',  'message', 'participant_id','image','type','ext'
    ];
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

		public function participant() {
				 return $this->belongsTo('App\Models\Participant', 'participant_id', 'id');
		}

		public function leaflet() {
				 return $this->belongsTo('App\Models\Leaflets', 'code', 'code');
		}

		public static $image_ext = ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'BMP', 'bmp'];

    /**
     * Get maximum file size
     * @return int maximum file size in kilobites
     */
    public static function getMaxSize()
    {
        return (int)ini_get('upload_max_filesize') * 340000;
    }
    /**
     * Get all extensions
     * @return array Extensions of all file types
     */
    public static function getAllExtensions()
    {
        $merged_arr = array_merge(self::$image_ext);
        return implode(',', $merged_arr);
    }
    /**
     * Get type by extension
     * @param  string $ext Specific extension
     * @return string      Type
     */
    public function getType($ext)
    {
        if (in_array($ext, self::$image_ext)) {
            return 'image';
        }
    }

    /**
     * Get file name and path to the file
     * @param  string $type      File type
     * @param  string $name      File name
     * @param  string $extension File extension
     * @return string            File name with the path
     */
    public function getName($type, $name, $extension)
    {
        return '/uploaded/' . $type . '/' . $name . '.' . $extension;
    }
    /**
     * Upload file to the server
     * @param  string $type      File type
     * @param  object $file      Uploaded file from request
     * @param  string $name      File name
     * @param  string $extension File extension
     * @return string|boolean    String if file successfully uploaded, otherwise - false
     */
    public function upload($type, $file, $name, $extension)
    {
        $path = '/uploaded/' . $type . '/';
        $full_name = $name . '.' . $extension;
        return Storage::putFileAs($path, $file, $full_name);
    }


}
