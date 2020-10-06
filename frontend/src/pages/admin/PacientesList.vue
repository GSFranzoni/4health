<template>
  <List
    :actions="actions"
    @create="create"
    title="Pacientes"
    :columns="columns"
    :data="pacientes"
  />
</template>

<script>
import PacienteService from "../../services/PacienteService";
import List from "../../components/lists/List";
import PacienteForm from "../../components/forms/PacienteForm";
import Notification from "../../util/Notification";
import paciente_json from '../../components/lists/paciente_json.json';

export default {
  data() {
    return {
      pacientes: [],
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
      columns: paciente_json.columns,
    };
  },
  components: {
    PacienteForm,
    List,
  },
  methods: {
    handleUser(paciente) {
      paciente.usuario? this.editUser(paciente.usuario): this.createUser(paciente);
    },
    createUser(paciente) {
      this.$router.push({ path: `${paciente.id}/usuario/create` });
    },
    editUser(usuario) {
      this.$router.push({ path: `../usuarios/${usuario}/edit` });
    },
    edit(paciente) {
      this.$router.push({ path: `${paciente.id}/edit` });
    },
    create() {
      this.$router.push({ path: `create` });
    },
    remove(record) {
      PacienteService.delete(record.id)
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
      PacienteService.getAll().then((response) => {
        this.pacientes = response.data.body;
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