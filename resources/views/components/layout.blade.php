<!DOCTYPE html>
<html lang="zh">
@props([
    /** @var string $title */
    'title' => 'LK',
    /** @var ?\App\Models\Category $category */
    'category' => null,
])
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($category)
        <x-category.meta :category="$category"/>
    @endif
    <title>{{ $title }}</title>
</head>
<body class="font-sans bg-[#f0f2f5] text-gray-900 antialiased">

<header class="border-t-4 border-t-emerald-400 border-b border-b-[#d3e0e9] shadow-sm bg-white"
        @if($category) style="border-top-color: {{ $category->color }}" @endif>
    <div class="container mx-auto">
        <nav class="flex font-medium text-sm text-gray-700">
            @if($category)
                <a href="{{ route('categories.show', $category) }}"
                   class="mr-4 p-3 flex items-center space-x-2 hover:bg-gray-100">
                    <img class="w-6 h-6 rounded-sm" src="{{ $category->logo }}" alt="logo">
                    <span>{{ $category->name }}</span>
                </a>
            @endif
            <a href="/"
               class="p-3 flex items-center space-x-2 hover:bg-gray-100">
                <x-heroicon-o-home class="w-6 h-6"/>
                <span>Home</span>
            </a>
            @auth
                <a href="{{ route('users.notifications') }}"
                   class="ml-auto mr-4 p-3 flex items-center space-x-2 hover:bg-gray-100">
                    @if(Auth::user()->unreadNotifications->isEmpty())
                        <x-heroicon-o-bell-snooze class="w-6 h-6"/>
                    @else
                        <x-heroicon-o-bell-alert class="w-6 h-6"/>
                    @endif
                    <span>{{ Auth::user()->unreadNotifications->count() }}</span>
                </a>
                <a href="{{ route('users.edit', Auth::user()) }}"
                   class="p-3 flex items-center space-x-2 hover:bg-gray-100">
                    <img class="rounded-full w-6 h-6" src="{{ Auth::user()->avatar }}" alt="avatar">
                    <span>{{ Auth::user()->username }}</span>
                </a>
            @else
                <a href="{{ route('users.signup') }}"
                   class="ml-auto mr-4 p-3 flex items-center space-x-2 hover:bg-gray-100">
                    <x-heroicon-o-user-plus class="w-6 h-6"/>
                    <span>Sign up</span>
                </a>
                <a href="{{ route('users.signin') }}"
                   class="p-3 flex items-center space-x-2 hover:bg-gray-100">
                    <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6"/>
                    <span>Sign in</span>
                </a>
            @endauth
        </nav>
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
