<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Helpers/Dropdown.vue';
import DropdownLink from '@/Components/Helpers/DropdownLink.vue';
import NavLink from '@/Components/Helpers/NavLink.vue';
import ResponsiveNavLink from '@/Components/Helpers/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const masterMenus = [
    { name: 'Master Alat', route: 'admin.equipments.index' },
    { name: 'Master Kategori Alat', route: 'admin.equipment-categories.index' },
];

const settingMenus = [
    { name: 'Anggota Level', route: 'admin.member-levels.index' },
    { name: 'Anggota Plan', route: 'admin.membership-plans.index' }
]

const memberMenus = [
    { name: 'Anggota', route: 'admin.members.index' },
    { name: 'Orientasi Anggota', route: 'admin.member-inductions.index' },
    { name: 'Registrasi Anggota', route: 'admin.member-registrations.index' },
];
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-dark-background">
            <nav class="bg-white dark:bg-dark-default border-b border-gray-100 dark:border-dark-background">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-dark-accent dark:text-dark-accent" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>

                                <!-- Master Dropdown -->
                                <div class="relative group space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <button 
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none group"
                                        :class="[
                                            route().current('admin.equipments.*', 'admin.equipment-categories.*') 
                                                ? 'text-gray-900 dark:text-white border-b-2 border-dark-accent' 
                                                : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'
                                        ]"
                                    >
                                        Master
                                        <div class="ml-2 p-1 rounded-full bg-dark-accent bg-opacity-10 group-hover:bg-opacity-20 transition-all duration-200">
                                            <svg 
                                                class="h-4 w-4 text-dark-accent transition-transform duration-200 group-hover:rotate-180" 
                                                xmlns="http://www.w3.org/2000/svg" 
                                                viewBox="0 0 20 20" 
                                                fill="currentColor"
                                            >
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>

                                    <div class="absolute z-50 hidden group-hover:block mt-14 w-48">
                                        <div class="py-1 bg-white dark:bg-dark-secondary rounded-md shadow-lg ring-1 ring-black ring-opacity-5 transform opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                                            <Link 
                                                v-for="menu in masterMenus" 
                                                :key="menu.route"
                                                :href="route(menu.route)"
                                                class="block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-primary-500 hover:text-white dark:hover:bg-dark-accent focus:outline-none transition duration-150 ease-in-out"
                                                :class="{ 'bg-primary-500 text-white dark:bg-dark-accent': route().current(menu.route) }"
                                            >
                                                {{ menu.name }}
                                            </Link>
                                        </div>
                                    </div>
                                </div>

                                <div class="relative group space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <button 
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none group"
                                        :class="[
                                            route().current('admin.member-levels.*', 'admin.membership-plans.*') 
                                                ? 'text-gray-900 dark:text-white border-b-2 border-dark-accent' 
                                                : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'
                                        ]"
                                    >
                                        Setting
                                        <div class="ml-2 p-1 rounded-full bg-dark-accent bg-opacity-10 group-hover:bg-opacity-20 transition-all duration-200">
                                            <svg 
                                                class="h-4 w-4 text-dark-accent transition-transform duration-200 group-hover:rotate-180" 
                                                xmlns="http://www.w3.org/2000/svg" 
                                                viewBox="0 0 20 20" 
                                                fill="currentColor"
                                            >
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>

                                    <div class="absolute z-50 hidden group-hover:block mt-14 w-48">
                                        <div class="py-1 bg-white dark:bg-dark-secondary rounded-md shadow-lg ring-1 ring-black ring-opacity-5 transform opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                                            <Link 
                                                v-for="menu in settingMenus" 
                                                :key="menu.route"
                                                :href="route(menu.route)"
                                                class="block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-primary-500 hover:text-white dark:hover:bg-dark-accent focus:outline-none transition duration-150 ease-in-out"
                                                :class="{ 'bg-primary-500 text-white dark:bg-dark-accent': route().current(menu.route) }"
                                            >
                                                {{ menu.name }}
                                            </Link>
                                        </div>
                                    </div>
                                </div>

                                <!-- Member Dropdown -->
                                <div class="relative group space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <button 
                                        class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none group"
                                        :class="[
                                            route().current('admin.member-inductions.*', 'admin.member-registrations.*') 
                                                ? 'text-gray-900 dark:text-white border-b-2 border-dark-accent' 
                                                : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'
                                        ]"
                                    >
                                        Member
                                        <div class="ml-2 p-1 rounded-full bg-dark-accent bg-opacity-10 group-hover:bg-opacity-20 transition-all duration-200">
                                            <svg 
                                                class="h-4 w-4 text-dark-accent transition-transform duration-200 group-hover:rotate-180" 
                                                xmlns="http://www.w3.org/2000/svg" 
                                                viewBox="0 0 20 20" 
                                                fill="currentColor"
                                            >
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>

                                    <div class="absolute z-50 hidden group-hover:block mt-14 w-56">
                                        <div class="py-1 bg-white dark:bg-dark-secondary rounded-md shadow-lg ring-1 ring-black ring-opacity-5 transform opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200">
                                            <Link 
                                                v-for="menu in memberMenus" 
                                                :key="menu.route"
                                                :href="route(menu.route)"
                                                class="block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-primary-500 hover:text-white dark:hover:bg-dark-accent focus:outline-none transition duration-150 ease-in-out"
                                                :class="{ 'bg-primary-500 text-white dark:bg-dark-accent': route().current(menu.route) }"
                                            >
                                                {{ menu.name }}
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center rounded-md border border-transparent px-3 py-2 text-sm font-medium leading-4 
                                                text-gray-500 transition duration-150 ease-in-out 
                                                dark:bg-dark-secondary dark:text-dark-text 
                                                dark:hover:bg-dark-accent dark:hover:text-white"
                                        >
                                            {{ $page.props.auth.user.name }}

                                            <svg
                                                class="-me-0.5 ms-2 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink
                                        :href="route('profile.edit')"
                                        class="dark:hover:bg-dark-accent"
                                    >
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="dark:hover:bg-dark-accent"
                                    >
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="sm:hidden">
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                            class="dark:hover:text-dark-hover"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4 dark:border-dark-border"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800 dark:text-dark-text"
                            >
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500 dark:text-dark-muted">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink 
                                :href="route('profile.edit')"
                                class="dark:hover:text-dark-hover"
                            >
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="dark:hover:text-dark-hover"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>