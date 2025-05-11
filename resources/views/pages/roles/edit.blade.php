<x-layout title="Edit">
    <form hx-put="{{ route('roles.update', ['role' => $role]) }}" class="flex flex-col">
        <x-input name="name" type="text" label="name" placeholder="$role-name" :value="$role->name" required inline />

        <x-input.select name="permission" value="{{ $role->permission->pluck('name')->toJson() }}" class="my-2" multiple>
            <option disabled>Permissions:</option>
            @foreach (\App\Models\Permission::all()->pluck('name') as $permission)
                <option value="{{ $permission }}">{{ $permission }}</option>
            @endforeach
        </x-input.select>

        <x-input.select name="users" value="{{ $role->users->pluck('name')->toJson() }}" class="my-2" multiple>
            <option disabled>Users:</option>
            @foreach (\App\Models\User::all()->pluck('name') as $user)
                <option value="{{ $user }}">{{ $user }}</option>
            @endforeach
        </x-input.select>

        <hr class="text-light-gamma" />

        <div class="flex flex-row gap-2 mt-2">
            <x-button
                type="submit"
            >
                Save
            </x-button>
        </div>
    </form>
</x-layout>