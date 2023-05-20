<script setup >
  import { useToolsStore } from '@/stores/tools_store'
  import { CursorArrowRaysIcon, PaintBrushIcon, PlusCircleIcon, MinusCircleIcon, XCircleIcon,
    ArrowRightOnRectangleIcon,
    DocumentDuplicateIcon,
    ClipboardDocumentIcon
   } from '@heroicons/vue/20/solid'
  import { Link } from '@inertiajs/vue3';
  const store = useToolsStore()

  const props = defineProps({ delicas: Object })

  const bgClasses = (delica) => {
    let classes = '';
    if (store.delica !== null && delica.id === store.delica.id) {
      classes += 'bg-indigo-500 text-white';
    }
    else {
      classes += 'bg-white text-gray-500';
    }

    return classes;
  };

  function clearSelection($emit) {
    store.setSelectTool('clear');
    $emit('clear-selection');
    setTimeout(addSelectTool, 500);
  }
  function addSelectTool() {
    store.setSelectTool('add');
  }

  function mirrorSelection($emit) {
    store.setSelectTool('mirror');
    $emit('mirror-selection');
    setTimeout(addSelectTool, 500);
  }

  function copySelection($emit) {
    store.setSelectTool('copy');
    $emit('copy-selection');
    setTimeout(addSelectTool, 500);
  }
  function pasteSelection($emit) {
    store.setSelectTool('paste');
    $emit('paste-selection');
    setTimeout(addSelectTool, 500);
  }
</script>

<template>
  <div class="flex gap-2 p-2 bg-slate-200 border mb-4 rounded-md">
    <div
      @click="store.activateTool('select')"
      class="flex cursor-pointer items-center justify-center p-1 rounded-md border-2 h-10 w-10"
      :class="[store.tool === 'select' ? 'bg-indigo-500 text-white border-indigo-500': 'bg-white border-gray-300']">
      <CursorArrowRaysIcon class="h-5 w-5" aria-hidden="true" />
    </div>
    <div
      @click="store.activateTool('paint')"
      class="flex cursor-pointer items-center justify-center p-1 rounded-md border-2 h-10 w-10"
      :class="[store.tool === 'paint' ? 'bg-indigo-500 text-white border-indigo-500': 'bg-white border-gray-300']">
      <PaintBrushIcon class="h-5 w-5" aria-hidden="true" />
    </div>
    <div class="border-r border-gray-300 h-10 w-1"></div>
    <div v-if="store.tool === 'paint'" class=" flex-1">
      <div v-if="Object.keys(delicas).length > 0" class="flex flex-wrap gap-2 items-center h-full">
        <div v-for="delica in delicas" :key="delica.id" @click="store.setDelica(delica)" class="flex cursor-pointer items-center rounded-md" :class="bgClasses(delica)">
              <div class="h-10 w-10 rounded-md group-hover:opacity-75" :style="'background-color:' + delica.rgb + ';'"></div>
              <div class="flex flex-col justify-center items-start text-xs h-10 leading-none rounded-r-md border border-l-0 px-2">
                <div class="font-semibold text-sm">{{ delica.code }}</div>
                <div>{{ delica.count }} beads</div>
              </div>
        </div>
      </div>
      <div v-else class="text-gray-500 flex items-center h-full">
          <span>No delicas are associated with this proyect yet. Go to <Link class="text-indigo-500" :href="route('delicas.index')">Delicas</Link> list.</span>
      </div>
    </div>
    <div v-if="store.tool === 'select'" class="h-10 flex-1">
      <div class="flex gap-2 items-center h-full">
        <div
          @click="store.setSelectTool('add')"
          class="flex gap-1 cursor-pointer items-center justify-center p-1 rounded-md border-2 h-10 "
          :class="[store.selectTool === 'add' ? 'bg-indigo-400 text-white border-indigo-400': 'bg-white text-gray-400 border-gray-300']">
          <PlusCircleIcon class="h-5 w-5" aria-hidden="true" />
          Add
        </div>
        <div
          @click="store.setSelectTool('minus')"
          class="flex gap-1 cursor-pointer items-center justify-center p-1 rounded-md border-2 h-10"
          :class="[store.selectTool === 'minus' ? 'bg-indigo-400 text-white border-indigo-400': 'bg-white text-gray-400 border-gray-300']">
          <MinusCircleIcon class="h-5 w-5" aria-hidden="true" />
          Remove
        </div>
        <div class="border-r border-gray-300 h-10 w-1"></div>
        <div
          @click="clearSelection($emit)"
          class="flex gap-1 cursor-pointer items-center justify-center p-1 rounded-md border-2 h-10"
          :class="[store.selectTool === 'clear' ? 'bg-indigo-400 text-white border-indigo-400': 'bg-white text-gray-400 border-gray-300']">
          <XCircleIcon class="h-5 w-5" aria-hidden="true" />
          Clear
        </div>
        <div
          @click="mirrorSelection($emit)"
          class="flex gap-1 cursor-pointer items-center justify-center p-1 rounded-md border-2 h-10"
          :class="[store.selectTool === 'mirror' ? 'bg-indigo-400 text-white border-indigo-400': 'bg-white text-gray-400 border-gray-300']">
          <ArrowRightOnRectangleIcon class="h-5 w-5" aria-hidden="true" />
          Mirror
        </div>
        <div
          @click="copySelection($emit)"
          class="flex gap-1 cursor-pointer items-center justify-center p-1 rounded-md border-2 h-10"
          :class="[store.selectTool === 'copy' ? 'bg-indigo-400 text-white border-indigo-400': 'bg-white text-gray-400 border-gray-300']">
          <DocumentDuplicateIcon class="h-5 w-5" aria-hidden="true" />
          Copy
        </div>
        <div
          @click="pasteSelection($emit)"
          class="flex gap-1 cursor-pointer items-center justify-center p-1 rounded-md border-2 h-10"
          :class="[store.selectTool === 'paste' ? 'bg-indigo-400 text-white border-indigo-400': 'bg-white text-gray-400 border-gray-300']">
          <ClipboardDocumentIcon class="h-5 w-5" aria-hidden="true" />
          Paste
        </div>
      </div>
    </div>

  </div>
</template>
