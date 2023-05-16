<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid'
defineProps({ projects: { type: Array } })
</script>

<template>
    <Head title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
        </template>

        <div class="max-w-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="/projects/create" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add project</a>
                </div>
                <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                    <li v-for="project in projects" :key="project.id" class="col-span-1 flex rounded-md shadow-sm">
                        <div :class="['bg-purple-400', 'flex w-16 flex-shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white']">{{ project.width }}x{{ project.long }}</div>
                        <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                            <div class="flex-1 truncate px-4 py-2 text-sm">
                                <a :href="'/projects/' + project.id" class="font-medium text-gray-900 hover:text-gray-600">{{ project.name }}</a>
                                <p class="text-gray-500">{{ project.type }}</p>
                            </div>
                            <div class="flex-shrink-0 pr-2">
                                <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-transparent bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Open options</span>
                                    <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
                <div v-if="projects.length === 0">
                    You dont have any projects created yet.
                </div>


            </div>
        </div>
    </AuthenticatedLayout>
</template>
