<x-layout title="{{ $topic->title }}" :category="$topic->category">
    <div class="container mx-auto p-4">

        <div class="lg:flex">
            <div class="lg:w-9/12 lg:mr-8">
                <div class="bg-white rounded shadow p-4 lg:p-8">
                    <h1 class="text-xl">{{ $topic->title }}</h1>

                    <div class="py-3.5 border-b mb-3.5 text-gray-500 text-xs flex items-center space-x-4">
                <span class="flex items-center space-x-0.5">
                    <x-heroicon-o-eye class="w-3.5 h-3.5"/>
                    <span>{{ $topic->views }}</span>
                </span>
                        <span class="flex items-center space-x-0.5">
                    <span>创建于 {{ $topic->created_at->diffForHumans() }}</span>
                </span>
                        @if($topic->is_modified)
                            <span class="flex items-center space-x-0.5">
                        <span>更新于 {{ $topic->updated_at->diffForHumans() }}</span>
                    </span>
                        @endif
                        @can('update', $topic)
                            <a class="flex items-center space-x-0.5 hover:text-blue-500"
                               href="{{ route('topics.edit', $topic) }}">
                                <x-heroicon-o-pencil-square class="w-3.5 h-3.5"/>
                                <span>编辑</span>
                            </a>
                        @endcan
                        @can('delete', $topic)
                            <form action="{{ route('topics.destroy', $topic) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="flex items-center space-x-0.5 hover:text-rose-600"
                                    type="submit">
                                    <x-heroicon-o-trash class="w-3.5 h-3.5"/>
                                    <span>删除</span>
                                </button>
                            </form>
                        @endcan
                    </div>

                    <x-markdown-rendered-with-prose :markdown="$topic->content" class="text-[15px] leading-normal"/>
                </div>

                <div class="mt-4 bg-white rounded shadow p-4 lg:p-8">
                    <figure class="flex space-x-2.5">
                        <img class="w-[50px] h-[50px] rounded shadow shadow-black/30 border border-white"
                             src="{{ $topic->author->avatar }}" alt="{{ $topic->author->username }}'s avatar">
                        <figcaption class="text-sm flex flex-col justify-center">
                            <div class="mb-1.5">
                                <a href="{{ route('users.show', $topic->author) }}"
                                   class="font-bold">
                                    {{ $topic->author->username }}
                                </a>
                            </div>
                            <p class="text-sm flex items-center space-x-1">
                                <span>暂无个人描述~</span>
                                @can('update', $topic->author)
                                    <a href="{{ route('users.edit', $topic->author) }}">
                                        <x-heroicon-o-pencil-square class="w-4 h-4"/>
                                    </a>
                                @endcan
                            </p>
                        </figcaption>
                    </figure>
                </div>

                <div class="mt-4 bg-white rounded shadow p-4 lg:p-8">
                    <div class="flex items-center">
                        @can('like')
                            <form
                                class="mr-4"
                                action="{{ route('topics.like', $topic) }}" method="post">
                                @csrf
                                @php
                                    $liked = $topic->likes->where('lover_id', Auth::user()->id)->first();
                                @endphp
                                <button
                                    title="{{ $liked ? '你已喜爱，点击取消喜爱' : '喜爱' }}"
                                    class="block"
                                    type="submit">
                                    @if($liked)
                                        <x-heroicon-s-heart class="w-6 h-6 text-pink-600"/>
                                    @else
                                        <x-heroicon-o-heart class="w-6 h-6 text-pink-600"/>
                                    @endif
                                </button>
                            </form>
                        @endcan

                        <p class="mr-2">{{ $topic->likes->count() }} 人喜爱</p>

                        @foreach($topic->likes as $like)
                            <a
                                href="{{ route('users.show', $like->lover) }}">
                                <img src="{{ $like->lover->avatar }}"
                                     alt="{{ $like->lover->username }}'s avatar"
                                     class="mr-2 rounded-full w-[34px] h-[34px] p-[3px] border border-[#ddd]">
                            </a>
                        @endforeach
                    </div>
                </div>

                <div
                    class="my-8 flex justify-center relative before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-full before:h-px before:bg-black/10">
                    <div class="flex items-center px-2 relative z-10 text-gray-600 bg-[#f0f2f5]">
                        <x-heroicon-s-chat-bubble-left-right class="w-4 h-4 mr-1"/>
                        <span class="text-sm">讨论数量：{{ $topic->comments->count() }}</span>
                    </div>
                </div>

                <div
                    class="relative before:absolute before:w-px before:h-full before:bg-black/25 before:left-4 sm:before:left-[80px]">
                    @foreach($topic->comments as $comment)
                        <div class="flex mt-6 relative z-10"
                             x-data="{ open: false }">
                            <a
                                class="hidden sm:block sm:mr-4"
                                href="{{ route('users.show', $comment->author) }}">
                                <img
                                    class="w-[50px] h-[50px] rounded shadow shadow-black/30 border border-white"
                                    src="{{ $comment->author->avatar }}"
                                    alt="{{ $comment->author->username }}'s avatar">
                            </a>
                            <div class="flex-1">
                                <div
                                    id="comment-{{ $comment->id }}"
                                    class="group bg-white rounded shadow-lg border target:ring">
                                    <div
                                        class="px-4 py-2 flex items-center sm:relative sm:before:absolute sm:before:top-1/2 sm:before:-left-px sm:before:-translate-x-full sm:before:-translate-y-1/2  sm:before:border-solid sm:before:border-t-[8px] sm:before:border-r-[8px] sm:before:border-b-[8px] sm:before:border-l-0 sm:before:border-transparent sm:before:border-r-[color:#d4dade]">
                                        <a
                                            class="text-sm font-bold"
                                            href="{{ route('users.show', $comment->author) }}">
                                            {{ $comment->author->username }}
                                        </a>
                                        <a class="ml-2 text-xs text-gray-600 hover:underline"
                                           href="#comment-{{ $comment->id }}">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </a>
                                        @if($comment->parent)
                                            <a href="{{ route('topics.show', $topic) }}#comment-{{ $comment->parent->id }}"
                                               class="ml-2 text-xs text-gray-600 hover:underline">
                                                回复给 {{ $comment->parent->author->username }}
                                            </a>
                                        @endif
                                        @can('update', $comment)
                                            <a
                                                class="ml-2 flex items-center text-xs text-gray-600 invisible group-hover:visible hover:underline"
                                                href="{{ route('comments.edit', $comment) }}">
                                                <x-heroicon-o-pencil-square class="w-3 h-3 mr-0.5"/>
                                                <span>编辑</span>
                                            </a>
                                        @endcan
                                        @can('delete', $comment)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="ml-2 flex items-center text-xs text-gray-600 invisible group-hover:visible hover:text-rose-600">
                                                    <x-heroicon-o-trash class="w-3 h-4 mr-0.5"/>
                                                    <span>删除</span>
                                                </button>
                                            </form>
                                        @endcan
                                        @can('create', \App\Models\Comment::class)
                                            <button
                                                title="回复"
                                                class="ml-auto p-0.5 invisible group-hover:visible"
                                                @click="open = true"
                                                type="button">
                                                <x-heroicon-o-arrow-uturn-left class="w-4 h-4"/>
                                            </button>
                                        @endcan
                                    </div>
                                    <div class="px-4 border-t">
                                        <x-markdown-rendered-with-prose :markdown="$comment->content" class="prose-sm"/>
                                    </div>
                                    <div class="px-4 py-2 border-t flex items-center space-x-1">
                                        @can('like')
                                            <form action="{{ route('comments.like', $comment) }}" method="post">
                                                @csrf
                                                @php
                                                    $liked = $comment->likes->where('lover_id', Auth::user()?->id)->first();
                                                @endphp
                                                <button
                                                    title="{{ $liked ? '你已喜爱，点击取消喜爱' : '喜爱' }}"
                                                    class="block"
                                                    type="submit">
                                                    @if($liked)
                                                        <x-heroicon-s-heart class="w-6 h-6 text-pink-600"/>
                                                    @else
                                                        <x-heroicon-o-heart class="w-6 h-6 text-pink-600"/>
                                                    @endif
                                                </button>
                                            </form>
                                        @else
                                            @if($comment->likes->isNotEmpty())
                                                <x-heroicon-s-heart class="w-6 h-6 text-pink-600"/>
                                            @endif
                                        @endcan
                                        @if($comment->likes->isNotEmpty())
                                            <span class="text-sm text-gray-600">{{ $comment->likes->count() }}</span>
                                        @endif
                                    </div>
                                </div>
                                @can('create', \App\Models\Comment::class)
                                    <div class="mt-2 bg-white rounded shadow p-4 lg:p-8 relative"
                                         x-show="open">
                                        <button type="button"
                                                @click="open = false"
                                                class="absolute top-4 right-4 lg:top-8 lg:right-8 p-2 rounded-full text-gray-700 hover:bg-gray-100 z-10">
                                            <x-heroicon-o-x-mark class="w-4 h-4"/>
                                        </button>
                                        <form
                                            action="{{ route('categories.topics.comments.store', [$topic->category, $topic]) }}"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <x-form.input type="markdown" name="content" required/>
                                            <x-form.submit/>
                                        </form>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>


                @can('create', \App\Models\Comment::class)
                    <div class="mt-6 bg-white rounded shadow p-4 lg:p-8 sm:ml-[calc(50px+1rem)]">
                        <form action="{{ route('categories.topics.comments.store', [$topic->category, $topic]) }}"
                              method="post">
                            @csrf
                            <x-form.input type="markdown" name="content" required/>
                            <x-form.submit/>
                        </form>
                    </div>
                @endcan
            </div>

            <div class="hidden lg:block lg:w-3/12">
                <div class="bg-white rounded shadow pb-4">
                    <figure class="flex flex-col items-center border-b">
                        <a
                            class="py-12 border-b"
                            href="{{ route('users.show', $topic->author) }}">
                            <img
                                class="w-20 h-20 rounded-full"
                                src="{{ $topic->author->avatar }}" alt="{{ $topic->author->username }}'s avatar">
                        </a>
                        <figcaption
                            class="my-2">
                            <a
                                class="text-sm hover:underline"
                                href="{{ route('users.show', $topic->author) }}">
                                {{ $topic->author->username }}
                            </a>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>


    </div>
</x-layout>
