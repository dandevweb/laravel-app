<x-app-layout>
    <x-slot name="header">
        <div class="flex justfy-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Create Post') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-splade-form class="p-4 bg-white rounded" :action="route('posts.store')">
                <x-splade-input name="title" label="Title" />
                <x-splade-file name="image" label="ïmage" class="mt-2" filepond preview />
                <x-splade-submit class="mt-6" />
            </x-splade-form>
        </div>
    </div>
</x-app-layout>
