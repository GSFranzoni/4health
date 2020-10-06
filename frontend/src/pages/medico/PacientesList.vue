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
import paciente_json from "../../components/lists/paciente_json.json";
import Notification from "../../util/Notification";
import SolicitacaoService from "../../services/SolicitacaoService";

export default {
  data() {
    return {
      pacientes: [],
      actions: [
        {
          icon: "library_books",
          color: "primary",
          handle: this.verFicha,
        },
      ],
      columns: paciente_json.columns,
    };
  },
  components: {
    List
  },
  methods: {
    verFicha(paciente) {
        this.$router.push(`/medico/pacientes/${paciente.id}/ficha`);
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