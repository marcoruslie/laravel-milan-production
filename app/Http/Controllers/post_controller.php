<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Nova\shift;
use Illuminate\Http\Request;

class post_controller extends Controller
{
    public function index()
    {
        $posts = User::all();
        // $result = [
        //     'NIP' => $posts->nip,
        //     'email' => $posts->email
        // ];
        return UserResource::collection($posts);
    }

    public function register()
    {
        $user = User::all();
    }
}
