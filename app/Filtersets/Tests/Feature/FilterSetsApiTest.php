<?php

namespace App\Filtersets\Tests\Feature;

use App\Filtersets\Http\Controllers\FiltersetsController;
use App\Filtersets\Http\Queries\FiltersetQuery;
use App\Filtersets\Models\Filterset;
use App\Filtersets\Models\FiltersetFilter;
use Base\Tests\TestCase;
use Base\Tests\Traits\TestsApi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterSetsApiTest extends TestCase
{
    use RefreshDatabase,
        TestsApi;

    protected $loadModules = ['filtersets'];

    /**
     * Return the fields that should be in responses
     *
     * @return array
     */
    protected function responseFields()
    {
        return [
            'id',
            'name',
            'group',
            'user_id',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Return the controller under test
     *
     * @return string
     */
    protected function controller()
    {
        return FiltersetsController::class;
    }

    /**
     * Return the model under test
     *
     * @return string
     */
    protected function model()
    {
        return Filterset::class;
    }

    /**
     * Return the query builder under test
     *
     * @return FiltersetQuery
     */
    protected function queryBuilder()
    {
        return FiltersetQuery::for(Filterset::class);
    }

    protected function beforeTest()
    {
        $this->asUserByRole('admin');
    }

    /**
     * Test the basic index api
     */
    public function test_index()
    {
        $this->assertApiIndex('filtersets.index');
    }

    /**
     * Test that the index api filters correct fields
     */
    public function test_index_filters_fields()
    {
        $this->assertApiIndexFilters('filtersets.index');
    }

    /**
     * Test that the index api sorts fields
     */
    public function test_index_sorts_by_fields()
    {
        $this->assertApiIndexSorts('filtersets.index');
    }

    /**
     * Test that the store api successfully creates record.
     */
    public function test_store_success()
    {
        $this->assertApiStoreSuccess('filtersets.store');
    }

    public function test_store_filters_success()
    {
        $filterSet = factory(Filterset::class)->make();
        $filters = factory(FiltersetFilter::class, 3)->make();

        $route = route('filtersets.store');

        $data = $filterSet->toArray();
        $data['filters'] = $filters->toArray();

        $response = $this->postJson($route, $data);

        $response
            ->assertJsonCount(3, 'data.filters');
    }

    /**
     * Test that the update api successfully updates record.
     */
    public function test_update_success()
    {
        $this->assertApiUpdateSuccess('filtersets.update', 'name', 'foobar');
    }

    public function test_update_filters_success()
    {
        $filterSet = factory(Filterset::class)->create();
        $filters = factory(FiltersetFilter::class, 3)->create([
            'filterset_id' => $filterSet->id
        ]);

        $route = route('filtersets.update', [
            $this->routeParam() => $filterSet->id
        ]);

        $data = $filterSet->toArray();

        // Remove a filter, add a filter
        $newFilter = factory(FiltersetFilter::class)->make();
        $data['filters'] = [$filters[1], $filters[2], $newFilter];

        $response = $this->putJson($route, $data);

        $this->assertNull(FiltersetFilter::find($filters[0]->id));

        $response
            ->assertJsonCount(3, 'data.filters')
            ->assertJsonPath('data.filters.0.id', $filters[1]->id)
            ->assertJsonPath('data.filters.1.id', $filters[2]->id)
            ->assertJsonPath('data.filters.2.name', $newFilter->name);
    }

    /**
     * Test that the destroy api successfully deletes record.
     */
    public function test_delete_success()
    {
        $this->assertApiDestroySuccess('filtersets.destroy');
    }

    public function test_delete_filters_success()
    {
        $filterSet = factory(Filterset::class)->create();
        $filters = factory(FiltersetFilter::class, 3)->create([
            'filterset_id' => $filterSet->id
        ]);

        $route = route('filtersets.update', [
            $this->routeParam() => $filterSet->id
        ]);

        $this->deleteJson($route);
        $this->assertEquals(0, FiltersetFilter::count());
    }
}
