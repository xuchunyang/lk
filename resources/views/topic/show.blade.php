<x-layout title="{{ $topic->title }}">
    <div class="container mx-auto p-4">

        <h1 class="mb-4 font-medium">
            Category:
            <a href="{{ route('categories.show', $topic->category) }}">{{ $topic->category->title }}</a>
        </h1>

        <h1>{{ $topic->title }}</h1>
        <article class="prose">
            <x-markdown>{!! $topic->content !!}</x-markdown>
        </article>

        <div class="my-4">
            <h2 class="mt-4">Liked by:</h2>
            <ul>
                @foreach($topic->likes()->with('lover')->get() as $like)
                    <li>{{ $like->lover->username }}</li>
                @endforeach
            </ul>
        </div>


        @auth
            <form action="{{ route('topics.like', $topic) }}" method="post">
                @csrf
                <button
                    type="submit">
                    {{ $topic->likes()->where('lover_id', Auth::user()->id)->exists() ? 'Unlike' : 'Like' }}
                </button>
            </form>
        @endauth


        <a href="{{ route('topics.edit', $topic) }}">Edit</a>

        <form action="{{ route('topics.destroy', $topic) }}" method="post">
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete">
        </form>

        <h2 class="my-4 font-bold text-lg">Comments</h2>
        <ul class="pl-4 list-decimal space-y-2">
            @foreach($topic->comments as $comment)
                <li id="comment-{{ $comment->id }}">
                    <article class="prose">
                        <x-markdown>{!! $comment->content !!}</x-markdown>
                    </article>
                    <a href="{{ route('comments.edit', $comment) }}">Edit</a>
                    <form action="{{ route('comments.destroy', $comment) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                    <span>{{ $comment->likes()->count() }} likes</span>
                    @auth
                        <form action="{{ route('comments.like', $comment) }}" method="post">
                            @csrf
                            <button
                                type="submit">
                                {{ $comment->likes()->where('lover_id', Auth::user()->id)->exists() ? 'Unlike' : 'Like' }}
                            </button>
                        </form>
                    @endauth
                    <form action="{{ route('comments.reply', $comment) }}" method="post">
                        @csrf
                        <x-form.input type="markdown" name="content" required/>
                        <x-form.submit/>
                    </form>
                </li>
            @endforeach
        </ul>

        <h2 class="py-4 font-bold text-lg">Add comment</h2>
        <form action="{{ route('categories.topics.comments.store', [$topic->category, $topic]) }}" method="post">
            @csrf
            <x-form.input type="markdown" name="content" required/>
            <x-form.submit/>
        </form>

    </div>
</x-layout>
