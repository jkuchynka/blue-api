<?php

namespace Base\Tests\Traits;

trait ProvidesModel
{
    /**
     * Set the model under test
     *
     * @return string|Illuminate\Eloquent\Model
     */
    abstract protected function model();

    /**
     * Get the model under test
     *
     * @return Illuminate\Eloquent\Model
     */
    protected function getModel()
    {
        $model = $this->model();
        return $model;
    }
}
