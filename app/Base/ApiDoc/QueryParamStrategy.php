<?php

namespace Base\ApiDoc;

use Adbar\Dot;
use Base\Model;
use Base\Http\Exceptions\InvalidFilterException;
use Base\Http\Support\Http;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Mpociot\ApiDoc\Extracting\RouteDocBlocker;
use Mpociot\ApiDoc\Extracting\Strategies\Strategy;
use Mpociot\Reflection\DocBlock\Tag;
use ReflectionClass;
use ReflectionMethod;

class QueryParamStrategy extends Strategy
{
    public function __invoke(
        Route $route,
        ReflectionClass $controller,
        ReflectionMethod $method,
        array $routeRules,
        array $context = [])
    {
        $methodDocBlock = RouteDocBlocker::getDocBlocksFromRoute($route)['method'];
        $tags = $methodDocBlock->getTags();

        $params = [];
        foreach ($tags as $tag) {
            switch ($tag->getName()) {
                case 'paginates':
                    $params = array_merge($params, $this->paginationParams());
                    break;
                case 'queryBuilder':
                    $params = array_merge($params, $this->usesQueryParams($tag));
                    break;
            }
        }
        ksort($params);

        return $params;
    }

    /**
     * Get pagination params
     *
     * @return array[]
     */
    protected function paginationParams()
    {
        return [
            'page[number]' => [
                'type' => 'integer',
                'description' => 'Pagination page number',
                'required' => false,
                'value' => 1
            ],
            'page[size]' => [
                'type' => 'integer',
                'description' => 'Pagination number of results',
                'required' => false,
                'value' => 3
            ]
        ];
    }

    /**
     * Get params exposed by a QueryBuilder
     *
     * @param Tag $tag
     * @return array
     */
    protected function usesQueryParams(Tag $tag)
    {
        $params = [];
        $class = $tag->getContent();
        $query = $class::for(Model::class);

        if ($filters = $query->filters()) {
            $types = new Dot;
            $fuzzyFields = [];

            // Build array of type.key => fields
            foreach ($filters as $field => $filterTypes) {
                foreach ($filterTypes as $filterType) {
                    $filter = Http::getFilter($filterType);

                    if (! $filter) {
                        throw new InvalidFilterException('Invalid filter type: '.$filterType);
                    }

                    $types->push($filter['key'], $field);

                    if ($filter['key'] == 'like') {
                        $fuzzyFields[] = $field;
                    }
                }
            }

            foreach ($types as $type => $fields) {
                $filter = Http::getFilter($type);

                $params['filter[field:'.$filter['key'].']'] = [
                    'type' => 'string',
                    'description' => $filter['description'].' for field: <b>'.implode(', ', $fields).'</b>',
                    'required' => false,
                    'value' => null
                ];
            }

            if ($fuzzyFields) {
                $params['filter[like]'] = [
                    'type' => 'string',
                    'description' => 'Fuzzy search for fields: <b>'.implode(', ', $fuzzyFields).'</b>',
                    'required' => false,
                    'value' => null
                ];
            }
        }

        if ($includes = $query->includes()) {
            foreach ($includes as $include) {
                $params['include['.$include.']'] = [
                    'description' => 'Include relation: '.$include,
                    'required' => false,
                    'value' => $include
                ];
            }
        }

        if ($sorts = $query->sorts()) {
            $params['sort'] = [
                'description' => 'Sort by fields: ('.implode(', ', $sorts).'). Prepend with - to sort descending. Separate multiple fields with a comma.',
                'required' => false,
                'value' => null
            ];
        }

        return $params;
    }
}
