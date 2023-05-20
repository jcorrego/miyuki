import { defineStore } from 'pinia'

export const useToolsStore = defineStore('tools', {
    state: () => ({
      guides: false,
      delica: null,
      tool: 'paint',
      selectTool: 'add',
      clipboard: null,
     }),
    getters: {},
    actions: {
      setDelica(selectedDelica) {
        this.delica = selectedDelica
        this.selectTool = false
      },
      setSelectTool(tool) {
        this.selectTool = tool
      },
      activateTool(tool) {
        this.tool = tool
      },
      toggleGuides() {
        this.guides = !this.guides
      },
    },
})
