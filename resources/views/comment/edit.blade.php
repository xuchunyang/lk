<x-layout title="编辑评论">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">编辑评论</h1>

            <form action="{{ route('comments.update', $comment) }}" method="post">
                @csrf
                @method('PATCH')
                <x-form.input type="markdown" name="content" default="{{ $comment->content }}" required/>
                <x-form.submit/>
            </form>
        </div>
    </div>

</x-layout>
