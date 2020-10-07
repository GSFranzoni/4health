<template>
  <div>
    <FichaPaciente ref="ficha" :id="paciente" />
    <q-page-sticky @click="openExameForm" position="top-right" :offset="[18, 18]">
      <q-btn fab icon="add" color="primary" />
    </q-page-sticky>
  </div>
</template>

<script>
import List from "../../components/lists/List";
import Notification from "../../util/Notification";
import Form from "../../components/forms/Form";
import Exame from "../../components/Exame";
import FichaPaciente from "../../components/FichaPaciente";
import exame_json from "../../components/lists/exame_json.json";
import ExameService from "../../services/ExameService";
import { Dialog } from "quasar";
import { mapState } from "vuex";
import ExameFormConfig from "../../components/forms/ExameFormConfig";
import SolicitacaoFormConfig from "../../components/forms/SolicitacaoFormConfig";

export default {
  props: ["paciente"],
  data() {
    return {
      exames: [],
      actions: [
        {
          icon: "search",
          color: "grey-8",
          handle: this.openDialogView,
        },
      ],
      columns: exame_json.columns,
    };
  },
  components: {
    Form,
    FichaPaciente
  },
  methods: {
    openExameForm() {
      Dialog.create({
        component: Form,
        config: ExameFormConfig,
        init: {}
      }).onOk(({ record, hide }) => {
        record = { 
          ...record, 
          data: `${record.data} ${record.horario}:00`.replaceAll('/', '-'),
          paciente: parseInt(this.paciente),
          medico: this.$store.state.info.id
        };
        ExameService.insert(record)
          .then(Notification.positive)
          .then(hide)
          .catch(Notification.negative)
          .finally(() => {
            this.$refs.ficha.reload();
          })
      });
    }
  },
  mounted() {
    this.$refs.ficha.reload();
  },
};
</script>

<style>
</style>