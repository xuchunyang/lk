<x-layout title="Edit Profile">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">Edit Profile</h1>

            <form action="{{ route('users.update', $user) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <x-form.input name="username" default="{{ $user->username }}" required/>
                <x-form.input name="email" default="{{ $user->email }}" type="email"/>
                <x-form.input name="new-password"
                              type="password"
                              help="Leave it empty if you do not plan to change the password."/>
                <x-form.input name="avatar"
                              type="image"
                              default="{{ $user->avatar }}"
                              help="['image', 'max:200', 'dimensions:ratio=1/1']"/>
                <x-form.submit/>
            </form>
        </div>
    </div>

</x-layout>
