<template>
  <div>
    <List
      :actions="actions"
      @create="create"
      title="Médicos"
      :columns="columns"
      :data="medicos"
      :addButton="true"
    />
    <q-page-sticky
      @click="create"
      position="bottom-right"
      :offset="[18, 18]"
    >
      <q-btn fab icon="add" color="primary" />
    </q-page-sticky>
  </div>
</template>

<script>
import MedicoService from "../../services/MedicoService";
import List from "../../components/lists/List";
import Form from "../../components/forms/Form";
import Notification from "../../util/Notification";
import MedicosList from "../../components/lists/medicos_list";
import UsuarioFormConfig from "../../components/forms/UsuarioFormConfig";
import MedicoFormConfig from "../../components/forms/MedicoFormConfig";
import UsuarioService from "../../services/UsuarioService";

export default {
  data() {
    return {
      medicos: [],
      actions: [
        {
          icon: "edit",
          color: "primary",
          handle: this.edit,
        },
        {
          icon: "delete",
          color: "red-8",
          handle: this.confirmRemove,
        },
        {
          icon: "person_pin",
          color: "green-7",
          handle: this.formUser,
        },
      ],
      columns: MedicosList.columns,
    };
  },
  components: {
    List,
    Form,
  },
  methods: {
    async formUser(medico) {
      this.$q
        .dialog({
          component: Form,
          config: UsuarioFormConfig,
          init: medico.usuario
            ? (await UsuarioService.get(medico.usuario)).data.body
            : {},
        })
        .onOk(({ record, hide }) => {
          hide();
          medico.usuario
            ? this.editUsuario(medico.usuario, record)
            : this.saveUsuario(medico.id, record);
        });
    },
    saveUsuario(medicoId, usuario) {
      UsuarioService.insertMedico(medicoId, usuario)
        .then(Notification.positive)
        .catch(Notification.negative)
        .finally(() => this.reload());
    },
    editUsuario(usuarioId, usuario) {
      UsuarioService.update(usuarioId, usuario)
        .then(Notification.positive)
        .catch(Notification.negative)
        .finally(() => this.reload());
    },
    async edit(medico) {
      this.$q
        .dialog({
          component: Form,
          config: MedicoFormConfig,
          init: (await MedicoService.get(medico.id)).data.body,
        })
        .onOk(({ record, hide }) => {
          MedicoService.update(medico.id, record)
            .then(Notification.positive)
            .then(hide)
            .catch(Notification.negative)
            .finally(() => this.reload());
        });
    },
    create() {
      this.$q
        .dialog({
          component: Form,
          config: MedicoFormConfig,
          init: {},
        })
        .onOk(({ record, hide }) => {
          MedicoService.insert(record)
            .then(Notification.positive)
            .then(hide)
            .catch(Notification.negative)
            .finally(() => this.reload());
        });
    },
    remove(record) {
      MedicoService.delete(record.id)
        .then(Notification.positive)
        .catch(Notification.negative)
        .finally(() => this.reload());
    },
    confirmRemove(record) {
      this.$q
        .dialog({
          title: "Confirmação",
          message: "Você realmente deseja excluir o registro?",
          cancel: true,
          persistent: true,
        })
        .onOk(() => {
          this.remove(record);
        });
    },
    reload() {
      MedicoService.getAll().then((response) => {
        this.medicos = response.data.body;
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