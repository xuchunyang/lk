<x-layout title="Show user profile">

    <div class="container mx-auto p-4">
        <h1>{{ $user->username }}</h1>
        <img src="{{ $user->avatar }}" alt="avatar">

        {{-- TODO: check if current user can edit the profile --}}
        <a href="{{ route('users.edit', $user) }}">Edit</a>
    </div>

</x-layout>
