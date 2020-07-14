<?php

namespace App\Filtersets\Models;

use App\Filtersets\Models\FiltersetFilter;
use Base\Model;

class Filterset extends Model
{
    protected $fillable = [
        'name', 'group'
    ];

    public static function fields()
    {
        return [
            'id' => 'id',
            'name' => 'string|required|max:20',
            'group' => 'string|required|max:32',
            'user_id' => 'integer',
            'timestamps' => 'timestamps'
        ];
    }

    public function filters()
    {
        return $this->hasMany(FiltersetFilter::class);
    }
}
