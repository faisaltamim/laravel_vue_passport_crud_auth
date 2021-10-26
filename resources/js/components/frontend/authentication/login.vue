<template>
    <div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card card-signin my-5">
                        <div class="card-body">
                            <div class="loginHeader">
                                <h3 class="text-center font-weight-bold">
                                    Login Form
                                </h3>
                            </div>
                            <hr />
                            <form
                                method="POST"
                                class="form-signin"
                                @submit.prevent="m_login()"
                            >
                                <div class="form-label-group">
                                    <label for="inputEmail"
                                        >Email address</label
                                    >
                                    <input
                                        type="email"
                                        v-model="login.email"
                                        id="inputEmail"
                                        class="form-control inputBorder"
                                        :class="{
                                            errorBorder:
                                                loginEmptyError.email != null
                                        }"
                                        placeholder="Email address"
                                    />
                                    <strong
                                        class="text-danger"
                                        v-if="loginEmptyError.email"
                                        >{{ loginEmptyError.email[0] }}
                                    </strong>
                                </div>

                                <div class="form-label-group">
                                    <label for="inputPassword">Password</label>
                                    <input
                                        :type="passwordType"
                                        id="inputPassword"
                                        class="form-control inputBorder parentForEye"
                                        :class="{
                                            errorBorder:
                                                loginError ||
                                                loginEmptyError.password != null
                                        }"
                                        v-model="login.password"
                                        placeholder="Password"
                                    />
                                    <span
                                        v-if="hideOpenPass"
                                        @click="openPass()"
                                        class="openPassEye float-right"
                                        ><i class="fas fa-eye"></i
                                    ></span>
                                    <span
                                        v-if="showHidePass"
                                        @click="hidePass()"
                                        class="openPassEye float-right"
                                        ><i class="fas fa-eye-slash"></i
                                    ></span>
                                    <div class="errorNsuccess">
                                        <strong
                                            class="text-danger"
                                            v-if="loginEmptyError.password"
                                            >{{ loginEmptyError.password[0] }}
                                        </strong>
                                        <strong
                                            class="text-danger"
                                            v-if="loginError"
                                            >{{ loginError }}
                                        </strong>
                                    </div>
                                </div>

                                <div
                                    class="custom-control custom-checkbox mb-3"
                                >
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="customCheck1"
                                    />
                                    <label
                                        class="custom-control-label"
                                        for="customCheck1"
                                        >Remember password</label
                                    >
                                </div>
                                <div class="bottomBtn">
                                    <button
                                        class="btn btn-lg btn-success btn-block text-uppercase"
                                        type="submit"
                                    >
                                        Login
                                    </button>

                                    <strong
                                        style="border-radius: 10px"
                                        class="text-center d-block text-light bg-success mt-4 py-2 px-3"
                                        v-if="registerMsg"
                                    >
                                        {{ registerMsg }}
                                    </strong>

                                    <div class="forgetPass text-center mt-3">
                                        <span class="d-inline-block text-dark"
                                            >Forget your
                                            <router-link
                                                :to="{ name: 'reset_password' }"
                                                class="text-primary"
                                                href=""
                                                >password?</router-link
                                            ></span
                                        >
                                    </div>

                                    <hr class="mb-3 mt-2" />

                                    <div class="forgetPass text-center">
                                        <span class="d-inline-block text-dark"
                                            >If you don't have an account then
                                            <router-link
                                                :to="{ name: 'register' }"
                                                class="text-primary"
                                            >
                                                register
                                            </router-link>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    created() {
        $("body").css("background-color", "#f1f1f1");
        this.registerMsg = this.$route.params.registerSuccMsg;
    },
    mounted() {
        //
    },
    data() {
        return {
            login: {
                email: "",
                password: ""
            },
            count: 0,
            registerMsg: "",
            loginError: "",
            loginEmptyError: {},
            passwordType: "password",
            hideOpenPass: true,
            showHidePass: false
        };
    },
    methods: {
        openPass() {
            this.passwordType = "text";
            this.hideOpenPass = false;
            this.showHidePass = true;
        },
        hidePass() {
            this.passwordType = "password";
            this.hideOpenPass = true;
            this.showHidePass = false;
        },
        m_login() {
            const credentials = {};
            credentials.email = this.login.email;
            credentials.password = this.login.password;

            this.$store.dispatch("spaLogin", credentials).then(res => {
                // let getAccessToken = localStorage.getItem("auth_token");

                this.$router.push({ name: "mainDashborad" });
            });
        }
    }
};
</script>

<style scoped>
:root {
    --input-padding-x: 1.5rem;
    --input-padding-y: 0.75rem;
}

.card-signin {
    border: 0;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
}

.card-signin .card-title {
    margin-bottom: 2rem;
    font-weight: 300;
    font-size: 1.5rem;
}

.card-signin .card-body {
    padding: 1rem 2rem 1.3rem 2rem;
}

.form-signin {
    width: 100%;
}

.form-signin .btn {
    font-size: 80%;
    border-radius: 5rem;
    letter-spacing: 0.1rem;
    font-weight: bold;
    padding: 1rem;
    transition: all 0.2s;
}

.form-label-group {
    position: relative;
    margin-bottom: 1rem;
}

.btn-google {
    color: white;
    background-color: #000000;
}

.custom-control-input:checked ~ .custom-control-label::before {
    color: #fff !important;
    border-color: #000000 !important;
    background-color: #000000 !important;
}

.inputBorder {
    border: 1px solid rgb(233 231 231) !important;
}

/* error border */
.errorBorder {
    border: 1px solid red !important;
    border-radius: 3px !important;
}

/* eyeStyle */
.parentForEye {
    position: relative;
}
span.openPassEye {
    position: absolute;
    top: 39px;
    right: 10px;
    cursor: pointer;
}
</style>
