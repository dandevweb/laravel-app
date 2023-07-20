<x-admin-layout>
    <h1 class="p-4 text-2xl font-semibold">Edit Permission</h1>
    <x-splade-form :default="$permission" :action="route('admin.permissions.update', $permission)" method="PUT" class="p-4 space-y-2 bg-white rounded-md">
        <x-splade-input name="name" label="Name" />
        <x-splade-select name="roles[]" label="Roles" :options="$roles" multiple relation choices />
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
