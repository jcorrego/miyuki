import { defineStore } from 'pinia'

export const useCurrentColorStore = defineStore('currentColor', {
    state: () => ({ color: 'white', guides: false, delica: null }),
    getters: {},
    actions: {
      setColor(selectedColor) {
        this.color = selectedColor
      },
      setDelica(selectedDelica) {
        this.delica = selectedDelica
      },
      toggleGuides() {
        this.guides = !this.guides
      },
    },
})
