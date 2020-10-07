<template>
  <List :actions="actions" title="Exames" :columns="columns" :data="exames" />
</template>

<script>
import List from "../../components/lists/List";
import Notification from "../../util/Notification";
import Form from "../../components/forms/Form";
import Exame from "../../components/Exame";
import exame_json from "../../components/lists/exame_json.json";
import ExameService from "../../services/ExameService";
import { Dialog } from "quasar";
import { mapState } from "vuex";
import ExameFormConfig from "../../components/forms/ExameFormConfig";

export default {
  data() {
    return {
      exames: [],
      actions: [
        {
          icon: "edit",
          color: "primary",
          handle: this.openDialogEdit,
        },
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
    List,
    Form
  },
  computed: mapState(["info"]),
  methods: {
    reload() {
      ExameService.getByMedico(this.info.id).then((response) => {
        this.exames = response.data.body.map((exame) => {
          return {
            ...exame,
            medico: exame.medico.nome,
            paciente: exame.paciente.nome,
          };
        });
      });
    },
    openDialogView(exame) {
      Dialog.create({
        component: Exame,
        ...exame,
      });
    },
    openDialogEdit(exame) {
      Dialog.create({
        component: Form,
        config: ExameFormConfig,
        title: "Edição de exame",
        init: { 
          ...exame, 
          data: exame.data.split(' ')[0].replaceAll('-', '/'), 
          horario: exame.data.split(' ')[1].substr(0, 5)
        }
      }).onOk(({ record, hide }) => {
        ExameService.update(exame.id, { 
          laudo: exame.laudo,
          resultado: exame.resultado,
          nome: exame.nome,
          data: `${record.data} ${record.horario}:00`.replaceAll('/', '-')
        })
        .then(Notification.positive)
        .then(hide)
        .catch(Notification.negative);
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