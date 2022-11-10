<x-layout title="我的提醒">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <div class="mb-4 flex justify-between">
                <h1 class="font-medium text-lg">
                    我的提醒
                </h1>

                <form action="{{ route('users.notifications.read-all') }}" method="post">
                    @csrf
                    <button
                        class="block px-2 py-1 text-xs text-gray-600 rounded hover:bg-gray-100"
                        type="submit">
                        Mark all as read
                    </button>
                </form>
            </div>


            <ul class="text">
                @foreach(Auth::user()->notifications as $notification)
                    <li class="p-4 first:border-t border-b group {{ $notification->read_at ? 'bg-gray-100' : '' }}">
                        <div class="flex">
                            <div>
                                @if($notification->type === \App\Notifications\Liked::class)
                                    @php
                                        $like = $notification->data;
                                    @endphp
                                    <a href="{{ route('users.show', $like['lover']['id']) }}"
                                       class="font-medium">
                                        {{ $like['lover']['username'] }}
                                    </a>
                                    @if($like['likeable_type'] === \App\Models\Topic::class)
                                        @php
                                            $topic = $like['likeable'];
                                        @endphp
                                        赞了你的话题
                                        <a href="{{ route('topics.show', $topic['id']) }}"
                                           class="font-medium">{{ $topic['title'] }}</a>
                                    @else
                                        @php
                                            $comment = $like['likeable'];
                                        @endphp
                                        赞了你的评论
                                        {{-- FIXME 如果评论分页了，怎么办？ 方法一：那就不分页了 --}}
                                        <a href="{{ route('topics.show', $comment['topic_id']) }}#comment-{{$comment['id']}}"
                                           class="font-medium">{{ Str::limit($comment['content'], 50) }}</a>
                                    @endif
                                @elseif($notification->type === \App\Notifications\Replied::class)
                                    @php
                                        $comment = $notification->data;
                                    @endphp
                                    <a href="{{ route('users.show', $comment['author']['id']) }}"
                                       class="font-medium">
                                        {{ $comment['author']['username'] }}
                                    </a>
                                    @if($comment['parent'] !== null)
                                        回复了你的评论
                                        <a href="{{ route('topics.show', $comment['topic_id']) }}#comment-{{$comment['id']}}"
                                           class="font-medium">
                                            {{ Str::limit($comment['parent']['content'], 50) }}
                                        </a>
                                    @else
                                        回复了你的主题
                                        <a href="{{ route('topics.show', $comment['topic_id']) }}#comment-{{$comment['id']}}"
                                           class="font-medium">
                                            {{ $comment['topic']['title'] }}
                                        </a>
                                    @endif
                                    <p class="py-2">
                                        {{ Str::limit($comment['content'], 50) }}
                                    </p>
                                @endif
                            </div>
                            <div class="hidden sm:block sm:ml-auto">
                                <span class="text-xs text-gray-600 flex items-center space-x-0.5">
                                    <x-heroicon-o-clock class="w-3 h-3"/>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('users.notifications.read', $notification) }}" method="post"
                              class="invisible group-hover:visible">
                            @csrf
                            <input type="hidden" name="id" value="{{ $notification->id }}">
                            @php
                                /** @var \Illuminate\Notifications\DatabaseNotification $note */
                                $note = $notification;
                            @endphp
                            <button type="submit"
                                    class="mt-1 p-1 rounded text-xs text-gray-600 hover:bg-gray-200"
                            >{{ $note->read_at ? 'Mark as unread' : 'Mark as read' }}</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</x-layout>
