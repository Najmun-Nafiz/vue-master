<template lang="">
    <div>
        <Header />
        <div id="layoutSidenav">

            <Sidebar />

            <div id="layoutSidenav_content">
                <main>
                    <router-view></router-view>
                </main>
                <Footer />
            </div>
        </div>
    </div>
</template>
<script>
import Header from '../components/Header.vue';
import Sidebar from '../components/Sidebar.vue';
import Footer from '../components/Footer.vue';

export default {
    components: {
        Header,
        Sidebar,
        Footer
    },

    created() {
        document.querySelector("body").style.backgroundColor = "#fff";
    },
}
</script>
<style>
    
</style>