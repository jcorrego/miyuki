import { defineStore } from 'pinia'

export const useCurrentColorStore = defineStore('currentColor', {
    state: () => ({ color: 'white' }),
    getters: {},
    actions: {
      setColor(selectedColor) {
        this.color = selectedColor
      },
    },
})
