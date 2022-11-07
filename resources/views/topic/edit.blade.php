<x-layout title="Edit topic">

    <div class="container mx-auto p-4">
        <form action="{{ route('topics.update', $topic) }}" method="post">
            @method('PATCH')
            @csrf
            <x-form.input name="title" required default="{{ $topic->title }}"/>
            <x-form.input name="content" type="markdown" required default="{{ $topic->content }}"/>
            <x-form.submit/>
        </form>
    </div>

</x-layout>
