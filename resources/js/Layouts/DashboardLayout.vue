<!-- resources/js/Layouts/DashboardLayout.vue -->
<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import {
    Menu, XIcon, BellIcon, ChevronDownIcon,
    HomeIcon, LayoutIcon, CheckSquareIcon,
    CalendarIcon, FileTextIcon, UsersIcon,
    SettingsIcon, PlusCircleIcon
} from 'lucide-vue-next';

const sidebarOpen = ref(true);
const profileDropdownOpen = ref(false);

</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar -->
        <div :class="[sidebarOpen ? 'w-64' : 'w-20', 'bg-indigo-700 min-h-screen transition-all duration-300 fixed']">
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center">
                    <span v-if="sidebarOpen" class="text-white text-xl font-bold">TaskForge</span>
                </div>
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="text-white p-1 rounded-lg hover:bg-indigo-600"
                >
                    <XIcon v-if="sidebarOpen" size="20" />
                    <Menu v-else size="20" />
                </button>
            </div>

            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <Link :href="route('dashboard')"
                          class="flex items-center space-x-3 text-white p-3 rounded-lg"
                          :class="{ 'bg-indigo-800': route().current('dashboard') }">
                        <HomeIcon size="20" />
                        <span v-if="sidebarOpen">Dashboard</span>
                    </Link>

                    <Link :href="route('projects')"
                          class="flex items-center space-x-3 text-white/70 hover:text-white p-3 rounded-lg hover:bg-indigo-800">
                        <LayoutIcon size="20" />
                        <span v-if="sidebarOpen">Projects</span>
                    </Link>

                    <Link :href="route('tasks')"
                          class="flex items-center space-x-3 text-white/70 hover:text-white p-3 rounded-lg hover:bg-indigo-800">
                        <CheckSquareIcon size="20" />
                        <span v-if="sidebarOpen">Tasks</span>
                    </Link>

                    <Link :href="route('calendar')"
                          class="flex items-center space-x-3 text-white/70 hover:text-white p-3 rounded-lg hover:bg-indigo-800">
                        <CalendarIcon size="20" />
                        <span v-if="sidebarOpen">Calendar</span>
                    </Link>

                    <Link :href="route('documents')"
                          class="flex items-center space-x-3 text-white/70 hover:text-white p-3 rounded-lg hover:bg-indigo-800">
                        <FileTextIcon size="20" />
                        <span v-if="sidebarOpen">Documents</span>
                    </Link>

                    <Link :href="route('team')"
                          class="flex items-center space-x-3 text-white/70 hover:text-white p-3 rounded-lg hover:bg-indigo-800">
                        <UsersIcon size="20" />
                        <span v-if="sidebarOpen">Team</span>
                    </Link>

                    <Link :href="route('settings')"
                          class="flex items-center space-x-3 text-white/70 hover:text-white p-3 rounded-lg hover:bg-indigo-800 mt-8">
                        <SettingsIcon size="20" />
                        <span v-if="sidebarOpen">Settings</span>
                    </Link>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div :class="[sidebarOpen ? 'ml-64' : 'ml-20', 'flex-1 transition-all duration-300']">
            <!-- Header -->
            <header class="bg-white shadow h-16 fixed right-0 z-10"
                    :style="{ width: `calc(100% - ${sidebarOpen ? '16rem' : '5rem'})` }">
                <div class="flex items-center justify-between h-full px-6">
                    <button class="flex items-center space-x-2 text-gray-600 hover:text-indigo-600">
                        <PlusCircleIcon size="20" />
                        <span>New Project</span>
                    </button>

                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-400 hover:text-gray-500">
                            <BellIcon size="20" />
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                        </button>

                        <div class="relative">
                            <button
                                @click="profileDropdownOpen = !profileDropdownOpen"
                                class="flex items-center space-x-3 focus:outline-none"
                            >
                                <img
                                    class="h-8 w-8 rounded-full"
                                    :src="$page.props.auth.user.profile_photo_url"
                                    :alt="$page.props.auth.user.name"
                                />
                                <div class="hidden md:block">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-700">{{ $page.props.auth.user.name }}</span>
                                        <ChevronDownIcon size="16" class="ml-2 text-gray-400" />
                                    </div>
                                </div>
                            </button>

                            <div v-if="profileDropdownOpen"
                                 class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <Link :href="route('profile.edit')"
                                          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Your Profile
                                    </Link>
                                    <Link :href="route('profile.settings')"
                                          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Settings
                                    </Link>
                                    <Link :href="route('logout')"
                                          method="post"
                                          as="button"
                                          class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="pt-24 px-6 pb-8">
                <slot />
            </main>
        </div>
    </div>
</template>
