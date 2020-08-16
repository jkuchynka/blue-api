<?php

namespace App\Files\Models;

use Base\Model;

class File extends Model
{
    protected $fillable = [
        'user_id', 'name', 'filename', 'disk', 'mime'
    ];
}
