<?php

namespace App\Filtersets\Models;

use Base\Model;

class FiltersetFilter extends Model
{
    protected $fillable = [
        'field', 'operator', 'value', 'filterset_id'
    ];
}
