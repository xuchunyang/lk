<x-layout title="Notifications">

    <div class="container mx-auto p-4">
        <h1 class="mb-4 font-bold text-lg">Notifications</h1>

        <ul class="space-y-4">
            @foreach(Auth::user()->notifications as $notification)
                <li>
                    @if($notification->type === \App\Notifications\Liked::class)
                        @php
                            $like = $notification->data;
                        @endphp
                        <a href="{{ route('users.show', $like['lover']['id']) }}">
                            {{ $like['lover']['username'] }}
                        </a>
                        @if($like['likeable_type'] === \App\Models\Topic::class)
                            @php
                                $topic = $like['likeable'];
                            @endphp
                            赞了你的话题
                            <a href="{{ route('topics.show', $topic['id']) }}">{{ $topic['title'] }}</a>
                        @else
                            @php
                                $comment = $like['likeable'];
                            @endphp
                            赞了你的评论
                            {{-- FIXME 如果评论分页了，怎么办？ 方法一：那就不分页了 --}}
                            <a href="{{ route('topics.show', $comment['topic_id']) }}#comment-{{$comment['id']}}">{{ Str::limit($comment['content'], 50) }}</a>
                        @endif
                    @elseif($notification->type === \App\Notifications\Replied::class)
                        @php
                            $comment = $notification->data;
                        @endphp
                        <a href="{{ route('users.show', $comment['author']['id']) }}">
                            {{ $comment['author']['username'] }}
                        </a>
                        @if($comment['parent'] !== null)
                            回复了你的评论
                            {{ Str::limit($comment['parent']['content'], 50) }}
                        @else
                            评论了你的主题
                            {{ $comment['topic']['title'] }}
                        @endif
                        <a href="{{ route('topics.show', $comment['topic_id']) }}#comment-{{$comment['id']}}">{{ Str::limit($comment['content'], 50) }}</a>
                    @endif

                    <form action="{{ route('users.notifications.read', $notification) }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $notification->id }}">
                        @php
                            /** @var \Illuminate\Notifications\DatabaseNotification $note */
                            $note = $notification;
                        @endphp
                        <button type="submit">{{ $note->read_at ? 'Unread' : 'Read' }}</button>
                    </form>

                </li>
            @endforeach
        </ul>
    </div>

</x-layout>
