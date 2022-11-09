@props([
    /** @var \App\Models\Category $category */
    'category'
])

<link rel="icon" href="{{ $category->logo }}">
<meta name="theme-color" content="{{ $category->color }}">
