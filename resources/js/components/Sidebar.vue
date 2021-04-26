<template lang="">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <router-link to="/" class="nav-link" exact>
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </router-link>
                    <router-link to="/categories" class="nav-link" exact>
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Categories</span>
                    </router-link>
                </div>
            </div>
        </nav>
    </div>
</template>
<script>
export default {};
</script>
<style lang=""></style>
