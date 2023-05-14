<script setup >
  import { computed, ref } from 'vue';
  const props = defineProps({ color: 'white' })

  const bgClasses = computed(() => {
    if (props.color !== 'white') {
      return `from-${props.color}-400 via-${props.color}-500 to-${props.color}-900`;
    }
    return 'from-gray-50 via-white to-gray-300';
  });

</script>

<template>
    <div
      class="border border-gray-300 rounded-sm h-full w-full bg-gradient-to-r mr-1"
      :class="bgClasses"
    >
        <div class="w-full h-full"></div>
    </div>
</template>
