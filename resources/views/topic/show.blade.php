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

                    <x-markdown-rendered-with-prose :markdown="$topic->content"/>
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
                                    $liked = $topic->likes()->where('lover_id', Auth::user()->id)->exists();
                                @endphp
                                <button
                                    title="{{ $liked ? '你已喜欢，点击取消喜欢' : '喜欢' }}"
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

                        <p class="mr-2">{{ $topic->likes->count() }} 人喜欢</p>

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

                <div class="mt-4 bg-white rounded shadow p-4 lg:p-8">
                    <h2 class="my-4 font-bold text-lg">Comments</h2>
                    <ul class="pl-4 list-decimal space-y-2">
                        @foreach($topic->comments as $comment)
                            <li id="comment-{{ $comment->id }}">
                                <article class="prose">
                                    <x-markdown>{!! $comment->content !!}</x-markdown>
                                </article>
                                @can('update', $comment)
                                    <a href="{{ route('comments.edit', $comment) }}">Edit</a>
                                @endcan
                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form>
                                @endcan
                                <span>{{ $comment->likes()->count() }} likes</span>

                                @can('like')
                                    <form action="{{ route('comments.like', $comment) }}" method="post">
                                        @csrf
                                        <button
                                            type="submit">
                                            {{ $comment->likes()->where('lover_id', Auth::user()->id)->exists() ? 'Unlike' : 'Like' }}
                                        </button>
                                    </form>
                                @endcan

                                @can('create', \App\Models\Comment::class)
                                    <form action="{{ route('comments.reply', $comment) }}" method="post">
                                        @csrf
                                        <x-form.input type="markdown" name="content" required/>
                                        <x-form.submit/>
                                    </form>
                                @endcan
                            </li>
                        @endforeach
                    </ul>

                    @can('create', \App\Models\Comment::class)
                        <h2 class="py-4 font-bold text-lg">Add comment</h2>
                        <form action="{{ route('categories.topics.comments.store', [$topic->category, $topic]) }}"
                              method="post">
                            @csrf
                            <x-form.input type="markdown" name="content" required/>
                            <x-form.submit/>
                        </form>
                    @endcan
                </div>
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
