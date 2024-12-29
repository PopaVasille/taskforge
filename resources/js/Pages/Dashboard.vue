<!-- resources/js/Pages/Dashboard.vue -->
<script setup>
import { Head } from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { FolderIcon, CheckSquareIcon, UsersIcon, ClockIcon } from 'lucide-vue-next';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            activeProjects: 12,
            tasks: 28,
            teamMembers: 8,
            hoursTracked: 164
        })
    },
    recentTasks: {
        type: Array,
        default: () => []
    },
    projects: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <DashboardLayout>
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ $page.props.auth.user.name }}!</h1>
            <p class="text-gray-600">Here's what's happening in your projects</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-full">
                        <FolderIcon class="w-6 h-6 text-indigo-600" />
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Active Projects</h3>
                        <p class="text-2xl font-semibold text-gray-900">{{ stats.activeProjects }}</p>
                    </div>
                </div>
            </div>
            <!-- Repetă pentru celelalte stats -->
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Recent Tasks -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Recent Tasks</h2>
                    <div class="mt-4 space-y-4">
                        <div v-for="task in recentTasks" :key="task.id"
                             class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <CheckSquareIcon class="w-5 h-5 text-gray-400" />
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">{{ task.title }}</p>
                                <p class="text-sm text-gray-500">{{ task.due_date }}</p>
                            </div>
                            <span :class="[
                                'ml-auto px-2 py-1 text-xs font-medium rounded-full',
                                task.status === 'in_progress' ? 'text-green-700 bg-green-100' : 'text-yellow-700 bg-yellow-100'
                            ]">
                                {{ task.status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Overview -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Project Overview</h2>
                    <div class="mt-4 space-y-4">
                        <div v-for="project in projects" :key="project.id"
                             class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-medium text-gray-900">{{ project.name }}</h3>
                                <span :class="[
                                    'px-2 py-1 text-xs font-medium rounded-full',
                                    project.status === 'active' ? 'text-blue-700 bg-blue-100' : 'text-purple-700 bg-purple-100'
                                ]">
                                    {{ project.status }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full"
                                     :style="{ width: `${project.progress}%` }"></div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">{{ project.remaining_tasks }} tasks remaining</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
