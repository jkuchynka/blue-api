<?php

namespace Base\Tests;

use Illuminate\Container\Container;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Base\Http\Controller;
use Base\Modules\ModulesService;
use Base\Providers\ModuleServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $loadModules = [];

    /**
     * Runs before each test
     * @return void
     */
    protected function beforeTest()
    {

    }

    /**
     * Runs before each test
     * @return void
     */
    protected function setUp(): void
    {
        // Only load specific modules before app is setup,
        // otherwise tests will use normal app config
        if ( ! empty($this->loadModules)) {
            ModulesService::setEnabledModules($this->loadModules);
        }
        parent::setUp();
        $this->beforeTest();

    }

    /**
     * Assert that the controller provides and matches allowed filters
     * for the index query
     *
     * @param array $filters
     * @param Base\Http\Controller $controller
     * @return $this
     */
    public function assertControllerHasFilters(array $filters, Controller $controller)
    {
        $this->assertEquals($filters, $controller->filters());

        return $this;
    }

    /**
     * Assert that the controller provides and matches the
     * correct validation rules for store method.
     *
     * @param array $rules
     * @param Base\Http\Controller $controller
     * @return $this
     */
    public function assertControllerHasStoreRules(array $rules, Controller $controller)
    {
        $this->assertEquals($rules, $controller->rules());

        return $this;
    }

    /**
     * Assert that the controller provides and matches the
     * correct validation rules for update method.
     *
     * @param array $rules
     * @param Base\Http\Controller $controller
     * @return $this
     */
    public function assertControllerHasUpdateRules(array $rules, Controller $controller)
    {
        $this->assertEquals($rules, $controller->rules(true));

        return $this;
    }

    /**
     * Assert that the controller provides and matches allowed sorts
     * for the index query
     *
     * @param array $sorts
     * @param Base\Http\Controller @controller
     * @return $this
     */
    public function assertControllerHasSorts(array $sorts, Controller $controller)
    {
        $this->assertEquals($this->sorts(), $this->getController()->sorts());

        return $this;
    }

    /**
     * Assert that the index api call is successful and returns
     * the correct response
     *
     * @param  string $route
     * @param  string $modelClass
     * @param  array  $responseFields
     * @return $this
     */
    public function assertApiIndex(string $route, string $modelClass, array $responseFields)
    {
        $num = 3;
        $route = route($route);

        $records = factory($modelClass, $num)->create();
        $response = $this->json('get', $route);
        $response
            ->assertStatus(200)
            ->assertJsonPath('total', $num)
            ->assertJsonStructure([
                'data' => [
                    $responseFields
                ]
            ]);
        $this->assertCount($num, $response->json()['data']);

        return $this;
    }

    public function assertApiIndexFilters(string $route, string $modelClass, Controller $controller)
    {
        $num = 3;
        $route = route($route);

        $records = factory($modelClass, $num)->create();
        $filters = $controller->filters();
        foreach ($filters as $filter) {
            $value = $records[0]->$filter;
            $filterRoute = $route . '?filter[' . $filter . ']=' . $value;
            $response = $this->json('get', $filterRoute);
            $response
                ->assertStatus(200)
                ->assertJsonPath('data.0.id', $records[0]->id);
        }

        return $this;
    }

    public function assertApiIndexSearches(string $route, string $modelClass, Controller $controller)
    {
        $num = 3;
        $route = route($route);

        $records = factory($modelClass, $num)->create();
        $filters = $controller->filters();
        // @todo: Get all keys from search all filter
        $this->assertTrue(true);

        return $this;
    }

    public function assertApiIndexSorts(string $route, string $modelClass, Controller $controller)
    {
        // @todo: Implement
        $this->assertTrue(true);
    }

    public function assertApiIndexPaginates(string $route, string $modelClass, Controller $controller)
    {
        // @todo: Implement
        $this->assertTrue(true);
    }

    /**
     * Assert that the store api returns a validation
     * errors response with an invalid field.
     *
     * @param string $route
     * @param string $invalidField
     * @param string $modelClass
     * @return $this
     */
    public function assertApiStoreValidates(string $route, string $invalidField, string $modelClass)
    {
        $route = route($route);

        $inputRecord = factory($modelClass)->make([
            $invalidField => ''
        ]);
        $response = $this->json('post', $route, $inputRecord->toArray());
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([$invalidField]);

        return $this;
    }

    /**
     * Assert that the store api successfully creates record, and
     * returns the correct response
     *
     * @param  string $route
     * @param  string $modelClass
     * @param  array  $responseFields
     * @return $this
     */
    public function assertApiStoreSuccess(string $route, string $modelClass, array $responseFields)
    {
        $route = route($route);

        $inputRecord = factory($modelClass)->make();
        $response = $this->json('post', $route, $inputRecord->toArray());
        $response
            ->assertStatus(200)
            ->assertJsonStructure($responseFields);

        return $this;
    }

    /**
     * Assert that the show api successfully returns the correct response
     *
     * @param  string $route
     * @param  string $modelClass
     * @param  array  $responseFields
     * @return $this
     */
    public function assertApiShow(string $route, string $modelClass, array $responseFields)
    {
        $record = factory($modelClass)->create();
        $parts = explode('\\', $modelClass);
        $param = strtolower(array_pop($parts));
        $route = route($route, [
            $param => $record->id
        ]);
        $response = $this->json('get', $route);
        $response
            ->assertStatus(200)
            ->assertJsonStructure($responseFields);

        return $this;
    }

    /**
     * Assert that the show api returns 404 when record not found.
     *
     * @param  string $route
     * @param  string $modelClass
     * @return $this
     */
    public function assertApiShow404(string $route, string $modelClass)
    {
        $parts = explode('\\', $modelClass);
        $param = strtolower(array_pop($parts));
        $route = route($route, [
            $param => 999
        ]);
        $response = $this->json('get', $route);
        $response
            ->assertStatus(404);

        return $this;
    }

    /**
     * Assert that the update api returns validation errors response
     * with an invalid field
     *
     * @param  string $route
     * @param  string $modelClass
     * @param  string $field
     * @param  string $value
     * @return $this
     */
    public function assertApiUpdateValidates(string $route, string $modelClass, string $field, string $value)
    {
        $record = factory($modelClass)->create();
        $parts = explode('\\', $modelClass);
        $param = strtolower(array_pop($parts));
        $route = route($route, [
            $param => $record->id
        ]);
        $params = $record->toArray();
        $params[$field] = $value;
        $response = $this->json('put', $route, $params);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([$field]);

        return $this;
    }

    /**
     * Assert that the update api successfully updates record
     *
     * @param  string $route
     * @param  string $moduleClass
     * @param  string $field
     * @param  string $value
     * @return $this
     */
    public function assertApiUpdateSuccess(string $route, string $modelClass, string $field, string $value)
    {
        $record = factory($modelClass)->create();
        $parts = explode('\\', $modelClass);
        $param = strtolower(array_pop($parts));
        $route = route($route, [
            $param => $record->id
        ]);
        $params = $record->toArray();
        $params[$field] = $value;
        $response = $this->putJson($route, $params);
        $response
            ->assertStatus(200)
            ->assertJsonPath($field, $value);

        return $this;
    }

    /**
     * Assert that the delete api deletes record
     *
     * @param  string $route
     * @param  string $modelClass
     * @return $this
     */
    public function assertApiDestroySuccess(string $route, string $modelClass)
    {
        $record = factory($modelClass)->create();
        $parts = explode('\\', $modelClass);
        $param = strtolower(array_pop($parts));
        $route = route($route, [
            $param => $record->id
        ]);
        $response = $this->json('delete', $route, [
            'params' => [
                $param => $record->id
            ]
        ]);
        $response
            ->assertStatus(200);

        $this->assertEquals(0, $modelClass::count());

        return $this;
    }
}
