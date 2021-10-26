<template>
    <div>
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>

<script>

export default {
    components: {
      //
    },
    mounted() {
        // progress bar preloader mounted start
        this.$Progress.finish();
        // progress bar preloader mounted end
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

<style></style>
