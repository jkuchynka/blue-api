<?php

namespace Base;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Base\Traits\BaseModel as BaseModelTrait;

class Model extends BaseModel
{
    use BaseModelTrait;

    protected $fillable = [
        //
    ];
}
