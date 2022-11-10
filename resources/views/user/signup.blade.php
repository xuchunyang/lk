<x-layout title="Sign up">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">Sign up</h1>

            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <x-form.input name="username"
                              required
                              help="['required', 'regex:/^[a-z0-9_]+$/ui', 'unique:users']"/>
                <x-form.input name="password"
                              type="password"
                              required
                              help="['required', 'confirmed', Password::min(4)]"/>
                <x-form.input name="password_confirmation" type="password" required/>
                <x-form.submit/>
            </form>
        </div>
    </div>

</x-layout>
