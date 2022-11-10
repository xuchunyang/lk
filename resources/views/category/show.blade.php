<x-layout title="{{ $category->title }}" :category="$category">

    <div class="container mx-auto p-4">
        <div class="mt-5 lg:flex">
            <div class="lg:flex-1">
                <div class="p-4 shadow rounded bg-white">
                    <ul>
                        @foreach($topics as $topic)
                            <li class="border-b border-b-black/10 py-1.5 flex">
                                <a href="{{ route('users.show', $topic->author) }}"
                                   class="">
                                    <img class="w-10 h-10 rounded p-0.5" src="{{ $topic->author->avatar }}"
                                         alt="avatar">
                                </a>

                                <a href="{{ route('topics.show', $topic) }}"
                                   class="p-1 flex-1 flex items-center justify-between text-gray-700 hover:text-gray-900 visited:text-gray-400">
                                    <h2>{{ $topic->title }}</h2>
                                    <time class="hidden sm:block text-xs text-gray-400"
                                          datetime="{{ $topic->created_at }}">{{ $topic->created_at->diffForHumans() }}</time>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    @if($topics->hasPages())
                        <div class="mt-4">
                            {{ $topics->links() }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-8 lg:w-3/12 lg:mt-0 lg:ml-4">
                <div class="shadow rounded bg-white border-t-2"
                     style="border-top-color: {{ $category->color }}">
                    <div class="border-b border-b-black/10 p-[14px] flex items-center">
                        <img class="w-6 h-6" src="{{ $category->logo }}" alt="{{ $category->name }}'s logo">
                        <h1 class="mx-2 text-sm">{{ $category->title }}</h1>
                        <span class="ml-auto"></span>
                        @can('delete', $category)
                            <form action="{{ route('categories.destroy', $category) }}" method="post"
                                  class="mr-2">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="block text-gray-500 p-1 hover:bg-gray-100 hover:text-rose-600"
                                    type="submit">
                                    <x-heroicon-o-trash class="w-4 h-4"/>
                                </button>
                            </form>
                        @endcan
                        @can('update', $category)
                            <a href="{{ route('categories.edit', $category) }}"
                               class="text-gray-500 p-1 hover:bg-gray-100">
                                <x-heroicon-o-wrench class="w-4 h-4"/>
                            </a>
                        @endcan
                    </div>
                    <article class="mx-[14px] py-px prose prose-sm prose-teal max-w-none">
                        <x-markdown>{!! $category->description !!}</x-markdown>
                    </article>
                    @can('create', \App\Models\Topic::class)
                        <div class="px-[14px] pb-4">
                            <a href="{{ route('categories.topics.create', $category) }}"
                               class="w-full border p-2 text-sm text-gray-600 flex justify-center items-center space-x-1.5 hover:border-black/50 transition">
                                <x-heroicon-o-pencil class="w-4 h-4"/>
                                <span>发布主题</span>
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

</x-layout>
