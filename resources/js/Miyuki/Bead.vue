<script setup >
  import { computed, ref } from 'vue';
  import { useCurrentColorStore } from '@/stores/color_store'
  const store = useCurrentColorStore()
  const props = defineProps({ initialColor: 'white' })
  const isActive = ref(props.initialColor != 'white');
  const color = ref(props.initialColor)

  const bgClasses = computed(() => {
    if (color.value !== 'white' && isActive.value) {
      return `from-${color.value}-400 via-${color.value}-500 to-${color.value}-900`;
    }
    return 'from-gray-50 via-white to-gray-300';
  });

  const setColor = (activeColor) => {
    color.value = activeColor;
  };

  const handleClick = ($emit) => {
    isActive.value = !isActive.value;
    let color = 'white'
    if (isActive.value) {
      color = store.color
    }
    setColor(color)
    $emit('setColor', color)
  };

</script>

<template>
    <div
      class="border border-gray-300 rounded-sm cursor-pointer h-full w-full bg-gradient-to-r mr-1"
      :class="bgClasses"
      @click="handleClick($emit)"
    >
        <div class="w-full h-full"></div>
    </div>
</template>
