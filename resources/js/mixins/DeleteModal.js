export const LoggedUser = {
    methods: {
    deleteItem(url, id) {
      this.$q.dialog({
        title: 'Confirmar',
        message: 'Realmente deseja apagar esse item?',
        ok: {
          label: 'Sim',
          color: 'negative'
        },
        cancel: {
          label: 'Cancelar',
          color: 'primary'
        },
        persistent: true
      }).onOk(async () => {
        const resp = await this.axios.delete(url);
        if(resp.data.success){
          document.getElementById(`item-${id}`).remove();
        }
      })
    }
  },
}