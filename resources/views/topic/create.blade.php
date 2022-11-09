<x-layout title="创建主题" :category="$category">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">创建主题</h1>

            <form action="{{ route('categories.topics.store', $category) }}" method="post">
                @csrf
                <x-form.input name="title" required/>
                <x-form.input name="content" type="markdown" required/>
                <x-form.submit/>
            </form>
        </div>
    </div>

</x-layout>
