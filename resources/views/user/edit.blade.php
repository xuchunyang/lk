<x-layout title="Edit Profile">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">Edit Profile</h1>

            <form action="{{ route('users.update', $user) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <x-form.input name="username" :default="$user->username" required/>
                <x-form.input name="email" :default="$user->email" type="email"/>
                <x-form.input name="github_username" :default="$user->github_username" readonly/>
                <p class="-mt-3 mb-4">
                    <a
                        class="text-sm underline hover:text-sky-600"
                        href="{{ route('auth.github.redirect') }}">
                        {{ $user->github_username ? '重新绑定 GitHub 账号' : '绑定 GitHub 账号' }}
                    </a>
                </p>
                <x-form.input name="new-password"
                              type="password"
                              help="Leave it empty if you do not plan to change the password."/>
                <x-form.input name="avatar"
                              type="image"
                              :default="$user->avatar"
                              help="['image', 'max:200', 'dimensions:ratio=1/1']"/>
                <x-form.input name="description"
                              type="markdown"
                              :default="$user->description"/>
                <x-form.submit/>
            </form>
        </div>
    </div>

</x-layout>
