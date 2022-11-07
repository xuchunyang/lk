@props([
    /** @var string $name */
    'name',
    /** @var string $type */
    'type' => 'text',
    /** @var ?string $help */
    'help' => null,
    /** @var ?string $default */
    'default' => null
])

<div class="mb-4">
    @if($attributes->has('required'))
        <label
            class="block font-medium text-gray-700 relative before:content-['*'] before:absolute before:-left-0.5 before:top-px before:-translate-x-full before: before:text-rose-600"
            for="{{ $name }}">{{ \Illuminate\Support\Str::headline($name) }}</label>
    @else
        <label class="block font-medium text-gray-700"
               for="{{ $name }}">{{ \Illuminate\Support\Str::headline($name) }}</label>
    @endif

    @if($type === 'textarea')
        <textarea
            {{ $attributes->only('required') }}
            class="block w-full mt-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            id="{{ $name }}"
            name="{{ $name }}"
            rows="3">{{ old($name, $default) }}</textarea>
    @elseif($type === 'image')
        @if($default)
            <figure class="mt-1.5">
                <img src="{{ $default }}" alt="logo">
            </figure>
        @endif
        <input
            {{ $attributes->only('required') }}
            class="block w-full mt-1.5 sm:text-sm"
            id="{{ $name }}"
            name="{{ $name }}"
            type="file"
            accept="image/*">
    @elseif($type === 'password')
        <input
            {{ $attributes->only('required') }}
            class="block w-full mt-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}">
    @else
        <input
            {{ $attributes->only('required') }}
            class="block w-full mt-1.5 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ old($name, $default) }}">
    @endif

    @if($help ?? false)
        <p class="mt-1.5 text-sm text-gray-500">{{ $help }}</p>
    @endif
</div>
