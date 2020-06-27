<?php

namespace Base\Http\Support;

class Http
{
    /**
     * Map of key and alias to filter
     *
     * @var array
     */
    private static $filterMap;

    /**
     * Get filter types
     * key is used in http query params
     * alias is shorthand syntax
     *
     * @return array
     */
    public static function filters()
    {
        return [
            [
                'key' => 'eq',
                'alias' => '=',
                'description' => 'Equals'
            ],
            [
                'key' => 'gt',
                'alias' => '>',
                'description' => 'Greater than'
            ],
            [
                'key' => 'gte',
                'alias' => '>=',
                'description' => 'Greater than or equal'
            ],
            [
                'key' => 'lt',
                'alias' => '<',
                'description' => 'Less than'
            ],
            [
                'key' => 'lte',
                'alias' => '<=',
                'description' => 'Less than or equal'
            ],
            [
                'key' => 'like',
                'alias' => '*',
                'description' => 'Fuzzy search'
            ],
            [
                'key' => 'has',
                'alias' => '!',
                'description' => 'Has value'
            ]
        ];
    }

    /**
     * Get a filter by internal type definition or alias
     *
     * @param string $typeOrAlias
     * @return array|null
     */
    public static function getFilter($typeOrAlias)
    {
        $filterMap = static::getFilterMap();
        return isset($filterMap[$typeOrAlias]) ?
            $filterMap[$typeOrAlias] :
            null;
    }

    /**
     * Get filters keyed by key and alias
     *
     * @return array
     */
    public static function getFilterMap()
    {
        if (! static::$filterMap) {
            foreach (static::filters() as $filter) {
                static::$filterMap[$filter['key']] = $filter;
                static::$filterMap[$filter['alias']] = $filter;
            }
        }
        return static::$filterMap;
    }
}
