<template>
  <List :actions="actions" title="Exames" :columns="columns" :data="exames" />
</template>

<script>
import List from "../../components/lists/List";
import Notification from "../../util/Notification";
import Form from "../../components/forms/Form";
import Exame from "../../components/Exame";
import exame_json from "../../components/lists/exame_json.json";
import ExameService from '../../services/ExameService';
import { Dialog } from 'quasar';
import { mapState } from 'vuex';

export default {
  data() {
    return {
      exames: [],
      actions: [
        {
          icon: "search",
          color: "primary",
          handle: this.openDialog,
        },
      ],
      columns: exame_json.columns,
    };
  },
  computed: mapState([
      'info'
  ]),
  components: {
    List, Form
  },
  methods: {
    reload() {
      ExameService.getByPaciente(this.info.id).then((response) => {
        this.exames = response.data.body.map(exame => {
            return { ...exame, medico: exame.medico.nome, paciente: exame.paciente.nome };
        });
      });
    },
    openDialog(exame) {
      Dialog.create({
        component: Exame,
        ...exame
      }).onOk(() => {
        this.reload();
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