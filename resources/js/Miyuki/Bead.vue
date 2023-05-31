<script setup >
  const props = defineProps({ color: '#fff', badge: null })
</script>

<template>
    <div class="border border-gray-300 rounded-sm cursor-pointer h-full w-full mr-1">
      <div class="h-full w-full rounded-sm flex items-center justify-center hover:opacity-75" :style="'background-color:' + props.color + ';'">
          <span v-if="props.badge" class="px-0.5 text-2xs bg-stone-600 rounded leading-none text-gray-300 font-semibold">{{ props.badge }}</span>
      </div>
    </div>
</template>
