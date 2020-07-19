<?php

namespace App\Users\Http\Controllers;

use App\Auth\Mail\VerifyEmail;
use App\Users\Http\Queries\UserQuery;
use App\Users\Http\Requests\UserDestroyManyRequest;
use App\Users\Http\Requests\UserStoreRequest;
use App\Users\Http\Requests\UserUpdateRequest;
use App\Users\Http\Resources\UserResource;
use App\Users\Models\User;
use Base\Http\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Mail;
use Str;

/**
 * Users management
 *
 * @group Users
 * @authenticated
 */
class UserController extends Controller
{
    /**
     * Get users
     *
     * @queryBuilder App\Users\Http\Queries\UserQuery
     * @paginates
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(
            UserQuery::for(User::class)->jsonPaginate()
        );
    }

    /**
     * Create a user
     * Used outside of registration process, such as by an admin.
     * Sends user a verification email.
     *
     * @usesModel User
     *
     * @param UserStoreRequest $request
     * @return UserResource
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $user = new User;
        $user->fill($data);

        // Create a random password.
        $user->password = bcrypt(Str::random(10));
        $user->save();

        Mail::to([
            ['email' => $user->email, 'name' => $user->name]
        ])->send(new VerifyEmail($user));

        return new UserResource($user);
    }

    /**
     * Get a user
     *
     * @urlParam user required The user id
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        $user->load('roles');
        return new UserResource($user);
    }

    /**
     * Update a user
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }
        $user->load('roles');
        return new UserResource($user);
    }

    /**
     * Delete a user
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted.'
        ], 204);
    }

    /**
     * Delete users
     *
     * @param UserDestroyManyRequest $request
     * @return JsonResponse
     */
    public function destroyMany(UserDestroyManyRequest $request)
    {
        $data = $request->validated();
        foreach ($data->ids as $id) {
            $user = User::findOrFail($id);
            $user->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'UserResource deleted.'
        ], 204);
    }
}
