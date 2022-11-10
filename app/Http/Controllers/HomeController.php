<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        return view('home', [
            'categories' => Category::query()->get(),
            'topics' => Topic::with(['author', 'category', 'likes'])->latest()->paginate(),
        ]);
    }
}
