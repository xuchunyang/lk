<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Topic;
use App\Notifications\Liked;
use App\Notifications\Replied;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommentRequest $request
     * @param Category $category
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function store(StoreCommentRequest $request, Category $category, Topic $topic)
    {
        $comment = $topic->comments()->create(array_merge($request->validated(), ['author_id' => $request->user()->id]));

        if (!$request->user()->is($topic->author)) {
            $topic->author->notify(new Replied($comment));
        }

        return back()->with('success', '成功添加评论!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Comment $comment
     * @return Application|Factory|View
     */
    public function edit(Comment $comment)
    {
        return view('comment.edit', [
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request
     * @param Comment $comment
     * @return Application|\Illuminate\Routing\Redirector|RedirectResponse
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return redirect(route('topics.show', $comment->topic))->with('success', '成功更新评论!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', '成功删除评论!');
    }

    public function like(Request $request, Comment $comment)
    {
        $like = $comment->likes()->where('lover_id', $request->user()->id)->first();
        if ($like) {
            $like->delete();
            $success = 'Unliked';
        } else {
            $like = $comment->likes()->create(['lover_id' => $request->user()->id]);
            if (!$request->user()->is($comment->author)) {
                $comment->author->notify(new Liked($like));
            }
            $success = 'Liked';
        }

        return back()->with('success', $success);
    }

    public function reply(StoreCommentRequest $request, Comment $comment)
    {
        $topic = $comment->topic;
        $newComment = $topic->comments()->create(array_merge(
            $request->validated(),
            [
                'author_id' => $request->user()->id,
                'parent_id' => $comment->id,
            ]));

        if (!$request->user()->is($comment->author)) {
            $comment->author->notify(new Replied($newComment));
        }

        return back()->with('success', '成功添加评论!');
    }
}
