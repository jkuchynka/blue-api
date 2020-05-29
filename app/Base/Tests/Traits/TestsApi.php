<?php

namespace Base\Tests\Traits;

use Base\Http\QueryBuilder;
use MongoDB\Driver\Query;

trait TestsApi
{
    /**
     * Get the controller under test
     *
     * @return string
     */
    abstract protected function controller();

    /**
     * Get the model under test
     *
     * @return string
     */
    abstract protected function model();

    /**
     * Get the query builder under test
     *
     * @return QueryBuilder
     */
    abstract protected function queryBuilder();

    /**
     * Get the fields that should be in CRU responses
     *
     * @return array
     */
    abstract function responseFields();

    /**
     * Get the route parameter for the model
     *
     * @return string
     */
    protected function routeParam()
    {
        $parts = explode('\\', $this->model());
        return strtolower(array_pop($parts));
    }

    /**
     * Assert that the index api call is successful and returns
     * the correct response
     *
     * @param string $route
     * @param array $responseFields
     * @return $this
     */
    public function assertApiIndex(string $route, array $responseFields = [])
    {
        $num = 3;
        $route = route($route);

        $responseFields = $responseFields ? $responseFields : $this->responseFields();

        $records = factory($this->model(), $num)->create();
        $response = $this->json('get', $route);
        $response
            ->assertStatus(200)
            ->assertJsonPath('meta.total', $num)
            ->assertJsonStructure([
                'data' => [
                    $responseFields
                ],
                'links' => [

                ],
                'meta' => [

                ]
            ]);

        $this->assertCount($num, $response->json()['data']);

        return $this;
    }

    /**
     * Assert that the index api call filters
     *
     * @param string $route
     * @return $this
     */
    public function assertApiIndexFilters(string $route)
    {
        $num = 3;
        $route = route($route);

        $records = factory($this->model(), $num)->create();
        $filters = $this->queryBuilder()->filters();
        $filters = array_filter($filters, function ($filter) {
            return is_string($filter);
        });
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

    public function assertApiIndexSearches(string $route)
    {
        $num = 3;
        $route = route($route);

        $records = factory($this->model(), $num)->create();

        // @todo: Get all keys from search all filter
        $this->assertTrue(true);

        return $this;
    }

    public function assertApiIndexSorts(string $route)
    {
        // @todo: Implement
        $this->assertTrue(true);
    }

    public function assertApiIndexPaginates(string $route)
    {
        // @todo: Implement
        $this->assertTrue(true);
    }

    /**
     * Assert that the store api successfully creates record, and
     * returns the correct response
     *
     * @param  string $route
     * @return $this
     */
    public function assertApiStoreSuccess(string $route)
    {
        $route = route($route);

        $record = factory($this->model())->make();
        $response = $this->json('post', $route, $record->toArray());
        $response
            ->assertStatus(201)
            ->assertJsonStructure(['data' => $this->responseFields()]);

        return $this;
    }

    /**
     * Assert that the show api successfully returns the correct response
     *
     * @param  string $route
     * @return $this
     */
    public function assertApiShow(string $route)
    {
        $record = factory($this->model())->create();

        $route = route($route, [
            $this->routeParam() => $record->id
        ]);

        $response = $this->json('get', $route);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data' => $this->responseFields()]);

        return $this;
    }

    /**
     * Assert that the show api returns 404 when record not found.
     *
     * @param string $route
     * @return $this
     */
    public function assertApiShow404(string $route)
    {
        $route = route($route, [
            $this->routeParam() => 999
        ]);

        $response = $this->json('get', $route);
        $response
            ->assertStatus(404);

        return $this;
    }

    /**
     * Assert that the update api successfully updates record
     *
     * @param  string $route
     * @param  string $field
     * @param  string $value
     * @return $this
     */
    public function assertApiUpdateSuccess(string $route, string $field, string $value)
    {
        $record = factory($this->model())->create();

        $route = route($route, [
            $this->routeParam() => $record->id
        ]);

        $params = $record->toArray();
        $params[$field] = $value;

        $response = $this->putJson($route, $params);
        $response
            ->assertStatus(200)
            ->assertJsonPath('data.'.$field, $value);

        return $this;
    }

    /**
     * Assert that the delete api deletes record
     *
     * @param  string $route
     * @return $this
     */
    public function assertApiDestroySuccess(string $route)
    {
        $record = factory($this->model())->create();

        $route = route($route, [
            $this->routeParam() => $record->id
        ]);

        $response = $this->json('delete', $route, [
            'params' => [
                $this->routeParam() => $record->id
            ]
        ]);
        $response
            ->assertStatus(204);

        $this->assertEquals(0, ($this->model())::count());

        return $this;
    }
}
