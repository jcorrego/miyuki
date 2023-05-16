<script setup >
  import { useToolsStore } from '@/stores/tools_store'
  const store = useToolsStore()

  const props = defineProps({ delicas: Object })

  const bgClasses = (delica) => {
    let classes = '';
    if (store.delica !== null && delica.id === store.delica.id) {
      classes += 'border-black';
    }
    else {
      classes += 'border-gray-300';
    }

    classes += ` bg-red from-red-400 via-red-500 to-red-900`;

    return classes;
  };
</script>

<template>
  <div class="flex flex-col bg-slate-50 border mb-4">
    <div class="flex p-4 items-center w-full justify-center ">

      <ul role="list" class="grid grid-cols-4 gap-x-4 gap-y-8 sm:grid-cols-6 sm:gap-x-6 lg:grid-cols-8 xl:gap-x-8">
          <li v-for="delica in delicas" :key="delica.id" @click="$emit('delicaSelected', delica)" class="flex cursor-pointer items-center bg-white border p-1 rounded-md" :class="bgClasses(delica)">
              <img :src="delica.image_photo_url" :alt="delica.name" class="object-none group-hover:opacity-75 h-10 w-10 rounded-md" />
              <span class="ml-2 text-sm font-medium text-gray-500">{{ delica.code }}</span>
          </li>
      </ul>
      <div v-if="delicas.length === 0">
          No delicas match your search or you dont have any delicas created yet.
      </div>
    </div>
  </div>
</template>
