<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ExclamationCircleIcon } from '@heroicons/vue/20/solid'

const name = ref('John Doe')
const form = useForm({
    name: null,
    type: 'Square',
    width: 5,
    long: 50
})

function submitForm() {
    form.post('/projects', {
        preserveScroll: true,
        onSuccess: () => form.reset('name', 'type'),
    });
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create new project: {{  name }}</h2>
        </template>

        <div class="max-w-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form @submit.prevent="submitForm">
                    <div class="mt-2">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                v-model="form.name"
                                :class="[form.errors.name ? 'pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600','block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6']"
                                placeholder="Name of the project"/>
                            <div v-if="form.errors.name" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                            </div>
                        </div>
                        <p v-if="form.errors.name" class="mt-2 text-sm text-red-600" id="name-error">{{ form.errors.name }}</p>
                    </div>
                    <div class="mt-2">
                        <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Type</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input
                                type="text"
                                name="type"
                                id="type"
                                v-model="form.type"
                                :class="[form.errors.type ? 'pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600','block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6']"
                                placeholder="Type of the project"/>
                            <div v-if="form.errors.type" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                            </div>
                        </div>
                        <p v-if="form.errors.type" class="mt-2 text-sm text-red-600" id="type-error">{{ form.errors.type }}</p>
                    </div>
                    <div class="mt-2">
                        <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Width</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input
                                type="number"
                                name="width"
                                id="width"
                                v-model="form.width"
                                :class="[form.errors.width ? 'pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600','block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6']"
                                placeholder="Width of the project"/>
                            <div v-if="form.errors.width" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                            </div>
                        </div>
                        <p v-if="form.errors.width" class="mt-2 text-sm text-red-600" id="width-error">{{ form.errors.width }}</p>
                    </div>
                    <div class="mt-2">
                        <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Longitude</label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input
                                type="number"
                                name="long"
                                id="long"
                                v-model="form.long"
                                :class="[form.errors.long ? 'pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600','block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6']"
                                placeholder="Large of the project"/>
                            <div v-if="form.errors.long" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                            </div>
                        </div>
                        <p v-if="form.errors.long" class="mt-2 text-sm text-red-600" id="long-error">{{ form.errors.long }}</p>
                    </div>
                    <div class="mt-2">
                        <button type="submit" :disabled="form.processing" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
