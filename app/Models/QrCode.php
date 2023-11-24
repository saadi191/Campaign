<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $table = 'qr_codes'; // Specify the table name if it's different from the model's plural form

    protected $fillable = [
        'code', 'scanned', 'user_id', 'category_id',
    ];

}
