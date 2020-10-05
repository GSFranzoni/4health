<template>
  <q-page padding>
    <List
      :actions="actions"
      @create="create"
      title="Médicos"
      :columns="columns"
      :data="medicos"
    />
    <q-dialog v-model="form">
      <MedicoForm :record="record" @cancel="cancel" @save="save" />
    </q-dialog>
  </q-page>
</template>

<script>
import MedicoService from "../../services/MedicoService";
import Medico from "../../components/Medico";
import MedicoForm from "../../components/forms/MedicoForm";
import List from "../../components/lists/List";

export default {
  data() {
    return {
      form: false,
      record: null,
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
      ],
      columns: [
        { name: "actions", label: "Ações", align: "left" },
        { name: "nome", label: "Nome", field: "nome", align: "left" },
        { name: "cpf", label: "Cpf", field: "cpf", align: "left" },
        {
          name: "especialidade",
          label: "Especialidade",
          field: "especialidade",
          align: "left",
        },
        { name: "crm", label: "Crm", field: "crm", align: "left" },
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
    Medico,
    MedicoForm,
    List,
  },
  methods: {
    edit($event) {
      this.record = $event;
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
    MedicoService.getAll().then((response) => {
      this.medicos = response.data.body.map((medico) => {
        return { ...medico, ...medico.usuario, id: medico.id };
      });
    });
  },
};
</script>

<style>
</style>