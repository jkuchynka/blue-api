<?php

namespace Base\Http;

use Base\Schema\ModelSchema;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Validation\Rule;

/**
 * Extends laravel's FormRequest to allow providing a model,
 * which can be used to automatically build rules
 * from the model's schema.
 */
abstract class FormRequest extends BaseFormRequest
{
    /**
     * Get the model this validates against
     *
     * @return string
     */
    abstract public function model();

    /**
     * Get the available relations
     *
     * @return array
     */
    public function relations() {
        return [];
    }

    /**
     * Get the model's rules
     *
     * @return array
     */
    protected function modelRules()
    {
        $model = $this->model();
        $model = '\\'.$model;
        $model = new $model;
        $schema = new ModelSchema($model);

        $rules = [];
        foreach ($schema->fields() as $name => $field) {
            if (! empty($field['rules_string'])) {
                $rules[$name] = explode('|', $field['rules_string']);
                foreach ($rules[$name] as $key => $rule) {
                    if (strpos($rule, 'unique') !== false) {
                        $rules[$name][$key] = Rule::unique($model->getTable());
                        // If this is update request and id is present in input
                        if ($id = $this->input('id')) {
                            $rules[$name][$key]->ignore($id);
                        }
                    } elseif (class_exists($rule)) {
                        $rules[$name][$key] = new $rule;
                    }
                }
            }
        }
        return $rules;
    }

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->relations() as $relation) {
            $rules[$relation] = 'array';
        }
        return array_merge($rules, $this->modelRules());
    }
}
