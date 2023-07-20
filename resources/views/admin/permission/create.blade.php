<x-admin-layout>
    <h1 class="p-4 text-2xl font-semibold">New Permission</h1>
    <x-splade-form :action="route('admin.permissions.store')" class="p-4 space-y-2 bg-white rounded-md">
        <x-splade-input name="name" label="Name" />
        <x-splade-select name="roles[]" label="Roles" :options="$roles" multiple relation choices />
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
