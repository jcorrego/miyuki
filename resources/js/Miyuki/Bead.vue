<script setup >
  import { ref } from 'vue';
  import { useToolsStore } from '@/stores/tools_store'
  const store = useToolsStore()
  const props = defineProps({ initialDelica: null, badge: null })
  const delica = ref(props.initialDelica)

  const handleClick = () => {
    if (store.tool === 'paint' && store.delica !== null) {
      delica.value = store.delica
    }
  };
  const handleDoubleClick = () => {
    delica.value = null
  };

</script>

<template>
    <div
      class="border border-gray-300 rounded-sm cursor-pointer h-full w-full mr-1"
      @click="handleClick()"
      @dblclick="handleDoubleClick()"
    >
        <div class="w-full h-full relative">
          <div class="h-full w-full absolute z-10 rounded-sm bg-gradient-to-r from-gray-50 via-white to-black opacity-25"></div>
          <div v-if="delica && delica.rgb" class="h-full w-full absolute z-10 rounded-sm" :style="'background-color:' + delica.rgb + ';'"></div>
          <div v-if="store.guides && badge" class="left-1 px-0.5 text-2xs bg-stone-600 rounded text-center leading-none align-middle text-gray-300 font-semibold absolute top-0.5">{{ badge }}</div>
        </div>
    </div>
</template>
