<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ExclamationCircleIcon } from '@heroicons/vue/20/solid'

const name = ref('New Delica Bead')
const form = useForm({
    source_url: null,
})

function submitForm() {
    form.post('/delicas', {
        preserveScroll: true,
        onSuccess: () => form.reset('source_url'),
    });
}

</script>

<template>
    <Head title="Create Delica" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create new delica</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submitForm">
                        <div class="mt-2">
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Source URL</label>
                            <div class="relative mt-2 rounded-md shadow-sm">
                                <input
                                    type="text"
                                    name="source_url"
                                    id="source_url"
                                    v-model="form.source_url"
                                    :class="[form.errors.source_url ? 'pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600','block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6']"
                                    placeholder="Url to get data"/>
                                <div v-if="form.errors.source_url" class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                </div>
                            </div>
                            <p v-if="form.errors.source_url" class="mt-2 text-sm text-red-600" id="name-error">{{ form.errors.source_url }}</p>
                            <p v-else class="mt-2 text-sm text-gray-500" id="email-description">Please provide the detail url of the bead from <a class="text-violet-500" target="_blank" href="https://www.threadabead.com/Delica_Colours.aspx">this</a> page. <br>This URL should look like: https://www.threadabead.com/Search_Select.aspx?shop=2&entry_id=1062</p>
                        </div>
                        <div class="mt-2">
                            <button type="submit" :disabled="form.processing" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
