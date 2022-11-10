<x-layout>

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <div class="flex flex-wrap gap-4">
                @foreach($categories as $category)
                    <a
                        class="bg-gray-100 rounded-md overflow-hidden flex items-center hover:bg-gray-200 hover:shadow"
                        href="{{ route('categories.show', $category) }}">
                        <img
                            class="w-8 h-8"
                            src="{{ $category->logo }}" alt="{{ $category->name }}'s logo">
                        <span
                            class="min-w-[60px] px-2 flex-1 text-center font-medium text-gray-700 text-sm">{{ $category->name }}</span>
                    </a>
                @endforeach
                @can('create', \App\Models\Category::class)
                    <a
                        class="px-2 bg-gray-100 rounded-md overflow-hidden flex items-center hover:bg-gray-200 hover:shadow"
                        href="{{ route('categories.create') }}">
                        <x-heroicon-o-plus class="w-4 h-4 text-gray-700"/>
                        <span
                            class="pr-2 flex-1 text-center font-medium text-gray-700 text-sm">添加分类</span>
                    </a>
                @endcan
            </div>
        </div>

        <div class="mt-4 bg-white rounded shadow p-4">
            @foreach($topics as $topic)
                <div class="flex items-center pb-2 mb-2 border-b">
                    <a class="mr-2"
                       href="{{ route('users.show', $topic->author) }}">
                        <img
                            class="w-10 h-10 p-px"
                            src="{{ $topic->author->avatar }}" alt="{{ $topic->author->username }}'s avatar">
                    </a>
                    <a class="mr-1"
                       href="{{ route('categories.show', $topic->category) }}">
                        <img
                            class="w-4 h-4"
                            src="{{ $topic->category->logo }}" alt="{{ $topic->category->name }}'s logo">
                    </a>
                    <a class="text-gray-700 hover:text-gray-900"
                       href="{{ route('topics.show', $topic) }}">
                        {{ $topic->title }}
                    </a>
                    <span
                        class="ml-auto min-w-[24px] text-sm text-gray-400 flex items-center justify-between">
                        <x-heroicon-o-heart class="w-3 h-3 mr-0.5"/>
                        <span>{{ $topic->likes->count() }}</span>
                    </span>
                    <time
                        class="hidden sm:block text-gray-400 text-sm ml-2 pl-2 relative before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-px before:h-1/2 before:bg-gray-400/50"
                        datetime="{{ $topic->updated_at }}">{{ $topic->updated_at->diffForHumans() }}</time>
                </div>
            @endforeach

            @if($topics->hasPages())
                <div class="mt-4">
                    {{ $topics->links() }}
                </div>
            @endif
        </div>
    </div>

</x-layout>
