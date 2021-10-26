<template>
    <div>
        <h4 class="mt-3 ml-3">Logging out ....</h4>
    </div>
</template>

<script>
export default {
    created() {
        const token = localStorage.getItem("auth_token");
        if (token !== null) {
            this.$store.dispatch("logout").then(() => {
                this.$router.push({ name: "login" });
            });
        } else {
            this.$router.push({ name: "login" });
        }
    }
};
</script>
