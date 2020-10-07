<template>
  <List
    :actions="actions"
    title="Pacientes"
    :columns="columns"
    :data="pacientes"
  />
</template>

<script>
import PacienteService from "../../services/PacienteService";
import List from "../../components/lists/List";
import Form from "../../components/forms/Form";
import UsuarioFormConfig from "../../components/forms/UsuarioFormConfig";
import PacienteFormConfig from "../../components/forms/PacienteFormConfig";
import Notification from "../../util/Notification";
import paciente_json from "../../components/lists/paciente_json.json";
import UsuarioService from "../../services/UsuarioService";

export default {
  data() {
    return {
      pacientes: [],
      actions: [
        {
          icon: "loyalty",
          color: "primary",
          handle: this.viewFicha,
        },
      ],
      columns: paciente_json.columns,
    };
  },
  components: {
    List,
    Form,
  },
  methods: {
    viewFicha(paciente) {
      this.$router.push(`/medico/pacientes/${paciente.id}/exames`);
    },
    reload() {
      PacienteService.getAll().then((response) => {
        this.pacientes = response.data.body;
      });
    },
  },
  mounted() {
    this.reload();
  },
};
</script>

<style>
</style>