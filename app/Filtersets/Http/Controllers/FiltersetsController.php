<?php

namespace App\Filtersets\Http\Controllers;

use App\Filtersets\Http\Queries\FiltersetQuery;
use App\Filtersets\Http\Requests\FiltersetDestroyRequest;
use App\Filtersets\Http\Requests\FiltersetStoreRequest;
use App\Filtersets\Http\Requests\FiltersetUpdateRequest;
use App\Filtersets\Http\Resources\FiltersetResource;
use App\Filtersets\Models\Filterset;
use App\Filtersets\Models\FiltersetFilter;
use Base\Http\Controller;
use Base\Http\Filters\FiltersAll;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FiltersetsController extends Controller
{
    /**
     * Get allowed filters for index query
     *
     * @return array
     */
    public function filters()
    {
        return [
            'id'
        ];
    }

    /**
     * Get validation rules
     *
     * @param  bool $update For use in update method
     * @return array
     */
    public function rules(bool $update = false)
    {
        return [
            //
        ];
    }

    /**
     * Get allowed sorts for index query
     *
     * @return array
     */
    public function sorts()
    {
        return [
            'id'
        ];
    }

    /**
     * Get filtersets
     */
    public function index()
    {
        return FiltersetResource::collection(
            FiltersetQuery::for(Filterset::class)->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FiltersetStoreRequest $request
     * @return FiltersetResource
     */
    public function store(FiltersetStoreRequest $request)
    {
        $data = $request->validated();

        $filterset = new Filterset;
        $filterset->fill($data);
        $filterset->user_id = auth()->user()->id;
        $filterset->save();

        if (isset($data['filters'])) {
            $filterset->filters()->createMany($data['filters']);
        }
        $filterset->filters;

        return new FiltersetResource($filterset);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Model::findOrFail($id);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FiltersetUpdateRequest $request
     * @param Filterset $filterset
     * @return FiltersetResource
     */
    public function update(FiltersetUpdateRequest $request, Filterset $filterset)
    {
        $data = $request->validated();
        $filterset->update($data);

        if (isset($data['filters'])) {
            $ids = [];
            foreach ($filterset->filters as $filter) {
                $ids[] = $filter->id;
            }
            $existing = [];
            foreach ($data['filters'] as $filterData) {
                if (!empty($filterData['id'])) {
                    $existing[] = $filterData['id'];
                    $filter = FiltersetFilter::find($filterData['id']);
                    $filter->update($filterData);
                } else {
                    $filter = new FiltersetFilter;
                    $filter->fill($filterData);
                    $filter->filterset_id = $filterset->id;
                    $filter->save();
                }
            }
            $remove = array_diff($ids, $existing);
            FiltersetFilter::whereIn('id', $remove)->delete();
        }

        $filterset->load('filters');

        return new FiltersetResource($filterset);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FiltersetDestroyRequest $request
     * @param Filterset $filterset
     * @return JsonResponse
     */
    public function destroy(FiltersetDestroyRequest $request, Filterset $filterset)
    {
        $filterset->delete();
        return response()->json([
            'success' => true,
            'message' => 'Record deleted.'
        ], 204);
    }

    /**
     *
     * Remove the specified resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        $request->validate([
            'ids' => 'required|array'
        ]);
        foreach ($request->ids as $id) {
            $record = Model::findOrFail($id);
            $record->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Records deleted.'
        ]);
    }
}
