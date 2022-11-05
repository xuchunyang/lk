<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class TopicController extends Controller
{
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
        $topic = $category->topics()->create($request->validated());

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
        $topic->query()->increment('views');
        return view('topic.show', [
            'topic' => $topic,
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
}
