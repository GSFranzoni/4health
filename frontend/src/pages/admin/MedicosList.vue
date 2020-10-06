<template>
  <List
    :actions="actions"
    @create="create"
    title="Médicos"
    :columns="columns"
    :data="medicos"
  />
</template>

<script>
import MedicoService from "../../services/MedicoService";
import List from "../../components/lists/List";
import MedicoForm from "../../components/forms/MedicoForm";
import Notification from "../../util/Notification";
import medico_json from '../../components/lists/medico_json.json';

export default {
  data() {
    return {
      medicos: [],
      actions: [
        {
          icon: "edit",
          color: "primary",
          handle: this.edit,
        },
        {
          icon: "delete",
          color: "red-8",
          handle: this.confirmRemove,
        },
        {
          icon: "person_pin",
          color: "green-7",
          handle: this.handleUser,
        },
      ],
      columns: medico_json.columns,
    };
  },
  components: {
    MedicoForm,
    List,
  },
  methods: {
    handleUser(medico) {
      medico.usuario? this.editUser(medico.usuario): this.createUser(medico);
    },
    createUser(medico) {
      this.$router.push({ path: `${medico.id}/usuario/create` });
    },
    editUser(usuario) {
      this.$router.push({ path: `../usuarios/${usuario}/edit` });
    },
    edit(medico) {
      this.$router.push({ path: `${medico.id}/edit` });
    },
    create() {
      this.$router.push({ path: `create` });
    },
    remove(record) {
      MedicoService.delete(record.id)
        .then(Notification.positive)
        .catch(Notification.negative)
        .finally(() => {
          this.reload();
        })
    },
    confirmRemove(record) {
      this.$q
        .dialog({
          title: "Confirmação",
          message: "Você realmente deseja excluir o registro?",
          cancel: true,
          persistent: true,
        })
        .onOk(() => {
          this.remove(record);
        });
    },
    reload() {
      MedicoService.getAll().then((response) => {
        this.medicos = response.data.body;
      });
    }
  },
  mounted() {
    this.reload();
  },
};
</script>

<style>
</style>