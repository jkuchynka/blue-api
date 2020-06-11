<?php

namespace Base\Traits;

trait DefinesFields
{
    /**
     * Define model fields:
     * Type (should be first entry)
     * Column modifiers (for migrations)
     * Validation
     *
     * These can then be used by migrations, api validation,
     * front-end validation and api documentation
     *
     * Example:
     *
     * 'email' => 'string|default:no_email|email|required'
     *
     * @return array
     */
    abstract static public function fields();
}
