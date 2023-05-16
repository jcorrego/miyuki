<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { HeartIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { PencilIcon, PlusIcon } from '@heroicons/vue/20/solid'

defineProps({ delicas: { type: Array } })
const open = ref(false)
const selectedDelica = ref(null)
const search = ref('')

function searchDelicas() {
    router.reload({
      data:{search: search.value },
      only: ['delicas']
    })
}

function showDelica(delica) {
    selectedDelica.value = delica
    open.value = true
}
</script>

<template>
    <Head title="Delicas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Delicas</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-4 flex items-center justify-between">
                      <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Search</label>
                        <div class="mt-2">
                          <input type="text" v-model="search" @keyup="searchDelicas" name="search" id="search" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Search" />
                        </div>
                      </div>
                      <a v-show="false" href="/delicas/create" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add delica</a>
                    </div>
                    <div class="border-t border-gray-900/10 mb-10"></div>
                    <div class="mb-4 text-gray-500 text-sm italic">Showing {{ delicas.length }} delicas</div>
                    <ul role="list" class="grid grid-cols-4 gap-x-4 gap-y-8 sm:grid-cols-6 sm:gap-x-6 lg:grid-cols-8 xl:gap-x-8">
                        <li v-for="delica in delicas" :key="delica.id" @click="showDelica(delica)" class="relative cursor-pointer">
                            <div class="group aspect-h-4 aspect-w-4 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                                <img :src="delica.image_photo_url" :alt="delica.name" class="object-cover group-hover:opacity-75" />
                                <button type="button" class="absolute inset-0 focus:outline-none">
                                    <span class="sr-only">View details for {{ delica.name }}</span>
                                </button>
                            </div>
                            <p class="mt-2 block truncate text-sm font-medium text-gray-900">{{ delica.code }}</p>
                            <p class="pointer-events-none block text-sm font-medium text-gray-500">{{ delica.name }}</p>
                        </li>
                    </ul>
                    <div v-if="delicas.length === 0">
                        No delicas match your search or you dont have any delicas created yet.
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <TransitionRoot as="template" :show="open">
    <Dialog as="div" class="relative z-10" @close="open = false">
      <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>
      <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
          <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
            <TransitionChild as="template" enter="transform transition ease-in-out duration-500 sm:duration-700" enter-from="translate-x-full" enter-to="translate-x-0" leave="transform transition ease-in-out duration-500 sm:duration-700" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="pointer-events-auto relative w-96">
                <TransitionChild as="template" enter="ease-in-out duration-500" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-500" leave-from="opacity-100" leave-to="opacity-0">
                  <div class="absolute left-0 top-0 -ml-8 flex pr-2 pt-4 sm:-ml-10 sm:pr-4">
                    <button type="button" class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white" @click="open = false">
                      <span class="sr-only">Close panel</span>
                      <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                    </button>
                  </div>
                </TransitionChild>
                <div class="h-full overflow-y-auto bg-white p-8">
                  <div class="space-y-6 pb-16">
                    <div>
                      <div class="aspect-h-7 aspect-w-10 block w-full overflow-hidden rounded-lg">
                        <img :src="selectedDelica.image_photo_url" alt="" class="object-cover" />
                      </div>
                      <div class="mt-4 flex items-start justify-between">
                        <div>
                          <h2 class="text-base font-semibold leading-6 text-gray-900"><span class="sr-only">Details for </span>{{ selectedDelica.code }}</h2>
                          <p class="text-sm font-medium text-gray-500">{{ selectedDelica.name }}</p>
                        </div>
                        <div class="">
                            <img :src="selectedDelica.image_color_url" alt="" class="rounded-lg h-20 w-20" />
                        </div>
                      </div>
                    </div>
                    <div>
                      <h3 class="font-medium text-gray-900">Information</h3>
                      <dl class="mt-2 divide-y divide-gray-200 border-b border-t border-gray-200">
                        <div class="flex justify-between py-3 text-sm font-medium">
                          <dt class="text-gray-500">Color</dt>
                          <dd class="text-gray-900">{{ selectedDelica.color }}</dd>
                        </div>
                        <div class="flex justify-between py-3 text-sm font-medium">
                          <dt class="text-gray-500">Size</dt>
                          <dd class="text-gray-900">{{ selectedDelica.size }}</dd>
                        </div>
                        <div v-if="selectedDelica.finish" class="flex justify-between py-3 text-sm font-medium">
                          <dt class="text-gray-500">Finish</dt>
                          <dd class="text-gray-900">{{ selectedDelica.finish }}</dd>
                        </div>
                        <div class="flex justify-between py-3 text-sm font-medium">
                          <dt class="text-gray-500">Shape</dt>
                          <dd class="text-gray-900">{{ selectedDelica.shape }}</dd>
                        </div>
                        <div class="flex justify-between py-3 text-sm font-medium">
                          <dt class="text-gray-500">Material</dt>
                          <dd class="text-gray-900">{{ selectedDelica.material }}</dd>
                        </div>
                      </dl>
                    </div>
                  </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
