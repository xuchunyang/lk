<x-layout title="Category Index">
    <div class="container mx-auto p-4">

        @can('create', \App\Models\Category::class)
            <div class="mb-4">
                <a href="{{ route('categories.create') }}">Create Category</a>
            </div>
        @endcan


        <table class="border-collapse">
            <thead>
            <tr>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50">#</th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50">name</th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50">slug</th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50">image</th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50">color</th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50">title</th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50">description</th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50">author</th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50"></th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50"></th>
                <th class="border px-2 py-1 font-normal text-left bg-gray-50"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <th class="border px-2 py-1 font-normal text-left">{{ $category->id }}</th>
                    <td class="border px-2 py-1 font-normal text-left">{{ $category->name }}</td>
                    <td class="border px-2 py-1 font-normal text-left">{{ $category->slug }}</td>
                    <td class="border px-2 py-1 font-normal text-left">
                        <img src="{{ $category->getFirstMediaUrl('default', 'thumb') }}">
                    </td>
                    <td class="border px-2 py-1 font-normal text-left" style="background-color: {{ $category->color }}">
                        {{ $category->color }}
                    </td>
                    <td class="border px-2 py-1 font-normal text-left">{{ $category->title }}</td>
                    <td class="border px-2 py-1 font-normal text-left">{{ $category->description }}</td>
                    <td class="border px-2 py-1 font-normal text-left">{{ $category->author->username }}</td>
                    <td class="border px-2 py-1 font-normal text-left"><a
                            href="{{ route('categories.show', $category) }}">View</a></td>
                    <td class="border px-2 py-1 font-normal text-left">
                        @can('update', $category)
                            <a href="{{ route('categories.edit', $category) }}">Edit</a>
                        @endcan
                    </td>
                    <td class="border px-2 py-1 font-normal text-left">
                        @can('delete', $category)
                            <form action="{{ route('categories.destroy', $category) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="cursor-pointer hover:text-rose-600">
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
