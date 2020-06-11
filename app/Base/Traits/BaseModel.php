<?php

namespace Base\Traits;

trait BaseModel
{
    public function label()
    {
        $parts = explode('\\', get_called_class());
        return array_pop($parts);
    }
}
