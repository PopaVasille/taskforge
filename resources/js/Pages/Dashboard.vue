# Dashboard.vue
<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { BarChart, Activity, Users, Clock } from 'lucide-vue-next';

const stats = ref([
    { name: 'Proiecte Active', value: '12', change: '+2', icon: BarChart },
    { name: 'Task-uri în Progres', value: '28', change: '-4', icon: Activity },
    { name: 'Membri Echipă', value: '31', change: '+4', icon: Users },
    { name: 'Ore Tracked', value: '284', change: '+23', icon: Clock }
]);
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>

                <!-- Statistici de bază -->
                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        v-for="stat in stats"
                        :key="stat.name"
                        class="overflow-hidden rounded-lg bg-white shadow"
                    >
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <component
                                        :is="stat.icon"
                                        class="h-6 w-6 text-gray-400"
                                        aria-hidden="true"
                                    />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="truncate text-sm font-medium text-gray-500">
                                            {{ stat.name }}
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ stat.value }}
                                            </div>
                                            <div
                                                :class="[
                                                    'ml-2 flex items-baseline text-sm font-semibold',
                                                    stat.change.startsWith('+') ? 'text-green-600' : 'text-red-600'
                                                ]"
                                            >
                                                {{ stat.change }}
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secțiunea de Activitate Recentă -->
                <div class="mt-6">
                    <h2 class="text-lg font-medium text-gray-900">Activitate Recentă</h2>
                    <div class="mt-4 overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <p class="text-gray-500">Aici va fi lista de activități...</p>
                        </div>
                    </div>
                </div>

                <!-- Secțiunea de Proiecte Active -->
                <div class="mt-6">
                    <h2 class="text-lg font-medium text-gray-900">Proiecte Active</h2>
                    <div class="mt-4 overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-6">
                            <p class="text-gray-500">Aici va fi lista de proiecte...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
