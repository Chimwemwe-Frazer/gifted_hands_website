<ul class="py-4 px-4 space-y-2">
    <li>
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center py-2 rounded-md px-3  space-x-3 {{ Route::currentRouteName() == 'admin.dashboard' || Route::currentRouteName() == 'admin.profile.edit' ? ' bg-mustGreen ' : 'hover:bg-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span>Dashboard</span>
        </a>
    </li>

    @can('list patients')
        <li>
            <a href="{{ route('admin.patients.index') }}"
                class="flex items-center py-2 rounded-md px-3 space-x-3 {{ Str::startsWith(Route::currentRouteName(), 'admin.patients') ? ' bg-mustGreen ' : 'hover:bg-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>Patients</span>
            </a>
        </li>
    @endcan

    @can('list appointments')
        <li>
            <a href="{{ route('admin.appointments.index') }}"
                class="flex items-center py-2 rounded-md px-3 space-x-3 {{ Str::startsWith(Route::currentRouteName(), 'admin.appointments') ? ' bg-mustGreen ' : 'hover:bg-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 6.75h15A1.5 1.5 0 0 1 21 8.25v10.5A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25a1.5 1.5 0 0 1 1.5-1.5Z" />
                </svg>
                <span>Appointments</span>
            </a>
        </li>
    @endcan

    @can('list services')
        <li>
            <a href="{{ route('admin.services.index') }}"
                class="flex items-center py-2 rounded-md px-3 space-x-3 {{ Str::startsWith(Route::currentRouteName(), 'admin.services') ? ' bg-mustGreen ' : 'hover:bg-gray-400' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Services</span>
            </a>
        </li>
    @endcan

    @can('list users')
        <li x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false"
                class="w-full flex items-center py-2 rounded-md px-3 space-x-3 {{ Str::startsWith(Route::currentRouteName(), 'admin.users') || Str::startsWith(Route::currentRouteName(), 'admin.roles') ? ' bg-mustGreen ' : 'hover:bg-gray-400' }}"
                :class="open ? 'bg-gray-400' : ''">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
                <div class="flex items-center justify-between w-full">
                    <span>Access Control</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 transition-transform duration-300"
                        :class="open ? 'rotate-180' : 'rotate-0'">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25 12 15.75l-7.5-7.5" />
                    </svg>
                </div>
            </button>

            <!-- Dropdown menu -->
            <ul x-show="open" class="pl-6 mt-2 space-y-1">
                <li>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center py-2 rounded-md px-3 hover:bg-gray-400 {{ Str::startsWith(Route::currentRouteName(), 'admin.users') ? ' bg-mustGreen ' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.roles.index') }}"
                        class="flex items-center py-2 rounded-md px-3 hover:bg-gray-400 {{ Str::startsWith(Route::currentRouteName(), 'admin.roles') ? ' bg-mustGreen ' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                        </svg>

                        <span>Roles & Permission</span>
                    </a>
                </li>
            </ul>
        </li>
    @endcan
</ul>
