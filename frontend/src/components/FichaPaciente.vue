<template>
  <List :actions="actions" :title="`Exames do paciente ${paciente.nome}`" :columns="columns" :data="exames" />
</template>

<script>
import List from "../components/lists/List";
import Notification from "../util/Notification";
import Form from "../components/forms/Form";
import Exame from "../components/Exame";
import ExamesList from "../components/lists/exames_list";
import ExameService from "../services/ExameService";
import PacienteService from "../services/PacienteService";
import { Dialog } from "quasar";
import { mapState } from "vuex";

export default {
  props: ['id'],
  data() {
    return {
      exames: [],
      paciente: {},
      actions: [
        {
          icon: "search",
          color: "primary",
          handle: this.openDialog,
        },
      ],
      columns: ExamesList.columns,
    };
  },
  components: {
    List,
    Form,
  },
  methods: {
    async reload() {
      this.exames = (await ExameService.getByPaciente(this.id)).data.body;
      this.paciente = (await PacienteService.get(this.id)).data.body;
    },
    openDialog(exame) {
      Dialog.create({
        component: Exame,
        ...exame,
      }).onOk(() => {
        this.reload();
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