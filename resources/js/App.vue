<template lang="">
<div>
     <Header />
    <div id="layoutSidenav">

        <Sidebar />

        <div id="layoutSidenav_content">
            <main>
                <router-view></router-view>
                <!-- <Home /> -->
            </main>
            <Footer />
        </div>
    </div>
    <vue-snotify></vue-snotify>
</div>
</template>
<script>

import Header from './components/Header.vue';
import Home from './views/Home.vue';
import Sidebar from './components/Sidebar.vue';
import Footer from './components/Footer.vue';

export default {
    components: {
        Header,
        Home,
        Sidebar,
        Footer
    },

    created() {
  }
}
</script>
<style>
  @import './assets/fontawesome-free/css/all.min.css';
  @import './assets/custom/custom.css';
</style>