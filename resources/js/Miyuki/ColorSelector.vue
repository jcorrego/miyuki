<script setup >
  import { ref } from 'vue';
  import { useCurrentColorStore } from '@/stores/color_store'
  const store = useCurrentColorStore()

  const colors = ref(['white', 'slate', 'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose']);
  const classes = ref([
    'from-slate-400', 'via-slate-500', 'to-slate-900',
    'from-red-400', 'via-red-500', 'to-red-900',
    'from-orange-400', 'via-orange-500', 'to-orange-900',
    'from-amber-400', 'via-amber-500', 'to-amber-900',
    'from-yellow-400', 'via-yellow-500', 'to-yellow-900',
    'from-lime-400', 'via-lime-500', 'to-lime-900',
    'from-green-400', 'via-green-500', 'to-green-900',
    'from-emerald-400', 'via-emerald-500', 'to-emerald-900',
    'from-teal-400', 'via-teal-500', 'to-teal-900',
    'from-cyan-400', 'via-cyan-500', 'to-cyan-900',
    'from-sky-400', 'via-sky-500', 'to-sky-900',
    'from-blue-400', 'via-blue-500', 'to-blue-900',
    'from-indigo-400', 'via-indigo-500', 'to-indigo-900',
    'from-violet-400', 'via-violet-500', 'to-violet-900',
    'from-purple-400', 'via-purple-500', 'to-purple-900',
    'from-fuchsia-400', 'via-fuchsia-500', 'to-fuchsia-900',
    'from-pink-400', 'via-pink-500', 'to-pink-900',
    'from-rose-400', 'via-rose-500', 'to-rose-900',
  ]);
  const bgClasses = (color) => {
    let classes = '';
    if (color == store.color) {
      classes += 'border-black';
    }
    else {
      classes += 'border-gray-300';
    }
    if (color === 'white') {
      classes += ' from-gray-50 via-white to-gray-300';
    }
    else {
      classes += ` bg-${color} from-${color}-400 via-${color}-500 to-${color}-900`;
    }
    return classes;
  };
</script>

<template>
  <div class="flex p-4 items-center w-full border mb-4 justify-center bg-slate-50">
    <div class="mr-2 text-gray-600 text-sm">Pick a color:</div>
    <div v-for="color in colors" :key="color" @click="$emit('colorSelected', color)" class="border rounded-md cursor-pointer h-8 w-8 bg-gradient-to-b" :class="bgClasses(color)"></div>
  </div>
</template>
