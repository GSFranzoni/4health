<template>
  <q-page padding>
    <List
      :actions="actions"
      @create="create"
      title="Pacientes"
      :columns="columns"
      :data="pacientes"
    />
    <q-dialog v-model="form">
      <PacienteForm :record="record" @cancel="cancel" @save="save" />
    </q-dialog>
  </q-page>
</template>

<script>
import PacienteService from "../../services/PacienteService";
import List from "../../components/lists/List";
import PacienteForm from "../../components/forms/PacienteForm";

export default {
  data() {
    return {
      form: false,
      record: null,
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
      ],
      columns: [
        { name: "actions", label: "Ações", align: "left" },
        { name: "nome", label: "Nome", field: "nome", align: "left" },
        { name: "cpf", label: "Cpf", field: "cpf", align: "left" },
        { name: "uf", label: "Estado", field: "uf", align: "left" },
        {
          name: "cidade",
          label: "Cidade",
          field: "cidade",
          align: "left",
        },
        {
          name: "ativo",
          label: "Ativo",
          field: "ativo",
          align: "center",
        },
      ],
    };
  },
  components: {
    PacienteForm,
    List,
  },
  methods: {
    edit($event) {
      this.record = $event;
      console.log(this.record)
      this.toggleForm();
    },
    save($event) {
      console.log($event);
    },
    remove(record) {},
    cancel($event) {
      this.toggleForm();
    },
    create() {
      this.toggleForm();
    },
    toggleForm() {
      this.form = !this.form;
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
  },
  watch: {
    form() {
      if (!this.form) {
        this.record = null;
      }
    },
  },
  mounted() {
    PacienteService.getAll().then((response) => {
      this.pacientes = response.data.body.map((paciente) => {
        return { ...paciente, ...paciente.usuario, id: paciente.id };
      });
    });
  },
};
</script>

<style>
</style>