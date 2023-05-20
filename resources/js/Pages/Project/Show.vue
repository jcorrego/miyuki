<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import GuidesToggle from '@/Miyuki/GuidesToggle.vue';
import Toolbox from '@/Miyuki/Toolbox.vue';
import Bead from '@/Miyuki/Bead.vue';
import PreviewBead from '@/Miyuki/PreviewBead.vue';
import { ref, computed } from 'vue';

import { useToolsStore } from '@/stores/tools_store'
const store = useToolsStore()

const props = defineProps({ project: Object, beads: Object, delicas: Object })
const rows = ref(props.project.width);
const cols = ref(props.project.long);
const type = ref(props.project.type);
const name = ref(props.project.name);
const beads = ref(props.beads)
const zoom = ref(2);
const isSelecting = ref(false)
const selectedBeads = ref([])

const zoomClasses = computed(() => {
    console.log(zoom.value)
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

const getInitialDelica = (row, col) => {
    if (beads.value.hasOwnProperty(row + '-' + col)) {
        return beads.value[row + '-' + col]
    }
    return null
}
const getDelicaBadge = (row, col) => {
   if (!beads.value.hasOwnProperty(row + '-' + col)) {
       return null;
    }
    let delica = beads.value[row + '-' + col]
    return delica.badge
}

const beadUpdateForm = useForm({
    bead_row: null,
    bead_col: null,
    bead_delica: null
})
const projectUpdateForm = useForm({
    width: null,
    long: null,
    type: null,
    name: null,
})

function submitBeadForm(delica_id, row, col) {
    beadUpdateForm.bead_row = row
    beadUpdateForm.bead_col = col
    beadUpdateForm.bead_delica = delica_id
    beadUpdateForm.put('/projects/' + props.project.id, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            beads.value = page.props.beads
        },
    });
}

function submitProjectForm() {
    projectUpdateForm.width = rows
    projectUpdateForm.long = cols
    projectUpdateForm.type = type
    projectUpdateForm.name = name
    projectUpdateForm.put('/projects/' + props.project.id, {
        preserveState: true,
        preserveScroll: true,
    });
}

function handleClick(row, col) {
    if (store.tool === 'paint' && store.delica !== null) {
        submitBeadForm(store.delica.id, row, col)
    }
}

function handleDoubleClick(row, col) {
    submitBeadForm(null, row, col)
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
    store.clipboard = selectedBeads.value
    selectedBeads.value = []
}
function pasteSelection() {
    // Get the first bead in the current selection
    let firstBead = selectedBeads.value[0]
    let pasteRow = firstBead.split('-')[0]
    let pasteCol = firstBead.split('-')[1]
    store.clipboard.forEach(function (item) {
        let row = item.split('-')[0]
        let col = item.split('-')[1]
        if (beads.value.hasOwnProperty(row + '-' + col)) {
            submitBeadForm(beads.value[row + '-' + col].id, pasteRow, pasteCol)
        }
        else {
            submitBeadForm(null, pasteRow, pasteCol)
        }
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
                        <div class="relative rounded-md rounded-l-none rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-24">
                            <label for="cols" class="block text-xs font-medium text-gray-500 text-right">Longitude</label>
                            <input v-model.number="cols" @change="submitProjectForm" type="number" name="cols" id="cols"
                            class="mt-2 block w-full border-0 p-0 py-1.5 pl-3 pr-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right"
                            placeholder="How long is the bracelet" />
                        </div>
                        <div class="relative rounded-md rounded-l-none rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-24">
                            <label for="rows" class="block text-xs font-medium text-gray-500 text-right">Width</label>
                            <input v-model.number="rows" @change="submitProjectForm" type="number" name="rows" id="rows"
                                class="mt-2 block w-full border-0 p-0 py-1.5 pl-3 pr-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right"
                                placeholder="Width of the bracelet" />
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
                        <div class="w-5 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"><div class="h-5 w-6"></div></div>
                        <div class="relative">
                            <div v-if="store.guides" class="absolute -top-5" >
                                <div class="gap-px flex text-xs text-gray-400 leading-none">
                                    <div v-for="col in cols" :key="'guides-col-' + col" class="flex items-center justify-center h-5" :class="zoomClasses">
                                        <div class="text-center">{{ col }}</div>
                                    </div>
                                </div>
                            </div>
                            <div v-for="row in rows" :key="'row-' + row" class="gap-px flex select-none" :class="{'ml-2': type === 'Peyote' && row % 2 == 0}">
                                <div v-for="col in cols" :key="'col-' + col" :class="[isSelected(row, col) ? 'border-2 border-indigo-500' : '', zoomClasses]">
                                    <Bead :key="row + '-' + col"
                                        :initial-delica="getInitialDelica(row, col)"
                                        :badge="getDelicaBadge(row, col)"
                                        @click="handleClick(row, col)"
                                        @dblclick="handleDoubleClick(row, col)"
                                        @mousedown="handleMouseDown(row, col)"
                                        @mouseup="handleMouseUp(row, col)"
                                        @mouseover="handleMouseOver(row, col)"
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="w-5 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"><div class="h-5 w-6"></div></div>
                    </div>
                </div>
                <div class="p-4 w-full border mb-4 justify-center bg-slate-50 overflow-x-auto">
                    <div class="flex justify-center">
                        <div class="w-4 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"><div class="h-4 w-5"></div></div>
                        <div>
                            <div v-for="row in rows" :key="'row-' + row" class="gap-px flex" :class="{'ml-1': type === 'Peyote' && row % 2 == 0}">
                                <div v-for="col in cols" :key="'col-' + col" class="h-2 w-2.5">
                                    <PreviewBead :key="row + '-' + col" :delica="getInitialDelica(row, col)"/>
                                </div>
                            </div>
                        </div>
                        <div class="w-4 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"><div class="h-4 w-5"></div></div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
