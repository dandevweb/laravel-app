@props([
    'singularResource' => null,
    'pluralResource' => null,
    'for' => null,
])

<x-admin-layout>
    <div class="flex justify-between">
        <h1 class="p-4 text-2xl font-semibold">{{ $pluralResource }} Index</h1>
        <div class="p-4">
            <Link href="{{ route('admin.' . $pluralResource . '.create') }}"
                class="px-4 py-2 text-white bg-indigo-400 rounded hover:bg-indigo-700">
            New {{ $singularResource }}
            </Link>
        </div>
    </div>
    <x-splade-table :for="$for">
        @cell('action', $resource)
            <div class="space-x-2">
                <Link href="{{ route('admin.' . $pluralResource . '.edit', $resource) }}"
                    class="font-semibold text-green-400 rounded hover:text-green-700">
                Edit
                </Link>
                <Link href="{{ route('admin.' . $pluralResource . '.destroy', $resource) }}" method="DELETE"
                    confirm="Delete the {{ $singularResource }}" confirm-text="Are you sure?" confirm-button="Yes"
                    cancel-button="No" class="font-semibold text-red-400 rounded hover:text-red-700">
                Delete
                </Link>
            </div>
        @endcell
    </x-splade-table>
</x-admin-layout>
