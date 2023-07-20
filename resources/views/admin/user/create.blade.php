<x-admin-layout>
    <h1 class="p-4 text-2xl font-semibold">New User</h1>
    <x-splade-form :action="route('admin.users.store')" class="p-4 space-y-2 bg-white rounded-md">
        <x-splade-input name="username" label="Username" />
        <x-splade-input name="first_name" label="First name" />
        <x-splade-input name="last_name" label="Last name" />
        <x-splade-input name="email" label="Email address" />
        <x-splade-input type="password" name="password" label="Password" />
        <x-splade-input type="password" name="password_confirmation" label="Password confirmation" />
        <x-splade-select name="roles[]" label="Roles" :options="$roles" multiple relation choices />
        <x-splade-select name="permissions[]" label="Permissions" :options="$permissions" multiple relation choices />
        <x-splade-submit />
    </x-splade-form>
</x-admin-layout>
