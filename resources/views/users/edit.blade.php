<x-layout title="Edit User Profile">

    <div class="container mx-auto p-4">
        <h1 class="text-lg font-bold">Edit User Profile</h1>

        <form action="{{ route('users.update', $user) }}" method="post">
            @csrf
            @method('PATCH')
            <x-form.input name="username" default="{{ $user->username }}" required/>
            <x-form.input name="email" default="{{ $user->email }}" type="email"/>
            <x-form.input name="new-password"
                          type="password"
                          help="Leave it empty if you do not plan to change the password."/>
            <x-form.submit/>
        </form>
    </div>

</x-layout>
