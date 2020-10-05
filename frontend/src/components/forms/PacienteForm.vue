<template>
  <q-card class="form">
    <q-card-section>
      <div class="text-h5 text-primary">Cadastro de paciente</div>
    </q-card-section>
    <q-card-section>
      <q-input class="q-mb-sm" outlined v-model="paciente.nome" label="Nome" />
      <q-input class="q-mb-sm" outlined v-model="paciente.uf" label="Estado" />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.cidade"
        label="Cidade"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.logradouro"
        label="Logradouro"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.bairro"
        label="Bairro"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.numero_casa"
        label="Número"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.telefone"
        label="Telefone"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.usuario.cpf"
        label="Cpf"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.usuario.senha"
        label="Senha"
      />
      <q-toggle
        class="q-mb-sm"
        v-model="paciente.usuario.ativo"
        checked-icon="check"
        color="primary"
        label="Ativo"
        unchecked-icon="clear"
      />
    </q-card-section>
    <q-card-actions align="right">
      <q-btn @click="$emit('cancel')" flat color="grey-9" label="Cancelar" />
      <q-btn
        @click="$emit('save', paciente)"
        class="q-ma-sm"
        color="primary"
        label="Salvar"
      />
    </q-card-actions>
  </q-card>
</template>

<script>
export default {
  props: [ "record" ],
  data() {
    return {
      paciente: {
        nome: "",
        crm: "",
        especialidade: "",
        usuario: {
          cpf: "",
          senha: "",
          ativo: true
        },
      },
    };
  },
  mounted() {
    this.paciente = this.record? { ...this.record }: this.paciente;
  },
};
</script>

<style>
.form {
  width: 600px;
  max-width: 90vw;
}
</style>