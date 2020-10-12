<template>
  <div>
    <List
      :actions="actions"
      title="Médicos disponíveis"
      :columns="columns"
      :data="medicos"
    />
  </div>
</template>

<script>
import MedicoService from "../../services/MedicoService";
import List from "../../components/lists/List";
import MedicosList from "../../components/lists/medicos_list";
import Notification from "../../util/Notification";
import Form from "../../components/forms/Form";
import { Dialog } from "quasar";
import SolicitacaoService from "../../services/SolicitacaoService";
import SolicitacaoFormConfig from "../../components/forms/SolicitacaoFormConfig";

export default {
  data() {
    return {
      medicos: [],
      actions: [
        {
          icon: "medical_services",
          color: "primary",
          handle: this.openDialog,
        },
      ],
      columns: MedicosList.columns,
    };
  },
  components: {
    List,
    Form
  },
  methods: {
    reload() {
      MedicoService.getDisponiveis().then((response) => {
        this.medicos = response.data.body;
      });
    },
    openDialog(medico) {
      Dialog.create({
        component: Form,
        init: {},
        config: SolicitacaoFormConfig,
      }).onOk(({ record, hide }) => {
        SolicitacaoService.insert({
          data: `${record.data} ${record.horario}`.replaceAll('/', '-'),
          medico: medico.id,
          paciente: this.$store.state.info.id,
        })
          .then(Notification.positive)
          .then(hide)
          .catch(Notification.negative)
          .finally(() => {
            this.reload();
          });
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