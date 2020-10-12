<template>
  <div>
    <q-btn @click="$router.go(-1)" rounded class="q-ma-sm" flat color="white" icon="arrow_back_ios" text-color="black" label="Pacientes" />
    <FichaPaciente ref="ficha" :id="paciente" />
    <q-page-sticky @click="openExameForm" position="bottom-right" :offset="[18, 18]">
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
import ExameService from "../../services/ExameService";
import { Dialog } from "quasar";
import { mapState } from "vuex";
import ExameFormConfig from "../../components/forms/ExameFormConfig";
import SolicitacaoFormConfig from "../../components/forms/SolicitacaoFormConfig";

export default {
  props: ["paciente"],
  data() {
    return {
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
          data: `${record.data} ${record.horario}`.replaceAll('/', '-'),
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