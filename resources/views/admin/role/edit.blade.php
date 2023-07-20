<x-admin-layout>
    <h1 class="p-4 text-2xl font-semibold">Edit Role</h1>
    <x-splade-form :default="$role" :action="route('admin.roles.update', $role)" method="PUT" class="p-4 space-y-2 bg-white rounded-md">
        <x-splade-input name="name" label="Name" />
        <x-splade-select name="permissions[]" label="Permissions" :options="$permissions" multiple relation choices />
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
