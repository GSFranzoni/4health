<template>
  <q-page padding>
    <q-table
      title="Pacientes"
      :data="pacientes"
      :columns="columns"
      no-data-label="I didn't find anything for you"
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
            <q-fab-action color="green" icon="edit" />
            <q-fab-action color="red-8" icon="delete" />
          </q-fab>
        </q-td>
      </template>
    </q-table>
  </q-page>
</template>

<script>
import PacienteService from "../../services/PacienteService";
import Paciente from "../../components/Paciente";

export default {
  data() {
    return {
      pacientes: [],
      columns: [
        { name: "actions", label: "Ações", align: "left" },
        { name: "usr_cpf", label: "Cpf", field: "usr_cpf", align: "left" },
        { name: "pac_nome", label: "Nome", field: "pac_nome", align: "left" },
        { name: "pac_uf", label: "Estado", field: "pac_uf", align: "left" },
        {
          name: "pac_cidade",
          label: "Cidade",
          field: "pac_cidade",
          align: "left",
        },
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
    Paciente,
  },
  mounted() {
    PacienteService.getAll().then((response) => {
      this.pacientes = response.data.body.map((paciente) => {
        return { ...paciente, ...paciente.pac_usuario };
      });
    });
  },
};
</script>

<style>
</style>