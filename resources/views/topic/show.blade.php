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
    </div>
</x-layout>
