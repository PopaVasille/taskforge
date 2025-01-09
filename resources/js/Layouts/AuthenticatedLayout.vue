<script setup>
import { ref, computed } from 'vue';
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
    FileText,
    Clock,
    PlayCircle,
    PauseCircle,
    StopCircle,
    History
} from 'lucide-vue-next';
import Toast from '@/Components/Common/Toast.vue';
import { useToast } from '@/Composables/useToast';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Logo from '@/Components/Common/Logo.vue';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(true);
const user = usePage().props.auth.user;
const activeTimer = ref(null);
const openSubMenus = ref(new Set());
// Time tracking state
const isTimerRunning = ref(false);
const currentTaskId = ref(null);
const timerStartTime = ref(null);
const elapsedTime = ref(0);

const { toast } = useToast();
const formatTime = (seconds) => {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;
    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
};

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
            { name: 'Sprinturi', route: 'projects.sprints' },
            { name: 'Echipe', route: 'projects.teams' },
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
            { name: 'In Progres', route: 'tasks.in-progress' },
            { name: 'In Review', route: 'tasks.review' },
            { name: 'Finalizate', route: 'tasks.completed' }
        ]
    },
    {
        icon: Timer,
        name: 'Time Tracking',
        route: 'timetracking.index',
        subItems: [
            { name: 'Timpi Înregistrați', route: 'timetracking.entries' },
            { name: 'Rapoarte', route: 'timetracking.reports' },
            { name: 'Dashboard Timp', route: 'timetracking.dashboard' },
            { name: 'Istoric', route: 'timetracking.history' }
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
    {
        icon: Calendar,
        name: 'Calendar',
        route: 'calendar'
    },
    {
        icon: Settings,
        name: 'Setări',
        route: 'settings.index',
        subItems: [
            { name: 'Preferințe', route: 'settings.preferences' },
            { name: 'Notificări', route: 'settings.notifications' },
            { name: 'Securitate', route: 'settings.security' },
            { name: 'Integrări', route: 'settings.integrations' }
        ]
    }
];

const startTimer = (taskId) => {
    isTimerRunning.value = true;
    currentTaskId.value = taskId;
    timerStartTime.value = Date.now();
    // Actualizare timer la fiecare secundă
    activeTimer.value = setInterval(() => {
        elapsedTime.value = Math.floor((Date.now() - timerStartTime.value) / 1000);
    }, 1000);
};

const pauseTimer = () => {
    isTimerRunning.value = false;
    clearInterval(activeTimer.value);
};

const stopTimer = async () => {
    isTimerRunning.value = false;
    clearInterval(activeTimer.value);
    // Aici ar trebui să salvăm timpul înregistrat în backend
    const duration = Math.floor((Date.now() - timerStartTime.value) / 1000);
    try {
        await fetch('/api/timetracking/entries', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                task_id: currentTaskId.value,
                duration,
                start_time: new Date(timerStartTime.value).toISOString(),
                end_time: new Date().toISOString(),
            }),
        });
        elapsedTime.value = 0;
        currentTaskId.value = null;
        timerStartTime.value = null;
    } catch (error) {
        console.error('Error saving time entry:', error);
    }
};
const toggleSubMenu = (route) => {
    if (openSubMenus.value.has(route)) {
        openSubMenus.value.delete(route);
    } else {
        openSubMenus.value.add(route);
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <div :class="[
            'fixed top-0 left-0 h-full bg-white shadow-lg transition-all duration-200 z-20',
            sidebarOpen ? 'w-64' : 'w-20'
        ]">
            <!-- Logo -->
            <div class="flex items-center justify-between px-6 h-16 border-b border-gray-100">
                <div v-if="sidebarOpen" class="flex items-center duration-300">
                    <Link  :href="route('dashboard')">
                        <Logo class="h-8 w-auto duration-300"/>
                    </Link>
                </div>
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg hover:bg-gray-100 text-gray-500"
                >
                    <X v-if="sidebarOpen" class="w-5 h-5"/>
                    <Menu v-else class="w-5 h-5"/>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <div v-for="item in menuItems" :key="item.route" class="relative">
                    <div class="flex items-center">
                        <Link
                            :href="route(item.route)"
                            class="flex-1 flex items-center px-4 py-2.5 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200"
                        >
                            <component :is="item.icon" class="w-5 h-5"/>
                            <span v-if="sidebarOpen" class="ml-3 text-sm font-medium">{{ item.name }}</span>
                        </Link>

                        <!-- Buton separat pentru toggle submeniu -->
                        <button
                            v-if="item.subItems && sidebarOpen"
                            @click.prevent="toggleSubMenu(item.route)"
                            class="p-2 hover:bg-indigo-50 rounded-lg"
                        >
                            <ChevronDown
                                class="w-4 h-4 transition-transform duration-200"
                                :class="{ 'transform rotate-180': openSubMenus.has(item.route) }"
                            />
                        </button>
                    </div>

                    <!-- Submeniu cu animație -->
                    <div
                        v-if="sidebarOpen && item.subItems"
                        v-show="openSubMenus.has(item.route)"
                        class="ml-6 mt-1 space-y-1 transition-all duration-200"
                    >
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
            'min-h-screen transition-all duration-300',
            sidebarOpen ? 'ml-64' : 'ml-20'
        ]">
            <!-- Header -->
            <header class="bg-white shadow-sm fixed top-0 z-10 transition-all duration-300"
                    :class="[sidebarOpen ? 'left-64 right-0' : 'left-20 right-0']">
                <div class="h-16 px-6 flex items-center justify-between">
                    <!-- Left side - Search -->
                    <div class="w-96">
                        <div class="relative">
                            <input
                                type="text"
                                placeholder="Caută în aplicație..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                            />
                            <Search class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
                        </div>
                    </div>

                    <!-- Right side - Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Time Entry Button -->
                        <Dropdown align="right" width="300">
                            <template #trigger>
                                <button class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100">
                                    <Clock class="w-5 h-5 text-gray-500"/>
                                    <span class="text-sm text-gray-700">Adaugă Timp</span>
                                </button>
                            </template>

                            <template #content>
                                <div class="p-4">
                                    <div class="text-sm font-medium text-gray-500 mb-2">Înregistrare Rapidă Timp</div>
                                    <div class="space-y-4">
                                        <Link :href="route('timetracking.new')"
                                              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Înregistrare Manuală
                                        </Link>
                                        <Link :href="route('timetracking.entries')"
                                              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Vezi Toate Înregistrările
                                        </Link>
                                    </div>
                                </div>
                            </template>
                        </Dropdown>

                        <!-- Notifications -->
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button class="relative p-2 rounded-lg hover:bg-gray-100">
                                    <Bell class="w-5 h-5 text-gray-500"/>
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
                                    <ChevronDown class="w-4 h-4 ml-2 text-gray-500"/>
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
                </div>
            </header>

            <!-- Page Content -->
            <main class="pt-16 p-6">
                <div class="max-w-7xl mx-auto">
                    <template v-if="$slots.header">
                        <header class="mb-6">
                            <slot name="header"/>
                        </header>
                    </template>

                    <slot/>
                </div>
            </main>
        </div>
    </div>
    <Toast
        v-if="toast"
        :message="toast.message"
        :type="toast.type"
        :duration="toast.duration"
    />
</template>
