<template>
  <transition
    mode="out-in"
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut"
  >
    <router-view />
  </transition>
</template>

<script>
export default {
  data() {
    return {};
  },
};
</script>

<style>
</style>