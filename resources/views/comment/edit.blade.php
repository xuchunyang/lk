<x-layout title="Edit Comment">

    <div class="container mx-auto p-4">
        <h1 class="mb-4 text-lg font-bold">Edit Comment</h1>
        <form action="{{ route('comments.update', $comment) }}" method="post">
            @csrf
            @method('PATCH')
            <x-form.input type="markdown" name="content" default="{{ $comment->content }}" required/>
            <x-form.submit/>
        </form>
    </div>

</x-layout>
