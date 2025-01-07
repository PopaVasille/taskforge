<!-- resources/js/Pages/Projects/ProjectIndex.vue -->
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PlusCircle } from 'lucide-vue-next';

defineProps({
    projects: Object
});

function created() {
    console.log('Projects:', this.projects);
}

</script>

<template>
    <Head title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center mt-2">
                <h2 class="text-xl font-semibold text-gray-900">Projects</h2>
                <Link
                    :href="route('projects.create')"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500"
                >
                    <PlusCircle class="w-5 h-5 mr-2" />
                    New Project
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-if="projects.data.length > 0" v-for="project in projects.data" :key="project.id"
                                 class="bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <Link :href="route('projects.show', { project: project.id })">
                                    <div class="p-4">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-lg font-semibold">{{ project.name }}</h3>
                                            <span class="text-sm px-2 py-0.5 bg-gray-100 text-gray-600 rounded">
                                            {{ project.key }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ project.description }}</p>
                                        <div class="mt-4 flex justify-between items-center">
                                            <span class="text-sm text-gray-500">
                                                {{ project.tasks_count }} tasks
                                            </span>
                                            <span :class="{
                                                'px-2 py-1 text-xs rounded-full': true,
                                                'bg-green-100 text-green-800': project.status === 'active',
                                                'bg-yellow-100 text-yellow-800': project.status === 'on_hold',
                                                'bg-blue-100 text-blue-800': project.status === 'completed'
                                            }">
                                                {{ project.status }}
                                            </span>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                            <div v-else class="p-4">
                                Nu sunt Proiecte.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
