<nova-sidebar>
    <template>
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="var(--sidebar-icon)" d="M15.6 15.47A4.99 4.99 0 0 1 7 12a5 5 0 0 1 10 0v1.5a1.5 1.5 0 1 0 3 0V12a8 8 0 1 0-4.94 7.4 1 1 0 1 1 .77 1.84A10 10 0 1 1 22 12v1.5a3.5 3.5 0 0 1-6.4 1.97zM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
        <span class="sidebar-label">
        Custom Action
    </span>
    </template>

    <template v-slot:menu>

        <li class="leading-wide mb-4 text-sm">
            <router-link
                :to="{
                    name: 'index',
                    params: {
                        resourceName: 'actions'
                    },
                }"
                class="text-white ml-8 no-underline dim"
            >
                Actions
            </router-link>
        </li>

        <li class="leading-wide mb-4 text-sm">
            <router-link
                :to="{
                    name: 'index',
                    params: {
                        resourceName: 'icons'
                    },
                }"
                class="text-white ml-8 no-underline dim"
            >
                Icons
            </router-link>
        </li>

    </template>
</nova-sidebar>
