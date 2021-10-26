import Vue from "vue";
Vue.mixin({
    methods: {
        sweetDelete(callbackResult) {
            swal.fire({
                title: "Are you confirm to delete?",
                // text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "rgb(184 0 0)",
                cancelButtonColor: "rgb(1 1 1)",
                confirmButtonText: "Yes, delete!"
            }).then(result => {
                if (result.isConfirmed) {
                    callbackResult();
                }
            });
        }
    }
});
