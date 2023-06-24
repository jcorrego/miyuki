<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import GuidesToggle from '@/Miyuki/GuidesToggle.vue';
import Toolbox from '@/Miyuki/Toolbox.vue';
import Bead from '@/Miyuki/Bead.vue';
import { ref, computed } from 'vue';
import { Switch } from '@headlessui/vue'

import { useToolsStore } from '@/stores/tools_store'
const store = useToolsStore()

const props = defineProps({ project: Object, delicas: Object, items: Object })
const rows = ref(props.project.width);
const cols = ref(props.project.long);
const addRight = ref(true);
const addBottom = ref(true);
const type = ref(props.project.type);
const name = ref(props.project.name);
const zoom = ref(2);
const isSelecting = ref(false)
const selectedBeads = ref([])

const zoomClasses = computed(() => {
    if (zoom.value == 1){
        return 'h-4 w-5'
    }
    else if (zoom.value == 2){
        return 'h-5 w-6'
    }
    else if (zoom.value == 3){
        return 'h-6 w-7'
    }
    return 'h-5 w-6'
})


const isSelected = (row, col) => {
    return selectedBeads.value.includes(row + '-' + col)
}

const projectUpdateForm = useForm({
    width: null,
    bottom: true,
    long: null,
    right: true,
    type: null,
    name: null,
})

function submitProjectForm() {
    projectUpdateForm.width = rows
    projectUpdateForm.bottom = addBottom
    projectUpdateForm.long = cols
    projectUpdateForm.right = addRight
    projectUpdateForm.type = type
    projectUpdateForm.name = name
    projectUpdateForm.put('/projects/' + props.project.id, {
        preserveScroll: true,
    });
}

function handleClick(row, col) {
    if (store.tool === 'paint' && store.delica !== null) {
        router.patch('/projects/' + props.project.id + '/beads/' + row + '/' + col,
            {
                delica_id: store.delica.id
            },
            {
                preserveScroll: true,
                only: ['items', 'delicas'],
            })
    }
}

function handleDoubleClick(row, col) {
    router.delete('/projects/' + props.project.id + '/beads/' + row + '/' + col, {
        preserveScroll: true,
        only: ['items', 'delicas'],
    })
}

function handleMouseDown(row, col) {
    if (store.tool === 'select') {
        isSelecting.value = true
        if (store.selectTool === 'add'){
            if (!selectedBeads.value.includes(row + '-' + col)) {
                selectedBeads.value.push(row + '-' + col)
            }
        }
        else {
            if (selectedBeads.value.includes(row + '-' + col)) {
                selectedBeads.value = selectedBeads.value.filter(item => item !== row + '-' + col)
            }
        }
    }
}

function handleMouseUp(row, col) {
    if (store.tool === 'select') {
        isSelecting.value = false
    }
}

function handleMouseOver(row, col) {
    if (store.tool === 'select' && isSelecting.value) {
        if (store.selectTool === 'add'){
            if (!selectedBeads.value.includes(row + '-' + col)) {
                selectedBeads.value.push(row + '-' + col)
            }
        }
        else {
            if (selectedBeads.value.includes(row + '-' + col)) {
                selectedBeads.value = selectedBeads.value.filter(item => item !== row + '-' + col)
            }
        }
    }
}

function mirrorSelection() {
    let newSelectedBeads = []
    selectedBeads.value.forEach(function (item) {
        let row = item.split('-')[0]
        let col = item.split('-')[1]
        let newRow = row
        let newCol = parseInt(cols.value) - parseInt(col) + 1
        newSelectedBeads.push(newRow + '-' + newCol)
    })
    selectedBeads.value = newSelectedBeads
}

function copySelection() {
    selectedBeads.value.sort(function (a, b) {
        let aRow = a.split('-')[0]
        let aCol = a.split('-')[1]
        let bRow = b.split('-')[0]
        let bCol = b.split('-')[1]
        if (aRow < bRow) {
            return -1
        }
        else if (aRow > bRow) {
            return 1
        }
        else {
            if (aCol < bCol) {
                return -1
            }
            else if (aCol > bCol) {
                return 1
            }
            else {
                return 0
            }
        }
    })
    store.clipboard = selectedBeads.value
    selectedBeads.value = []
}
function pasteSelection() {
    // Get the first bead in the current selection
    let firstBead = selectedBeads.value[0]
    let pasteRow = parseInt(firstBead.split('-')[0])
    let pasteCol = parseInt(firstBead.split('-')[1])

    store.clipboard.forEach(function (item) {
        let row = item.split('-')[0]
        let col = item.split('-')[1]
        // if (beads.value.hasOwnProperty(row + '-' + col)) {
        //     submitBeadForm(beads.value[row + '-' + col].id, pasteRow, pasteCol)
        // }
        // else {
        //     submitBeadForm(null, pasteRow, pasteCol)
        // }
        // let newCol = parseInt(cols.value) - parseInt(col) + 1
        // newSelectedBeads.push(newRow + '-' + newCol)
    })
    // selectedBeads.value = newSelectedBeads
}


</script>

