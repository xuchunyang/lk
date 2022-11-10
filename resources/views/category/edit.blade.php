<x-layout title="编辑分类" :category="$category">
    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">编辑分类</h1>
            <form action="{{ route('categories.update', $category) }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <x-form.input name="name" help="分类名称，如 Arduino" required :default="$category->name"/>
                <x-form.input name="slug" required :default="$category->slug" help="match /[a-z-]+/"/>
                <x-form.input name="title" help="分类标题，如 Arduino 中文社区" required
                              :default="$category->title"/>
                <x-form.input name="logo" type="image" help="image/*, 建议比例 1:1, max 200KB"
                              :default="$category->logo"/>
                <x-form.input name="color" type="color" help="分类主题色" :default="$category->color"/>
                <x-form.input name="description" type="markdown" help="分类一句话介绍" required
                              :default="$category->description"/>
                <x-form.submit/>
            </form>
        </div>
    </div>
</x-layout>
