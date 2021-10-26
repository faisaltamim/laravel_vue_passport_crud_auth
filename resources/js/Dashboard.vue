<template>
    <div>
        <div class="wrapper">
            <!-- Navbar -->
            <!-- navbar code get from header.vue component -->
            <Navbar />
            <!-- /.navbar -->

            <!-- Main Sidebar Container start-->
            <!-- sidebar code get from sidebar.vue component -->
            <Sidebar />
            <!-- Main Sidebar Container end-->

            <div class="content-wrapper text-light" id="mainContentBg">
                <!-- main content area -->
                <router-view></router-view>
                <!-- <vue-progress-bar></vue-progress-bar> -->
            </div>
            <Footer />
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
        </div>
    </div>
</template>

<script>
import Navbar from "./components/reusable_component/header";
import Sidebar from "./components/reusable_component/sidebar";
import Footer from "./components/reusable_component/footer";
export default {
    components: {
        Navbar,
        Sidebar,
        Footer
    },

    mounted() {
        // progress bar preloader mounted start
        this.$Progress.finish();
        // progress bar preloader mounted end
    },
    computed: {
        //
    },
    created() {
        // start progress bar preloader code
        this.$Progress.start();
        this.$router.beforeEach((to, from, next) => {
            if (to.meta.progress !== undefined) {
                let meta = to.meta.progress;
                this.$Progress.parseMeta(meta);
            }
            this.$Progress.start();
            next();
        });
        this.$router.afterEach(() => {
            this.$Progress.finish();
        });
        // end progress bar preloader code

    }
};
</script>