<template>
    <Head title="Project Details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ project.name }}</h2>
        </template>

        <div class="max-w-full" @mouseup="handleMouseUp(row, col)">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
                <div class="flex items-center w-full justify-start mb-4">
                    <div class="isolate flex -space-x-px rounded-md shadow-sm bg-white">
                        <div class="relative rounded-md rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between">
                            <GuidesToggle/>
                        </div>
                        <div class="relative rounded-md rounded-l-none rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex w-32">
                            <div class="flex flex-col">
                                <label for="cols" class="block text-xs font-medium text-gray-500 text-right">Longitude</label>
                                <input v-model.number="cols" @change="submitProjectForm" type="number" name="cols" id="cols"
                                class="mt-2 block w-full border-0 p-0 py-1.5 pl-3 pr-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right"
                                placeholder="How long is the bracelet" />
                            </div>
                            <div class="flex flex-col justify-between">
                                <label for="rows" class="block text-xs font-medium text-gray-500 text-right">Side</label>
                                <Switch v-model="addRight" :class="[addRight ? 'bg-indigo-600' : 'bg-gray-200', 'relative mt-2 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
                                    <span class="sr-only">Add to the right</span>
                                    <span :class="[addRight ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
                                    <span :class="[addRight ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-gray-400">
                                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                        </svg>
                                    </span>
                                    <span :class="[addRight ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-indigo-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                        </svg>
                                    </span>
                                    </span>
                                </Switch>
                            </div>
                        </div>
                        <div class="relative rounded-md rounded-l-none rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex w-28">
                            <div class="flex flex-col">
                                <label for="rows" class="block text-xs font-medium text-gray-500 text-right">Width</label>
                                <input v-model.number="rows" @change="submitProjectForm" type="number" name="rows" id="rows"
                                    class="mt-2 block w-full border-0 p-0 py-1.5 pl-3 pr-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right"
                                    placeholder="Width of the bracelet" />
                            </div>
                            <div class="flex flex-col justify-between">
                                <label for="rows" class="block text-xs font-medium text-gray-500 text-right">Side</label>
                                <Switch v-model="addBottom" :class="[addBottom ? 'bg-indigo-600' : 'bg-gray-200', 'relative mt-2 inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
                                    <span class="sr-only">Add to the bottom</span>
                                    <span :class="[addBottom ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
                                    <span :class="[addBottom ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-gray-400">
                                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                    </span>
                                    <span :class="[addBottom ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out', 'absolute inset-0 flex h-full w-full items-center justify-center transition-opacity']" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-indigo-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </span>
                                    </span>
                                </Switch>
                            </div>
                        </div>
                        <div class="relative rounded-md rounded-l-none rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-36">
                            <label for="type" class="block text-xs font-medium text-gray-500 text-right">Type</label>
                            <select v-model="type" id="type" name="type" @change="submitProjectForm"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="Square">Square</option>
                                <option value="Peyote">Peyote</option>
                            </select>
                        </div>
                        <div class="relative rounded-md rounded-l-none rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-36">
                            <label for="zoom" class="block text-xs font-medium text-gray-500 text-right">Zoom</label>
                            <select v-model="zoom" id="zoom" name="type"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <option value="1">Small</option>
                                <option value="2">Medium</option>
                                <option value="3">Large</option>
                            </select>
                        </div>
                        <div class="relative rounded-md rounded-l-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-64">
                            <label for="rows" class="block text-xs font-medium text-gray-500 text-right">Name</label>
                            <input v-model="name" @change="submitProjectForm" type="text" name="name" id="name"
                                class="mt-2 block w-full border-0 p-0 py-1.5 pl-3 pr-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right"
                                placeholder="Name of this project" />
                        </div>

                    </div>
                </div>
                <Toolbox :delicas="delicas"
                    @clear-selection="selectedBeads = []"
                    @mirror-selection="mirrorSelection"
                    @copy-selection="copySelection"
                    @paste-selection="pasteSelection"
                 />
                <div class="py-5 w-full border mb-4 justify-center bg-slate-50 overflow-x-auto">
                    <div v-if="store.guides" class="absolute left-1 flex flex-col text-xs text-gray-400 leading-none">
                        <div v-for="row in rows" :key="'guides-row-' + row" class="flex items-center justify-center" :class="zoomClasses">
                            {{ row }}
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-5 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"></div>
                        <div class="relative">
                            <div v-if="store.guides" class="absolute -top-5" >
                                <div class="gap-px flex text-xs text-gray-400 leading-none">
                                    <div v-for="col in cols" :key="'guides-col-' + col" class="flex items-center justify-center h-5" :class="zoomClasses">
                                        <div class="text-center">{{ col }}</div>
                                    </div>
                                </div>
                            </div>
                            <div v-for="(cols, row) in items" :key="'row-' + row" class="gap-px flex select-none" :class="{'ml-3': type === 'Peyote' && row % 2 == 0}">
                                <div v-for="(item, col) in cols" :key="'col-' + col" :class="[isSelected(row, col) ? 'border-2 border-indigo-500' : '', zoomClasses]">
                                    <Bead :key="row + '-' + col"
                                        :color="item.rgb"
                                        :badge="store.guides ? item.badge : null"
                                        @click="handleClick(row, col)"
                                        @dblclick="handleDoubleClick(row, col)"
                                        @mousedown="handleMouseDown(row, col)"
                                        @mouseup="handleMouseUp(row, col)"
                                        @mouseover="handleMouseOver(row, col)"
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="w-5 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"></div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
