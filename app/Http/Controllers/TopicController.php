<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Category;
use App\Models\Topic;
use App\Notifications\Liked;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Topic::class, 'topic');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        return view('topic.create', [
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTopicRequest $request
     * @param Category $category
     * @return Application|RedirectResponse|Redirector
     */
    public function store(StoreTopicRequest $request, Category $category)
    {
        $topic = $category->topics()->create([...$request->validated(), 'author_id' => $request->user()->id]);

        return redirect(route('topics.show', $topic))
            ->with('success', '成功新建主题!');
    }

    /**
     * Display the specified resource.
     *
     * @param Topic $topic
     * @return Application|Factory|View
     */
    public function show(Topic $topic)
    {
        Model::withoutTimestamps(fn() => $topic->query()->increment('views'));
        return view('topic.show', [
            'topic' => Topic::with([
                'likes.lover',
                'comments' => [
                    'author',
                    'likes',
                ],
            ])->find($topic->id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Topic $topic
     * @return Application|Factory|View
     */
    public function edit(Topic $topic)
    {
        return view('topic.edit', [
            'topic' => $topic,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTopicRequest $request
     * @param Topic $topic
     * @return Application|Redirector|RedirectResponse
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $topic->update($request->validated());

        return redirect(route('topics.show', $topic))
            ->with('success', '成功更新主题!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Topic $topic
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect(route('categories.show', $topic->category))
            ->with('success', '成功删除主题!');
    }

    public function like(Request $request, Topic $topic)
    {
        $like = $topic->likes()->where('lover_id', $request->user()->id)->first();
        if ($like) {
            $like->delete();
            $success = 'Unliked';
        } else {
            $like = $topic->likes()->create(['lover_id' => $request->user()->id]);
            if (!$request->user()->is($topic->author)) {
                $topic->author->notify(new Liked($like));
            }
            $success = 'Liked';
        }

        return back()->with('success', $success);
    }
}
