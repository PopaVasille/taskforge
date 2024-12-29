<script setup>
import { Link } from '@inertiajs/vue3';
import Logo from '@/Components/Common/Logo.vue';
</script>

<template>
    <div class="h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col">
        <nav class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <Logo class="h-8 w-auto" />
                    <div class="flex space-x-4">
                        <Link :href="route('login')" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                            Login
                        </Link>
                        <Link :href="route('register')" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-indigo-600 border border-indigo-600 hover:bg-indigo-50">
                            Register
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex-1 flex items-center justify-center">
            <main class="mx-auto text-center max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        Task Management Reimagined
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Streamline your projects, collaborate seamlessly, and deliver results with TaskForge.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <Link :href="route('register')"
                              class="rounded-md bg-indigo-600 px-6 py-3 text-lg font-semibold text-white hover:bg-indigo-500">
                            Get Started
                        </Link>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
