<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    FolderKanban,
    Users,
    Calendar,
    Settings,
    Bell,
    ChevronDown,
    Menu,
    X,
    Timer,
    ClipboardList,
    FileText
} from 'lucide-vue-next';

import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Logo from '@/Components/Common/Logo.vue';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(true);
const user = usePage().props.auth.user;

const menuItems = [
    {
        icon: LayoutDashboard,
        name: 'Dashboard',
        route: 'dashboard'
    },
    {
        icon: FolderKanban,
        name: 'Proiecte',
        route: 'projects.index',
        subItems: [
            { name: 'Listă Proiecte', route: 'projects.index' },
            { name: 'Proiecte Active', route: 'projects.active' },
            { name: 'Arhivă', route: 'projects.archived' }
        ]
    },
    {
        icon: ClipboardList,
        name: 'Task-uri',
        route: 'tasks.index',
        subItems: [
            { name: 'Toate Task-urile', route: 'tasks.index' },
            { name: 'Task-urile Mele', route: 'tasks.my-tasks' },
            { name: 'În Progres', route: 'tasks.in-progress' },
            { name: 'În Review', route: 'tasks.review' },
            { name: 'Finalizate', route: 'tasks.completed' }
        ]
    },
    {
        icon: Timer,
        name: 'Sprint-uri',
        route: 'sprints.index',
        subItems: [
            { name: 'Sprint Activ', route: 'sprints.active' },
            { name: 'Planificare', route: 'sprints.planning' },
            { name: 'Istoric', route: 'sprints.history' }
        ]
    },
    {
        icon: FileText,
        name: 'Documentație',
        route: 'documentation.index',
        subItems: [
            { name: 'Vizualizare', route: 'documentation.view' },
            { name: 'Generare Automată', route: 'documentation.generate' },
            { name: 'Istoric', route: 'documentation.history' }
        ]
    },
    { icon: Users, name: 'Echipă', route: 'team.index' },
    { icon: Calendar, name: 'Calendar', route: 'calendar' },
    { icon: Settings, name: 'Setări', route: 'settings.index' }
];
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <div :class="[
      'fixed top-0 left-0 h-full bg-white shadow-lg transition-all duration-300 z-20',
      sidebarOpen ? 'w-64' : 'w-20'
    ]">
            <!-- Logo -->
            <Logo class="w-20 h-auto mx-auto mt-6" />
            <div class="flex items-center justify-between px-6 h-16 border-b border-gray-100">
                <div class="flex items-center">
                    <Link :href="route('dashboard')">
                        <Logo class="h-8 w-auto" />
                    </Link>
                </div>
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg hover:bg-gray-100 text-gray-500"
                >
                    <X v-if="sidebarOpen" class="w-5 h-5" />
                    <Menu v-else class="w-5 h-5" />
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <div v-for="item in menuItems" :key="item.route" class="relative">
                    <Link
                        :href="route(item.route)"
                        class="flex items-center px-4 py-2.5 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200"
                    >
                        <component :is="item.icon" class="w-5 h-5" />
                        <template v-if="sidebarOpen">
                            <span class="ml-3 text-sm font-medium flex-1">{{ item.name }}</span>
                            <ChevronDown v-if="item.subItems" class="w-4 h-4" />
                        </template>
                    </Link>

                    <div v-if="sidebarOpen && item.subItems" class="ml-6 mt-1 space-y-1">
                        <Link
                            v-for="subItem in item.subItems"
                            :key="subItem.route"
                            :href="route(subItem.route)"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200"
                        >
                            {{ subItem.name }}
                        </Link>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div :class="[
      'transition-all duration-300',
      sidebarOpen ? 'ml-64' : 'ml-20'
    ]">
            <!-- Header -->
            <header class="h-16 bg-white shadow-sm fixed top-0 right-0 left-auto w-full z-10">
                <div class="flex items-center justify-end h-full px-6 gap-4">
                    <!-- Notifications -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="relative p-2 rounded-lg hover:bg-gray-100">
                                <Bell class="w-5 h-5 text-gray-500" />
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-white text-xs flex items-center justify-center">
                  3
                </span>
                            </button>
                        </template>

                        <template #content>
                            <div class="p-4">
                                <div class="text-sm font-medium text-gray-500">Notificări</div>
                                <div class="mt-3 space-y-2">
                                    <DropdownLink :href="route('notifications')">
                                        Vezi toate notificările
                                    </DropdownLink>
                                </div>
                            </div>
                        </template>
                    </Dropdown>

                    <!-- User Menu -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium">
                                    {{ user.name.charAt(0) }}
                                </div>
                                <template v-if="sidebarOpen">
                                    <span class="ml-3 text-sm font-medium text-gray-700">{{ user.name }}</span>
                                    <ChevronDown class="w-4 h-4 ml-2 text-gray-500" />
                                </template>
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                Profil
                            </DropdownLink>
                            <DropdownLink :href="route('profile.settings')">
                                Setări
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                Deconectare
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- Page Content -->
            <main class="pt-16 p-6">
                <div class="max-w-7xl mx-auto">
                    <template v-if="$slots.header">
                        <header class="mb-6">
                            <slot name="header" />
                        </header>
                    </template>

                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
