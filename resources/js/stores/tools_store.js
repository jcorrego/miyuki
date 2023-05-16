import { defineStore } from 'pinia'

export const useToolsStore = defineStore('tools', {
    state: () => ({ guides: false, delica: null }),
    getters: {},
    actions: {
      setDelica(selectedDelica) {
        this.delica = selectedDelica
      },
      toggleGuides() {
        this.guides = !this.guides
      },
    },
})
