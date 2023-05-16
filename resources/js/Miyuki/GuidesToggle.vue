<script setup >
  import { ref, watch } from 'vue';
  import { Switch, SwitchDescription, SwitchGroup, SwitchLabel } from '@headlessui/vue'
  import { useToolsStore } from '@/stores/tools_store'
  const store = useToolsStore()
  const guides = ref(false);
  watch(guides, async (newValue, oldValue) => {
    store.toggleGuides()
  })
</script>

<template>
  <SwitchGroup as="div" class="flex flex-col justify-between h-full">
    <SwitchLabel as="span" class="text-xs font-medium text-gray-500 text-right" passive>Show guides</SwitchLabel>
    <Switch @change="store.toggleGuides()" v-model="guides" :class="[guides ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
      <span aria-hidden="true" :class="[guides ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
    </Switch>
  </SwitchGroup>
</template>
