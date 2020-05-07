<?php

namespace Base\Tests\Traits;

trait ProvidesController
{
    /**
     * Set the controller under test
     *
     * @return string|Base\Http\Controller
     */
    abstract protected function controller();

    /**
     * Get the controller under test
     *
     * @return Base\Http\Controller
     */
    protected function getController()
    {
        $controller = $this->controller();
        if (is_string($controller)) {
            return resolve($controller);
        }
        return $controller;
    }
}
