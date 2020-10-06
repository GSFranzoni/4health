<template>
  <FichaPaciente :id="$store.state.info.id"/>
</template>

<script>
import FichaPaciente from '../../components/FichaPaciente';

export default {
    components: {
        FichaPaciente
    }
}
</script>

<style>

</style>