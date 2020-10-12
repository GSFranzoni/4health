<template>
  <List :actions="actions" title="Meus exames" :columns="columns" :data="exames" />
</template>

<script>
import List from "../../components/lists/List";
import Notification from "../../util/Notification";
import Form from "../../components/forms/Form";
import Exame from "../../components/Exame";
import ExameService from "../../services/ExameService";
import { Dialog } from "quasar";
import { mapState } from "vuex";
import ExameFormConfig from "../../components/forms/ExameFormConfig";
import ExamesList from "../../components/lists/exames_list";

export default {
  data() {
    return {
      exames: [],
      actions: [
        {
          icon: "search",
          color: "grey-8",
          handle: this.openDialogView,
        },
        {
          icon: "edit",
          color: "primary",
          handle: this.editExame,
        },
        {
          icon: "delete",
          color: "red-8",
          handle: this.removeExame,
        }
      ],
      columns: ExamesList.columns,
    };
  },
  components: {
    List,
    Form,
  },
  computed: mapState(["info"]),
  methods: {
    async reload() {
      this.exames = (await ExameService.getByMedico(this.info.id)).data.body;
    },
    openDialogView(exame) {
      Dialog.create({
        component: Exame,
        ...exame,
      });
    },
    editExame(exame) {
      Dialog.create({
        component: Form,
        config: ExameFormConfig,
        init: {
          ...exame,
          data: exame.data.split(' ')[0].replaceAll('-', '/'),
          horario: exame.data.split(' ')[1].substr(0, 5)
        }
      }).onOk(({ record, hide }) => {
        ExameService.update(exame.id, {
          ...record,
          data: `${record.data} ${record.horario}`.replaceAll('/', '-')
        })
          .then(Notification.positive)
          .then(hide)
          .then(this.reload)
          .catch(Notification.negative);
      });
    },
    removeExame(exame) {
      Dialog.create({
          title: "Confirmação",
          message: "Você realmente deseja excluir o registro?",
          cancel: true,
          persistent: true,
        })
        .onOk(() => {
          ExameService.delete(exame.id)
            .then(Notification.positive)
            .then(this.reload)
            .catch(Notification.negative);
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