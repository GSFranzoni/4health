<template>
  <q-page padding>
    <q-table
      title="Médicos"
      :data="medicos"
      :columns="columns"
      no-data-label="Nenhum registro encontrado..."
      row-key="name"
    >
      <template v-slot:top-right>
        <q-btn color="primary" icon="add" round></q-btn>
      </template>
      <template v-slot:body-cell-usr_ativo="props">
        <q-td :props="props">
          <q-icon
            v-if="props.row.usr_ativo == 1"
            size="sm"
            color="primary"
            name="check_circle"
          />
          <q-icon v-else size="sm" color="red-8" name="cancel" />
        </q-td>
      </template>
      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-fab flat color="black" push icon="settings" direction="right">
            <q-fab-action color="primary" icon="edit" />
            <q-fab-action color="red-8" icon="delete" />
          </q-fab>
        </q-td>
      </template>
    </q-table>
    <MedicoForm @cancel="cancel" @save="save" />
  </q-page>
</template>

<script>
import MedicoService from "../../services/MedicoService";
import Medico from "../../components/Medico";
import MedicoForm from "../../components/forms/MedicoForm";

export default {
  data() {
    return {
      medicos: [],
      columns: [
        { name: "actions", label: "Ações", align: "left" },
        { name: "usr_cpf", label: "Cpf", field: "usr_cpf", align: "left" },
        { name: "med_nome", label: "Nome", field: "med_nome", align: "left" },
        {
          name: "med_especialidade",
          label: "Especialidade",
          field: "med_especialidade",
          align: "left",
        },
        { name: "med_crm", label: "Crm", field: "med_crm", align: "left" },
        {
          name: "usr_ativo",
          label: "Ativo",
          field: "usr_ativo",
          align: "center",
        },
      ],
    };
  },
  components: {
    Medico,
    MedicoForm,
  },
  methods: {
    save($event) {
        console.log($event)
    },
    cancel($event) {
        console.log($event)
    },
  },
  mounted() {
    MedicoService.getAll().then((response) => {
      this.medicos = response.data.body.map((medico) => {
        return { ...medico, ...medico.med_usuario };
      });
    });
  },
};
</script>

<style>
</style>