import { defineStore } from 'pinia'

export const useCurrentColorStore = defineStore('currentColor', {
    state: () => ({ color: 'white', guides: false }),
    getters: {},
    actions: {
      setColor(selectedColor) {
        this.color = selectedColor
      },
      toggleGuides() {
        this.guides = !this.guides
      },
    },
})
