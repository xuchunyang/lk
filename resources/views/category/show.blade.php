<x-layout title="{{ $category->title }}">

    <div class="container mx-auto p-4">
        @dump($category->toArray())

        <figure>
            <img src="{{ $category->logo}}">
            <figcaption>{{ $category->name }}</figcaption>
        </figure>

        <a href="{{ route('categories.edit', $category) }}">Edit Category</a>
    </div>

</x-layout>
