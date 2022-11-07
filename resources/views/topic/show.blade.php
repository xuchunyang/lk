<x-layout title="{{ $topic->title }}">
    <div class="container mx-auto p-4">

        <h1 class="mb-4 font-medium">
            Category:
            <a href="{{ route('categories.show', $topic->category) }}">{{ $topic->category->title }}</a>
        </h1>

        <h1>{{ $topic->title }}</h1>
        <p>{{ $topic->content }}</p>
        <span>{{ $topic->views }} views</span>

        <a href="{{ route('topics.edit', $topic) }}">Edit</a>

        <form action="{{ route('topics.destroy', $topic) }}" method="post">
            @csrf
            @method('DELETE')
            <input type="submit" value="Delete">
        </form>

        <h2 class="my-4 font-bold text-lg">Comments</h2>
        <ul class="pl-4 list-decimal space-y-2">
            @foreach($topic->comments as $comment)
                <li>
                    <p>{{ $comment->content }}</p>
                    <a href="{{ route('comments.edit', $comment) }}">Edit</a>
                    <form action="{{ route('comments.destroy', $comment) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <h2 class="py-4 font-bold text-lg">Add comment</h2>
        <form action="{{ route('categories.topics.comments.store', [$topic->category, $topic]) }}" method="post">
            @csrf
            <x-form.input type="textarea" name="content" required/>
            <x-form.submit/>
        </form>

    </div>
</x-layout>
