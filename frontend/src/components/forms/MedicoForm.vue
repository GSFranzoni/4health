<template>
  <q-card class="form">
    <q-card-section>
      <div class="text-h5 text-primary">Cadastro de médico</div>
    </q-card-section>
    <q-card-section>
      <q-input class="q-mb-sm" outlined v-model="medico.nome" label="Nome" />
      <q-input class="q-mb-sm" outlined v-model="medico.crm" label="Crm" />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="medico.especialidade"
        label="Especialidade"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="medico.usuario.cpf"
        label="Cpf"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="medico.usuario.senha"
        label="Senha"
      />
      <q-toggle
        class="q-mb-sm"
        v-model="medico.usuario.ativo"
        checked-icon="check"
        color="primary"
        label="Ativo"
        unchecked-icon="clear"
      />
    </q-card-section>
    <q-card-actions align="right">
      <q-btn @click="$emit('cancel')" flat color="grey-9" label="Cancelar" />
      <q-btn
        @click="$emit('save', medico)"
        class="q-ma-sm"
        color="primary"
        label="Salvar"
      />
    </q-card-actions>
  </q-card>
</template>

<script>
export default {
  props: ["record"],
  data() {
    return {
      medico: {
        nome: "",
        crm: "",
        especialidade: "",
        usuario: {
          cpf: "",
          senha: "",
          ativo: true,
        },
      },
    };
  },
  mounted() {
    this.medico = this.record? { ...this.record }: this.medico;
  },
};
</script>

<style>
.form {
  width: 600px;
  max-width: 90vw;
}
</style>