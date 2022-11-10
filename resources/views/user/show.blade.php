<x-layout title="{{ $user->username }}">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">{{ $user->username }}</h1>

            <img src="{{ $user->avatar }}" alt="{{ $user->username }}'s avatar">

            @if($user->description)
                <x-markdown-rendered-with-prose markdown="{{ $user->description }}"/>
            @endif

            @can('update', $user)
                <div class="mt-4">
                    <a
                        class="text-sm hover:underline"
                        href="{{ route('users.edit', $user) }}">编辑个人信息</a>
                </div>
            @endcan
        </div>
    </div>

</x-layout>
