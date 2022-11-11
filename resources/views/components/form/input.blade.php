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
    @elseif($type === 'markdown')
        <div class="mt-1.5 border p-2" x-data="{ preview: false, html: null }">
            <nav class="flex border-b">
                <button
                    type="button"
                    class="px-4 py-1 text-sm border-b border-transparent"
                    :class="!preview && 'border-b-black/50'"
                    @click="preview = false; html = null">Write
                </button>
                <button
                    type="button"
                    class="px-4 py-1 text-sm border-b border-transparent"
                    :class="preview && 'border-b-black/50'"
                    @click="preview = true; html = $refs.content.value ? await renderMarkdown($refs.content.value) : 'Nothing to preview'">
                    Preview
                </button>
            </nav>
            <div>
                <div x-show="!preview">
                    <textarea
                        x-ref="content"
                        {{ $attributes->only('required') }}
                        class="js-markdown-editor block w-full border-0 focus:ring-stone-300 sm:text-sm"
                        id="{{ $name }}"
                        name="{{ $name }}"
                        rows="8">{{ old($name, $default) }}</textarea>
                    <p class="mt-1.5 text-sm text-gray-500">请用 Markdown 格式，可拖拽或粘贴上传图片</p>
                </div>
                <div x-show="preview" class="border px-3 py-2 min-h-[202px]">
                    <div x-show="html === null">Loading...</div>
                    <div x-show="html !== null">
                        <article x-html="html"
                                 class="prose max-w-none prose-h1:text-2xl prose-h2:text-xl prose-h3:text-lg prose-h4:text-base prose-h5:text-sm prose-blockquote:bg-[#f5f8fc] prose-blockquote:py-1 prose-blockquote:not-italic prose-sky prose-a:no-underline prose-img:rounded prose-img:border prose-img:shadow-lg"></article>
                    </div>
                </div>
            </div>
        </div>
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
            {{ $attributes->only(['required', 'readonly']) }}
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
