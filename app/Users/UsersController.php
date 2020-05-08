<?php

namespace App\Users;

use App\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Base\Http\Filters\FiltersAll;
use App\Auth\Mail\Verify;

class UsersController extends \Base\Http\Controller
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
            'name' => 'required'
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
            'name',
            'email'
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
            'name',
            'email'
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
        $results = QueryBuilder::for(User::class)
            ->allowedFilters($filters)
            ->allowedSorts($this->sorts())
            ->jsonPaginate();
        return $results;
    }

    /**
     * Create a new user, emailing them a verification email.
     * Upon verification, they can set their password and login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
        $record = new User;
        $record->fill($request->all());

        // Create a random password.
        $record->password = bcrypt(Str::random(10));
        $record->save();

        Mail::to([
            ['email' => $record->email, 'name' => $record->name]
        ])->send(new Verify($record));
        return response()->json($record);
    }

    /**
     * Return a user
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $record = $user;
        return $record;
    }

    /**
     * Update a user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate($this->rules(true));
        $record = $user;
        $record->fill($request->all());
        $record->save();
        return response()->json($record);
    }

    /**
     * Delete a user
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $record = $user;
        $record->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted.'
        ]);
    }

    /**
     * Delete users
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required|array'
        ]);
        foreach ($request->ids as $id) {
            $record = User::findOrFail($id);
            $record->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Users deleted.'
        ]);
    }
}
