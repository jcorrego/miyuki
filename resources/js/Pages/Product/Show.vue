<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ColorSelector from '@/Miyuki/ColorSelector.vue';
import Bead from '@/Miyuki/Bead.vue';
import { ref } from 'vue';

import { useCurrentColorStore } from '@/stores/color_store'
const store = useCurrentColorStore()

const props = defineProps({ product: Object, beads: Object })
const rows = ref(props.product.width);
const cols = ref(props.product.long);
const type = ref(props.product.type);
const name = ref(props.product.name);

const getInitialColor = (row, col) => {
    if (props.beads.hasOwnProperty(row + '-' + col)) {
        return props.beads[row + '-' + col]
    }
    return 'white'
}

const beadUpdateForm = useForm({
    bead_row: null,
    bead_col: null,
    bead_color: 'white'
})
const productUpdateForm = useForm({
    width: null,
    long: null,
    type: null,
    name: null,
})

function submitBeadForm(color, row, col) {
    beadUpdateForm.bead_row = row
    beadUpdateForm.bead_col = col
    beadUpdateForm.bead_color = color
    beadUpdateForm.put('/products/' + props.product.id, {
        preserveState: true
    });
}
function submitProductForm() {
    productUpdateForm.width = rows
    productUpdateForm.long = cols
    productUpdateForm.type = type
    productUpdateForm.name = name
    productUpdateForm.put('/products/' + props.product.id, {
        preserveState: true
    });
}

</script>

<template>
    <Head title="Product Details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ product.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <ColorSelector  @color-selected="(color) => store.setColor(color)"/>
                    <div class="p-4 w-full border mb-4 justify-center bg-slate-50 overflow-x-auto">
                        <div class="flex p-4 items-center w-full justify-center">
                            <div class="isolate flex -space-x-px rounded-md shadow-sm bg-white">
                                <div class="relative rounded-md rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-24">
                                    <label for="cols" class="block text-xs font-medium text-gray-500 text-right">Longitude</label>
                                    <input v-model.number="cols" @change="submitProductForm" type="number" name="cols" id="cols"
                                    class="mt-2 block w-full border-0 p-0 py-1.5 pl-3 pr-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right"
                                    placeholder="How long is the bracelet" />
                                </div>
                                <div class="relative rounded-md rounded-l-none rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-24">
                                    <label for="rows" class="block text-xs font-medium text-gray-500 text-right">Width</label>
                                    <input v-model.number="rows" @change="submitProductForm" type="number" name="rows" id="rows"
                                        class="mt-2 block w-full border-0 p-0 py-1.5 pl-3 pr-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right"
                                        placeholder="Width of the bracelet" />
                                </div>
                                <div class="relative rounded-md rounded-l-none rounded-r-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-36">
                                    <label for="type" class="block text-xs font-medium text-gray-500 text-right">Type</label>
                                    <select v-model="type" id="type" name="type" @change="submitProductForm"
                                        class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option value="Square">Square</option>
                                        <option value="Peyote">Peyote</option>
                                    </select>
                                </div>
                                <div class="relative rounded-md rounded-l-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600 flex flex-col justify-between w-64">
                                    <label for="rows" class="block text-xs font-medium text-gray-500 text-right">Name</label>
                                    <input v-model="name" @change="submitProductForm" type="text" name="name" id="name"
                                        class="mt-2 block w-full border-0 p-0 py-1.5 pl-3 pr-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right"
                                        placeholder="Name of this product" />
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <div class="w-4 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"></div>
                            <div>
                                <div v-for="row in rows" :key="'row-' + row" class="gap-px flex" :class="{'ml-2': type === 'Peyote' && row % 2 == 0}">
                                    <div v-for="col in cols" :key="'col-' + col" class="h-3 w-4">
                                        <Bead :key="row + '-' + col" @set-color="(color) =>submitBeadForm(color, row, col)" :initial-color="getInitialColor(row, col)"/>
                                    </div>
                                </div>
                            </div>
                            <div class="w-4 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
