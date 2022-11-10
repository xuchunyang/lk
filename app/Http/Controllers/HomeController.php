<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
            'topics' => Topic::with(['author', 'category', 'likes'])
                ->when($request->query('search'), function (Builder $builder, string $search) {
                    $builder->where('title', 'like', "%$search%");
                })
                ->latest()
                ->paginate()
                ->withQueryString(),
        ]);
    }
}
