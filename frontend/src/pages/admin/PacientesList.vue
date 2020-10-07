<template>
  <List
    :actions="actions"
    @create="create"
    title="Pacientes"
    :columns="columns"
    :data="pacientes"
  />
</template>

<script>
import PacienteService from "../../services/PacienteService";
import List from "../../components/lists/List";
import Form from "../../components/forms/Form";
import UsuarioFormConfig from "../../components/forms/UsuarioFormConfig";
import PacienteFormConfig from "../../components/forms/PacienteFormConfig";
import Notification from "../../util/Notification";
import paciente_json from "../../components/lists/paciente_json.json";
import UsuarioService from "../../services/UsuarioService";

export default {
  data() {
    return {
      pacientes: [],
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
      columns: paciente_json.columns,
    };
  },
  components: {
    List,
    Form,
  },
  methods: {
    async formUser(paciente) {
      this.$q
        .dialog({
          component: Form,
          config: UsuarioFormConfig,
          init: paciente.usuario
            ? (await UsuarioService.get(paciente.usuario)).data.body
            : {},
        })
        .onOk(({ record, hide }) => {
          hide();
          paciente.usuario
            ? this.editUsuario(paciente.usuario, record)
            : this.saveUsuario(paciente.id, record);
        });
    },
    saveUsuario(pacienteId, usuario) {
      UsuarioService.insertPaciente(pacienteId, usuario)
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
    async edit(paciente) {
      this.$q
        .dialog({
          component: Form,
          config: PacienteFormConfig,
          init: (await PacienteService.get(paciente.id)).data.body,
        })
        .onOk(({ record, hide }) => {
          PacienteService.update(paciente.id, record)
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
          config: PacienteFormConfig,
          init: {},
        })
        .onOk(({ record, hide }) => {
          PacienteService.insert(record)
            .then(Notification.positive)
            .then(hide)
            .catch(Notification.negative)
            .finally(() => this.reload());
        });
    },
    remove(record) {
      PacienteService.delete(record.id)
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