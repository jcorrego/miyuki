<script setup >
  import { ref, watch } from 'vue';
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
  watch(() => props.initialDelica, (newDelica, oldDelica) => {
    if (newDelica !== null) {
      if (oldDelica !== null &&  newDelica.id !== oldDelica.id) {
        delica.value = newDelica
      }

      return
      if (newDelica.id !== oldDelica.id) {
        delica.value = newDelica
      }
    }



  })

</script>

<template>
    <div
      class="border border-gray-300 rounded-sm cursor-pointer h-full w-full mr-1"
      @click="handleClick()"
      @dblclick="handleDoubleClick()"
    >
        <div class="w-full h-full">
          <div v-if="delica && delica.rgb" class="h-full w-full rounded-sm flex items-center justify-center hover:opacity-75" :style="'background-color:' + delica.rgb + ';'">
              <span v-if="store.guides && badge" class="px-0.5 text-2xs bg-stone-600 rounded leading-none text-gray-300 font-semibold">{{ badge }}</span>
          </div>
        </div>
    </div>
</template>
