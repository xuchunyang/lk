<x-layout title="Notifications">

    <div class="container mx-auto p-4">
        <h1 class="mb-4 font-bold text-lg">Notifications</h1>

        <ul>
            @foreach(Auth::user()->notifications as $notification)
                @if($notification->type === \App\Notifications\Liked::class)
                    @php
                        $like = \App\Models\Like::find($notification->data['like_id']);
                    @endphp
                    <li>
                        <a href="{{ route('users.show', $like->lover) }}">
                            {{ $like->lover->username }}
                        </a>
                        @if($like->likeable_type === \App\Models\Topic::class)
                            赞了你的话题
                            <a href="{{ route('topics.show', $like->likeable) }}">{{ $like->likeable->title }}</a>
                        @else
                            赞了你的评论
                            {{-- FIXME 如果评论分页了，怎么办？ 方法一：那就不分页了 --}}
                            <a href="{{ route('topics.show', $like->likeable->topic) }}#comment-{{$like->likeable->id}}">{{ Str::limit($like->likeable->content, 50) }}</a>
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
                @endif
            @endforeach
        </ul>
    </div>

</x-layout>
