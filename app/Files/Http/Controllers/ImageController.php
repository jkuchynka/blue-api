<?php

namespace App\Files\Http\Controllers;

use App\Files\Http\Requests\StoreImageRequest;
use Base\Http\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * @param StoreImageRequest $request
     */
    public function store(StoreImageRequest $request)
    {
        $data = $request->validated();

        print_r($data['image']);
        die;
    }
}
