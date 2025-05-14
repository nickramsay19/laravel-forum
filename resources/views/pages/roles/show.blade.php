<x-layout :title="$role->name">
    @foreach ($role->permissions as $permission)
        <div class="flex flex-row justify-between w-full">
            <span>{{ $permission->name }}</span>
            <span>
                @can ( 'deletePermission', [$role, $permission] )
                    <x-link hx-delete="{{ route('roles.permissions.destroy', [$role, $permission]) }}" class="text-rose-500 underline cursor-pointer hover:font-semibold">delete</x-link>
                @endcan
            </span>
        </div>
    @endforeach
</x-layout>