<script setup >
  import { computed, ref } from 'vue';
  const props = defineProps({ delica: null })

</script>

<template>
    <div
      class="border border-gray-300 rounded-xs h-full w-full mr-1"
    >
        <div class="w-full h-full relative">
          <div class="h-full w-full absolute z-10 rounded-xs bg-gradient-to-r from-gray-50 via-white to-black opacity-25"></div>
          <img v-if="delica" :src="delica.image_color_url" :alt="delica.name" class="object-none rounded-xs z-0 h-full w-full" />
        </div>
    </div>
</template>
