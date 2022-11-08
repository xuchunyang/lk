<!DOCTYPE html>
<html lang="zh">
@props([
    /** @var string $title */
    'title' => 'LK',
])
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
</head>
<body class="font-sans text-gray-900 antialiased">

<header class="container mx-auto p-4">
    <div>
        <h2 class="font-bold">Category</h2>
        <ul class="pl-4 list-disc">
            <li><a href="{{ route('categories.index') }}">Index</a></li>
        </ul>
        @auth
            <a href="{{ route('users.edit', Auth::user()) }}">
                {{ Auth::user()->username }}
            </a>
            <a href="{{ route('users.notifications') }}">
                {{ Auth::user()->unreadNotifications->count() }}
                notifications
            </a>
            <form action="{{ route('users.signout') }}" method="post">
                @csrf
                <button type="submit">Sign out</button>
            </form>
        @else
            <a href="{{ route('users.signup') }}">Sign up</a>
            <a href="{{ route('users.signin') }}">Sign in</a>
        @endauth
    </div>
</header>

@if(session('success'))
    <div class="container mx-auto p-4">
        <div class="p-4 bg-green-50 text-green-600">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="container mx-auto p-4">
        <div class="p-4 bg-rose-50 text-rose-600">
            <p class="font-bold mb-2">Oops, something is wrong!</p>
            <ul class="pl-4 list-disc">
                @foreach($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{ $slot }}

</body>
</html>
