<script setup >
  import { computed, ref } from 'vue';
  import { useCurrentColorStore } from '@/stores/color_store'
  const store = useCurrentColorStore()

  const isActive = ref(false);

  const color = ref('white');

  const bgClasses = computed(() => {
    if (color.value !== 'white' && isActive.value) {
      return `from-${color.value}-400 via-${color.value}-500 to-${color.value}-900`;
    }
    return 'from-gray-50 via-white to-gray-300';
  });

  const setColor = (activeColor) => {
    color.value = activeColor;
  };

  const handleClick = () => {
    isActive.value = !isActive.value;
    if (isActive.value) {
      setColor(store.color)
    }
    else {
      setColor('white')
    }
  };

</script>

<template>
    <div
      class="border border-gray-300 rounded-sm cursor-pointer h-full w-full bg-gradient-to-b mr-1"
      :class="bgClasses"
      @click="handleClick"
    >
        <div class="w-full h-full"></div>
    </div>
</template>
