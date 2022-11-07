<x-layout title="Create Topic in {{ $category->title }}">

    <div class="container mx-auto p-4">
        <div class="my-4">
            <a href="{{ route('categories.show', $category) }}">Back to {{ $category->title }}</a>
        </div>

        <form action="{{ route('categories.topics.store', $category) }}" method="post">
            @csrf
            <x-form.input name="title" required/>
            <x-form.input name="content" type="markdown" required/>
            <x-form.submit/>
        </form>
    </div>

</x-layout>
