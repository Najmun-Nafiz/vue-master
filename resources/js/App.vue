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
    var scripts = [
      "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js",
      "https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js",
      "https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js",
      "backend/assets/demo/chart-bar-demo.js",
      "backend/assets/demo/chart-area-demo.js",
      "backend/assets/demo/datatables-demo.js",
      "backend/js/scripts.js"
    ];
    scripts.forEach(script => {
      let tag = document.createElement("script");
      tag.setAttribute("src", script);
      document.head.appendChild(tag);
    });
  }
}
</script>
<style>
  @import './assets/fontawesome-free/css/all.min.css';
</style>