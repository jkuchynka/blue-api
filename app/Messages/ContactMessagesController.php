<?php

namespace App\Messages;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Base\Http\Filters\FiltersAll;
use Base\Http\Controller;
use App\Messages\ContactMessage;

class ContactMessagesController extends Controller
{
    /**
     * Get validation rules
     *
     * @param  bool $update For use in update method
     * @return array
     */
    public function rules(bool $update = false)
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ];
    }

    /**
     * Get allowed filters for index query
     *
     * @return array
     */
    public function filters()
    {
        return [
            'id',
            'email',
            'name',
            'subject',
            'message'
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
            'id',
            'email',
            'name',
            'subject'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = $this->filters();
        $filters[] = AllowedFilter::custom('all', new FiltersAll($this->filters()));
        $results = QueryBuilder::for(ContactMessage::class)
            ->allowedFilters($filters)
            ->allowedSorts($this->sorts())
            ->jsonPaginate();
        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
        $record = ContactMessage::create([
            'email' => $request->email,
            'name' => $request->name,
            'subject' => $request->subject,
            'message' => $request->message
        ]);
        return response()->json($record);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = ContactMessage::findOrFail($id);
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
        //
    }
}
