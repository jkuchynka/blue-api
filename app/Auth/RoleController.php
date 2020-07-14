<?php

namespace App\Auth;

use App\Auth\Http\Resources\RoleResource;
use App\Auth\Models\Role;
use Base\Http\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(
          Role::all()
        );
    }
}
