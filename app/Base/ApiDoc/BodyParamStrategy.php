<?php

namespace Base\ApiDoc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Mpociot\ApiDoc\Extracting\ParamHelpers;
use Mpociot\ApiDoc\Extracting\Strategies\Strategy;
use ReflectionClass;
use ReflectionMethod;

class BodyParamStrategy extends Strategy
{
    use ParamHelpers;

    public function __invoke(
        Route $route,
        ReflectionClass $controller,
        ReflectionMethod $method,
        array $routeRules,
        array $context = []
    )
    {
        foreach ($method->getParameters() as $param) {
            $paramType = $param->getType();
            if ($paramType === null) {
                continue;
            }

            $parameterClassName = $paramType->getName();

            try {
                $parameterClass = new ReflectionClass($parameterClassName);
            } catch (\ReflectionException $e) {
                continue;
            }

            // If there's a FormRequest, and no @bodyParam tags,
            // automatically build @bodyParam tags based on rules
            if ($parameterClass->isSubclassOf(FormRequest::class)) {
                $request = new $parameterClassName;
                $rules = $request->rules();
                $params = [];
                foreach ($rules as $name => $rule) {
                    $params[$name] = [
                        'type' => 'string',
                        'description' => '',
                        'required' => Str::of($rule)->contains('required'),
                        'value' => $this->generateDummyValue('string')
                    ];
                }
                return $params;
            }
        }
    }
}
