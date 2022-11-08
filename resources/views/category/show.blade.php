<x-layout title="{{ $category->title }}">

    <div class="container mx-auto p-4">
        <figure>
            <img src="{{ $category->logo}}">
            <figcaption>{{ $category->name }}</figcaption>
        </figure>

        @can('update', $category)
            <a href="{{ route('categories.edit', $category) }}">Edit Category</a>
        @endcan

        @can('create', \App\Models\Topic::class)
            <a href="{{ route('categories.topics.create', $category) }}">Create Topic</a>
        @endcan

        <div style="border-top-color: {{ $category->color }}" class="my-4 border-t border-t-4">
            @foreach($topics as $topic)
                <article class="mb-4 border p-2">
                    <h1 class="font-medium">{{ $topic->title }}</h1>
                    <p class="my-2">{{ $topic->content }}</p>
                    <div class="text-sm text-gray-500">
                        <span>{{ $topic->views }} views</span>
                        <a href="{{ route('topics.show', $topic) }}">View more</a>
                    </div>
                </article>
            @endforeach

            @if($topics->hasPages())
                <div class="mt-4">
                    {{ $topics->links() }}
                </div>
            @endif
        </div>
    </div>

</x-layout>
