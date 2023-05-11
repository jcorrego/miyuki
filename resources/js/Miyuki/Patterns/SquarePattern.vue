<script setup >
  import { ref } from 'vue';
  import Bead from '@/Miyuki/Bead.vue';
  const rows = ref(7);
  const cols = ref(40);
</script>

<template>
  <div class="p-4 w-full border mb-4 justify-center bg-slate-50">
    <div class="flex p-4 items-center w-full justify-center">
      <div class="isolate -space-y-px rounded-md shadow-sm bg-white w-24">
        <div class="relative rounded-md rounded-b-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
          <label for="cols" class="block text-xs font-medium text-gray-500">Longitude</label>
          <input v-model.number="cols" type="number" name="cols" id="cols" class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right" placeholder="How long is the bracelet" />
        </div>
        <div class="relative rounded-md rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
          <label for="rows" class="block text-xs font-medium text-gray-500">Width</label>
          <input v-model.number="rows" type="number" name="rows" id="rows" class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 text-right" placeholder="Width of the bracelet" />
        </div>
      </div>
    </div>

    <div class="flex justify-center gap-px">
      <div class="w-4 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"></div>
      <div v-for="col in cols" :key="'col-' + col" class="gap-px flex flex-col">
        <div v-for="row in rows" :key="'row-' + row" class="h-4 w-4">
          <Bead :key="row + '-' + col" />
        </div>
      </div>
      <div class="w-4 bg-gradient-to-r from-slate-300 via-slate-100 to-slate-400"></div>
    </div>
  </div>
</template>
