@props([
    /** @var string $markdown */
    'markdown'
])

<article
    class="prose max-w-none text-[15px] leading-normal prose-h1:text-2xl prose-h2:text-xl prose-h3:text-lg prose-h4:text-base prose-h5:text-sm prose-blockquote:bg-[#f5f8fc] prose-blockquote:py-1 prose-blockquote:not-italic prose-sky prose-a:no-underline prose-img:rounded prose-img:border prose-img:shadow-lg">
    <x-markdown>{!! $markdown !!}</x-markdown>
</article>
