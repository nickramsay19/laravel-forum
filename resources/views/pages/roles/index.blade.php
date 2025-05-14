<x-layout title="Roles">
    <div class="flex flex-col divide divide-fg">
        <div class="grid grid-cols-5 w-full border border-dark-epsilon divide-x divide-dark-epsilon *:p-1 *:text-center">
            <div class="font-semibold">Role</div>
            <div class="font-semibold col-span-2">Permissions</div>
            <div class="font-semibold">Users</div>
            <div class="font-semibold">Managers</div>
        </div>
        @foreach ($roles as $role)
            <div class="grid grid-cols-5 w-full border border-t-0 border-dark-epsilon divide-x divide-dark-epsilon *:p-1">
                <div>
                    <x-link href="/roles/{{ $role->name }}" class="font-semibold hover:underline">{{ $role->name }}</x-link>
                </div>
                <ul class="text-sm col-span-2 grid grid-cols-2 text-center content-center">
                    @foreach ($role->permissions as $permission)
                        <li class="italic">{{ $permission->name }}</li>
                    @endforeach
                </ul>
                <ul>
                    @foreach ($role->users as $user)
                        <li class="flex flex-row justify-between">
                            <span>{{ $user->name }}</span>
                            @can ( 'deleteUser', [$role, $user] )
                                <x-link hx-delete="{{ route('roles.users.destroy', [$role, $user]) }}" class="text-rose-500 underline cursor-pointer hover:font-semibold">x</x-link>
                            @endcan
                        </li>
                    @endforeach
                </ul>
                <ul>
                    @foreach ($role->managers as $manager)
                        <li>{{ $manager->name }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</x-layout>