<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function showUser($id)
    {
        return User::with('events')->find($id);
    }

}
