<?php

namespace Base\Schema;

use Illuminate\Database\Eloquent\Model;

class Field
{
    /**
     * Name of the field
     *
     * @var string
     */
    protected $name;

    /**
     * Field definition
     *
     * @var string
     */
    protected $definition;

    /**
     * Column modifier definitions
     *
     * @var array
     */
    protected $columnModifiers;

    /**
     * Field definitions
     *
     * @var array
     */
    protected $definitions;

    /**
     * Model
     *
     * @var Model
     */
    protected $model;

    /**
     * Rule definitions
     *
     * @var array
     */
    protected $rules;

    /**
     * Rules as laravel string format
     *
     * @var string
     */
    protected $rulesString;

    /**
     * Type of field
     *
     * @var string
     */
    protected $type;

    /**
     * Create a field
     *
     * @param Model $model
     * @param string $name
     * @param string $definition
     */
    public function __construct(Model $model, string $name, string $definition)
    {
        $this->model = $model;
        $this->name = $name;
        $this->definition = $definition;
        $this->parseDefinition();
    }

    /**
     * Parse definition into list of definitions
     *
     * @return void
     */
    protected function parseDefinition()
    {
        $this->definitions = [];
        $definitions = explode('|', $this->definition);
        foreach ($definitions as $definition) {
            $parts = explode(':', $definition);
            $name = array_shift($parts);
            $this->definitions[$name] = $parts;
        }
    }

    /**
     * Get the column modifiers used for migrations
     * These can be anywhere in the field definition
     *
     * @return array
     */
    public function columnModifiers()
    {
        if (! $this->columnModifiers) {
            $names = array_keys($this->definitions);
            $modifiers = $this->availableColumnModifiers();
            $this->columnModifiers = array_intersect_key($this->definitions, array_flip($modifiers));
        }
        return $this->columnModifiers;
    }

    /**
     * Get the rules used for forms and api requests
     *
     * @return array
     */
    public function rules()
    {
        if (! $this->rules) {
            $except = array_merge(
                [$this->type()],
                array_keys($this->columnModifiers())
            );
            $this->rules = array_diff_key($this->definitions, array_flip($except));
            foreach ($this->rules as $name => &$args) {
                switch ($name) {
                    case 'unique':
                        if (empty($args)) {
                            $args[0] = $this->model->getTable();
                        }
                        break;
                }
            }
        }
        return $this->rules;
    }

    /**
     * Get the rules as a string laravel format
     *
     * @return string
     */
    public function rulesString()
    {
        if (! $this->rulesString) {
            $rules = $this->rules();
            $fieldRules = [];
            foreach ($rules as $name => $args) {
                $items = array_merge([$name], $args);
                $fieldRules[] = implode(':', $items);
            }
            $this->rulesString = implode('|', $fieldRules);
        }
        return $this->rulesString;
    }

    /**
     * Get the type of field (string, integer, etc...)
     * This should always be the first entry of the field definition
     *
     * @return string
     */
    public function type()
    {
        if (! $this->type) {
            $this->type = explode('|', $this->definition)[0];
        }
        return $this->type;
    }

    /**
     * Generate a schema for this field
     *
     * @return array
     */
    public function schema()
    {
        $schema = [
            'type' => $this->type()
        ];
        if ($modifiers = $this->columnModifiers()) {
            $schema['modifiers'] = $modifiers;
        }
        if ($rules = $this->rules()) {
            $schema['rules'] = $rules;
        }
        if ($rulesString = $this->rulesString()) {
            $schema['rules_string'] = $rulesString;
        }
        return $schema;
    }

    /**
     * Definitions that should be considered column modifiers
     *
     * @return string[]
     */
    protected function availableColumnModifiers()
    {
        return [
            'after',
            'autoIncrement',
            'charset',
            'collation',
            'comment',
            'default',
            'first',
            'nullable',
            'storedAs',
            'unsigned',
            'useCurrent',
            'virtualAs',
            'generatedAs',
            'always'
        ];
    }
}
