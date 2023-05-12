<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid'
defineProps({ products: { type: Array } })
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-4">
                        <a href="/products/create" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add product</a>
                    </div>
                    <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                        <li v-for="product in products" :key="product.id" class="col-span-1 flex rounded-md shadow-sm">
                            <div :class="['bg-purple-400', 'flex w-16 flex-shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white']">{{ product.width }}x{{ product.long }}</div>
                            <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                                <div class="flex-1 truncate px-4 py-2 text-sm">
                                    <a :href="'/products/' + product.id" class="font-medium text-gray-900 hover:text-gray-600">{{ product.name }}</a>
                                    <p class="text-gray-500">{{ product.type }}</p>
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
                    <div v-if="products.length === 0">
                        You dont have any products created yet.
                    </div>


                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
