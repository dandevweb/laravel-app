<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Posts') }}
            </h2>
            <Link href="{{ route('posts.create') }}">
            New Post
            </Link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-splade-table :for="$posts">
                @cell('action', $post)
                    <div class="space-x-2">
                        <Link href="{{ route('posts.edit', $post) }}"
                            class="font-semibold text-green-400 rounded hover:text-green-700">
                        Edit
                        </Link>
                        <Link href="{{ route('posts.destroy', $post) }}" method="DELETE" confirm="Delete the post"
                            confirm-text="Are you sure?" confirm-button="Yes" cancel-button="No"
                            class="font-semibold text-red-400 rounded hover:text-red-700">
                        Delete
                        </Link>
                    </div>
                @endcell
            </x-splade-table>
        </div>
    </div>
</x-app-layout>
