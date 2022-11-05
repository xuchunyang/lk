<x-layout title="Create Category">
    <div class="container mx-auto p-4">
        <h1 class="mb-4 font-medium text-lg">Create Category</h1>
        <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <x-form.input name="name" help="分类名称，如 Arduino" required/>
            <x-form.input name="slug" required help="match /[a-z-]+/"/>
            <x-form.input name="title" help="分类标题，如 Arduino 中文社区" required/>
            <x-form.input name="logo" type="image" help="image/*, 建议比例 1:1, max 200KB" required/>
            <x-form.input name="color" type="color" help="分类主题色" default="{{ fake()->hexColor() }}"/>
            <x-form.input name="description" type="textarea" help="分类一句话介绍" required/>
            <x-form.submit/>
        </form>
    </div>
</x-layout>
