<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $search_string = $request->input('s');

        return Event::where('title', 'like', "%$search_string%")->get();
    }

    public function autocomplit(Request $request)
    {
        $search_string = $request->input('s');

        return Event::select('title')->where('title', 'like', "%$search_string%")->get();
    }
}
