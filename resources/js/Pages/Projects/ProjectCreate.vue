<!-- resources/js/Pages/Projects/ProjectCreate.vue -->
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

const form = useForm({
    name: '',
    key: '',
    description: '',
    status: 'active',
    priority: 'medium',
    start_date: '',
    end_date: '',
    budget: null,
    currency: 'USD'
});

const generateProjectKey = async () => {
    if (form.name) {
        try {
            const response = await axios.post(route('projects.generate-key'), {
                name: form.name
            });
            form.key = response.data.key;
        } catch (error) {
            console.error('Error generating project key:', error);
        }
    }
};
const submit = () => {
    console.log('Form submitted', form);
    console.log('Route:', route('projects.store'));
    form.post(route('projects.store'), {
        onError: errors => console.error('Errors:', errors),
        onSuccess: () => form.reset()
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Create New Project</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <!-- Project Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project Name</label>
                            <input
                                type="text"
                                v-model="form.name"
                                @blur="generateProjectKey"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required
                            >
                            <div v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</div>
                        </div>

                        <!-- Project Key -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Project Key</label>
                            <input
                                type="text"
                                v-model="form.key"
                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                readonly
                            >
                            <div v-if="form.errors.key" class="mt-1 text-sm text-red-600">{{ form.errors.key }}</div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea
                                v-model="form.description"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            ></textarea>
                            <div v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</div>
                        </div>

                        <!-- Status & Priority -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select
                                    v-model="form.status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="active">Active</option>
                                    <option value="on_hold">On Hold</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Priority</label>
                                <select
                                    v-model="form.priority"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input
                                    type="date"
                                    v-model="form.start_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Date</label>
                                <input
                                    type="date"
                                    v-model="form.end_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>
                        </div>

                        <!-- Budget & Currency -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Budget</label>
                                <input
                                    type="number"
                                    v-model="form.budget"
                                    min="0"
                                    step="0.01"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Currency</label>
                                <select
                                    v-model="form.currency"
                                    :disabled="!form.budget"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="RON">RON</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                :disabled="form.processing"
                            >
                                Create Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
