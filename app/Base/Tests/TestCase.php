<?php

namespace Base\Tests;

use Illuminate\Container\Container;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Base\Http\Controller;
use Base\Services\Modules;
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
            Modules::setEnabledModules($this->loadModules);
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
        $inputRecord = factory($modelClass)->make();
        $response = $this->json('post', $route, $inputRecord->toArray());
        $response
            ->assertStatus(200)
            ->assertJsonStructure($responseFields);
        $record = $modelClass::first();
        $fields = array_keys($inputRecord->toArray());
        foreach ($fields as $field) {
            $this->assertEquals($inputRecord->$field, $record->$field);
        }

        return $this;
    }
}
