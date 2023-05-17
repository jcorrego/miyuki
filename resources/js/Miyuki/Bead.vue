<script setup >
  import { computed, ref } from 'vue';
  import { useToolsStore } from '@/stores/tools_store'
  const store = useToolsStore()
  const props = defineProps({ initialDelica: null, badge: null })
  const delica = ref(props.initialDelica)
  // const badge = ref(props.badge)

  const handleClick = ($emit) => {
    if (store.delica !== null && (delica.value === null || store.delica.id !== delica.value.id)) {
      delica.value = store.delica
      $emit('setDelica', delica.value.id)
    }
  };
  const handleDoubleClick = ($emit) => {
    delica.value = null
    $emit('setDelica',null)
  };

</script>

<template>
    <div
      class="border border-gray-300 rounded-sm cursor-pointer h-full w-full mr-1"
      @click="handleClick($emit)"
      @dblclick="handleDoubleClick($emit)"
    >
        <div class="w-full h-full relative">
          <div class="h-full w-full absolute z-10 rounded-sm bg-gradient-to-r from-gray-50 via-white to-black opacity-25"></div>
          <img v-if="delica" :src="delica.image_color_url" :alt="delica.name" class="object-none rounded-sm z-0 h-full w-full" />
          <div v-if="store.guides && badge" class="left-1 px-0.5 text-2xs bg-gray-400/10 rounded text-center leading-none align-middle text-gray-300 font-semibold absolute top-0.5">{{ badge }}</div>
        </div>
    </div>
</template>
