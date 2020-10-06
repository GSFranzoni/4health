<template>
  <List
    :actions="actions"
    title="Médicos"
    :columns="columns"
    :data="medicos"
  />
</template>

<script>
import MedicoService from "../../services/MedicoService";
import List from "../../components/lists/List";
import medico_json from "../../components/lists/medico_json.json";
import MedicoForm from "../../components/forms/MedicoForm";
import Notification from "../../util/Notification";
import Form from "../../components/forms/Form";
import { Dialog } from 'quasar';
import SolicitacaoService from '../../services/SolicitacaoService';

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
      columns: medico_json.columns,
    };
  },
  components: {
    List, Form
  },
  methods: {
    reload() {
      MedicoService.getAll().then((response) => {
        this.medicos = response.data.body;
      });
    },
    solicitarAtendimento(data_atendimento, medico) {
      SolicitacaoService.insert({
        data_atendimento,
        medico: medico.id,
        paciente: this.$store.state.info.id
      })
      .then(Notification.positive)
      .catch(Notification.negative);
    },
    openDialog(medico) {
      Dialog.create({
        component: Form,
        title: "Solicitar atendimento",
        fields: [
          {
            name: 'data_atendimento',
            type: 'date',
            label: ''
          }
        ]
      }).onOk((record) => {
        this.solicitarAtendimento(record.data_atendimento, medico);
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