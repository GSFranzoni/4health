<template>
  <q-card>
    <q-card-section>
      <div class="text-h5 text-primary">Cadastro de médico</div>
    </q-card-section>
    <q-card-section>
      <q-input class="q-mb-sm" outlined v-model="medico.med_nome" label="Nome" />
      <q-input class="q-mb-sm" outlined v-model="medico.med_crm" label="Crm" />
      <q-input 
        class="q-mb-sm" 
        outlined
        v-model="medico.med_especialidade"
        label="Especialidade"
      />
      <q-input class="q-mb-sm" outlined v-model="medico.med_usuario.usr_cpf" label="Cpf" />
      <q-input class="q-mb-sm" outlined v-model="medico.med_usuario.usr_senha" label="Senha" />
    </q-card-section>
    <q-card-actions align="right">
        <q-btn @click="$emit('cancel')" flat color="grey-9" label="Cancelar" />
        <q-btn @click="$emit('save', medico)" class="q-ma-sm" color="primary" label="Salvar" />
    </q-card-actions>
  </q-card>
</template>

<script>
export default {
  data() {
    return {
      medico: {
        med_nome: "",
        med_crm: "",
        med_especialidade: "",
        med_usuario: {
            usr_cpf: "",
            usr_senha: ""
        },
      },
    };
  },
};
</script>

<style>
</style>