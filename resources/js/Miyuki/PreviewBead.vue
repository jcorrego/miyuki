<script setup >
  import { computed, ref } from 'vue';
  const props = defineProps({ delica: null })

</script>

<template>
    <div
      class="border border-gray-300 rounded-xs h-full w-full mr-1"
    >
        <div class="w-full h-full relative">
          <div class="h-full w-full absolute z-10 rounded-xs bg-gradient-to-r from-gray-50 via-white to-black opacity-10"></div>
          <div v-if="delica && delica.rgb" class="h-full w-full absolute z-0 rounded-sm" :style="'background-color:' + delica.rgb + ';'"></div>
        </div>
    </div>
</template>
