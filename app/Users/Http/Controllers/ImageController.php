<?php

namespace App\Users\Http\Controllers;

use App\Files\Factories\ImageFactory;
use App\Users\Http\Requests\ImageStoreRequest;
use App\Users\Models\User;
use Base\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ImageController extends Controller
{
    /**
     * Store a user image
     *
     * @param ImageStoreRequest $request
     * @param User $user
     */
    public function store(ImageStoreRequest $request, User $user)
    {
        $data = $request->validated();

        /**
         * @var UploadedFile
         */
        $image = $data['image'];

        // Stores to disk, makes File model
        $factory = new ImageFactory;
        $path = 'users/'.$user->id;
        $file = $factory
            ->setMaxWidth(320)
            ->setPath($path)
            ->setUser($user)
            ->makeFromUploadedFile($image);

        // Set user image
        $user->image_id = $file->id;
        $user->save();

        return $file;
    }
}
