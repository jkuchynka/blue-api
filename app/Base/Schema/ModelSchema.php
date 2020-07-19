<?php

namespace Base\Schema;

use Illuminate\Database\Eloquent\Model;

class ModelSchema
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var array
     */
    protected $fields;

    /**
     * Create a new ModelSchema
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get the fields schema
     *
     * @return array
     */
    public function fields()
    {
        if (! $this->fields) {
            foreach ($this->model->fields() as $name => $definition) {
                $field = new Field($this->model, $name, $definition);
                $this->fields[$name] = $field->schema();
            }
        }
        return $this->fields;
    }

    /**
     * Get the model schema
     *
     * @return array
     */
    public function schema()
    {
        return [
            'name' => $this->model->label(),
            'fields' => $this->fields()
        ];
    }
}
