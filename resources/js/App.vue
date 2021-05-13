<template lang="">
    <div>
        <router-view></router-view>
        <vue-snotify></vue-snotify>
    </div>
</template>
<script>
import * as auth from './services/auth_service';
export default {
  name: "App",
  beforeCreate: async function () {
    try {
      if (auth.isLoggedIn()) {
        const response = await auth.getProfile();
        this.$store.dispatch("authenticate", response.data);
      }
    } catch (error) {
      auth.logout();
    }
  },
  created() {},
};
</script>
<style>
@import "./assets/fontawesome-free/css/all.min.css";
@import "./assets/custom/custom.css";
</style>
