<!-- resources/js/Pages/Projects/ProjectShow.vue -->
<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    Clock,
    PencilIcon,
    Users,
    Calendar,
    AlertTriangle,
    CheckCircle2,
    Timer,
    Plus,
    Settings
} from 'lucide-vue-next';

const props = defineProps({
    project: {
        type: Object,
        required: true
    }
});

const activeTab = ref('overview');

const getStatusColor = (status) => {
    const colors = {
        'active': 'bg-green-100 text-green-800',
        'on_hold': 'bg-yellow-100 text-yellow-800',
        'completed': 'bg-blue-100 text-blue-800',
        'cancelled': 'bg-red-100 text-red-800'
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
};

const getPriorityColor = (priority) => {
    const colors = {
        'low': 'bg-blue-100 text-blue-800',
        'medium': 'bg-yellow-100 text-yellow-800',
        'high': 'bg-orange-100 text-orange-800',
        'urgent': 'bg-red-100 text-red-800'
    };
    return colors[priority] || 'bg-gray-100 text-gray-800';
};
</script>

<template>
    <AuthenticatedLayout>
        <Head :title="`${project.name}`" />

        <div class="max-w-7xl mx-auto py-6">
            <!-- Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <div class="flex items-center gap-4">
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ project.key }} - {{ project.name }}
                        </h1>
                        <span :class="['px-3 py-1 rounded-full text-sm font-medium', getStatusColor(project.status)]">
                            {{ project.status }}
                        </span>
                        <span :class="['px-3 py-1 rounded-full text-sm font-medium', getPriorityColor(project.priority)]">
                            {{ project.priority }}
                        </span>
                    </div>
                    <p class="mt-2 text-gray-600">{{ project.description }}</p>
                </div>

                <div class="flex gap-3">
                    <Link
                        v-if="project.owner_id === $page.props.auth.user.id"
                        :href="route('projects.edit', project.id)"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
                    >
                        <PencilIcon class="w-5 h-5 mr-2" />
                        Edit Project
                    </Link>
                    <Link
                        :href="route('tasks.create', { project: project.id })"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500"
                    >
                        <Plus class="w-5 h-5 mr-2" />
                        Create Task
                    </Link>
                    <Link
                        :href="route('projects.settings', project.id)"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
                    >
                        <Settings class="w-5 h-5 mr-2" />
                        Project Settings
                    </Link>
                </div>
            </div>

            <!-- Project Details Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Timeline Card -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <Calendar class="w-5 h-5 text-gray-400 mr-2" />
                        <h3 class="text-lg font-medium">Timeline</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500">Start Date</span>
                            <p class="font-medium">{{ project.start_date || 'Not set' }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Due Date</span>
                            <p class="font-medium">{{ project.end_date || 'Not set' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Team Card -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <Users class="w-5 h-5 text-gray-400 mr-2" />
                        <h3 class="text-lg font-medium">Team</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500">Owner</span>
                            <p class="font-medium">{{ project.owner.name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Team Members</span>
                            <p class="font-medium">{{ project.members.length }} members</p>
                        </div>
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center mb-4">
                        <CheckCircle2 class="w-5 h-5 text-gray-400 mr-2" />
                        <h3 class="text-lg font-medium">Progress</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500">Tasks</span>
                            <p class="font-medium">{{ project.tasks.length }} total tasks</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Completion</span>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div
                                    class="bg-indigo-600 h-2.5 rounded-full"
                                    :style="{ width: `${(project.tasks.filter(t => t.status === 'completed').length / project.tasks.length * 100) || 0}%` }"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex space-x-8">
                    <button
                        v-for="[tab, label] in [
                            ['overview', 'Overview'],
                            ['board', 'Board'],
                            ['timeline', 'Timeline'],
                            ['tasks', 'Tasks'],
                            ['team', 'Team'],
                            ['documents', 'Documents']
                        ]"
                        :key="tab"
                        @click="activeTab = tab"
                        :class="[
                            'py-4 px-1 border-b-2 font-medium text-sm',
                            activeTab === tab
                                ? 'border-indigo-500 text-indigo-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        ]"
                    >
                        {{ label }}
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="bg-white shadow rounded-lg">
                <div v-if="activeTab === 'overview'" class="p-6">
                    <h3 class="text-lg font-medium mb-4">Project Overview</h3>
                    <!-- Add your overview content here -->
                </div>
                <!-- Add other tab contents -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
