<x-layout title="Category Index">
    <div class="container mx-auto p-4">

        <div class="mb-4">
            <a href="{{ route('categories.create') }}">Create Category</a>
        </div>

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
                    <td class="border px-2 py-1 font-normal text-left"><a
                            href="{{ route('categories.show', $category) }}">View</a></td>
                    <td class="border px-2 py-1 font-normal text-left"><a
                            href="{{ route('categories.edit', $category) }}">Edit</a></td>
                    <td class="border px-2 py-1 font-normal text-left">
                        <form action="{{ route('categories.destroy', $category) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete" class="cursor-pointer hover:text-rose-600">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
