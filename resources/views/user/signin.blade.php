<x-layout title="Sign in">

    <div class="container mx-auto p-4">
        <div class="bg-white rounded shadow p-4">
            <h1 class="mb-4 font-medium text-lg">Sign in</h1>

            <form action="{{ route('users.authenticate') }}" method="post">
                @csrf
                <x-form.input name="username" required/>
                <x-form.input name="password" type="password" required/>
                <x-form.submit/>
            </form>
        </div>
    </div>

</x-layout>
