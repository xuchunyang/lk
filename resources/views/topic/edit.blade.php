<x-layout title="编辑主题">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">编辑主题</h1>

            <form action="{{ route('topics.update', $topic) }}" method="post">
                @method('PATCH')
                @csrf
                <x-form.input name="title" required default="{{ $topic->title }}"/>
                <x-form.input name="content" type="markdown" required default="{{ $topic->content }}"/>
                <x-form.submit/>
            </form>
        </div>
    </div>

</x-layout>
