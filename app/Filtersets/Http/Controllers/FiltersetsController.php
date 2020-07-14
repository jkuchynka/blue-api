<?php

namespace App\Filtersets\Http\Controllers;

use App\Filtersets\Http\Requests\FiltersetStoreRequest;
use App\Filtersets\Http\Resources\FiltersetResource;
use App\Filtersets\Models\Filterset;
use Base\Http\Controller;
use Base\Http\Filters\FiltersAll;
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

        $filterset->filters()->createMany($data['filters']);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->rules(true));
        $record = Model::findOrFail($id);
        $record->fill($request->all());
        $record->save();
        return response()->json($record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Model::findOrFail($id);
        $record->delete();
        return response()->json([
            'success' => true,
            'message' => 'Record deleted.'
        ]);
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
