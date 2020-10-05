<template>
  <q-card class="my-card">
    <q-card-section>
        <div class="text-h5">Acesso</div>
    </q-card-section>
    <q-card-section>
        <div class="text-h7">Login: {{ cpf }}</div>
        <div class="text-h7">Ativo: {{ ativo }}</div>
        <div class="text-h7">Tipo: {{ tipo }}</div>
    </q-card-section>
  </q-card>
</template>

<script>
export default {
    props: [ 'id', 'cpf', 'ativo', 'tipo' ]
};
</script>

<style>
</style>