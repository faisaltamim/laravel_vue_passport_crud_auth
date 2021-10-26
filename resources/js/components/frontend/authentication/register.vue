<template>
  <div>
    <div class="container mt-3">
      <div class="row">
        <div class="col-sm-9 col-md-8 col-lg-6 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <div class="loginHeader">
                <h3 class="text-center font-weight-bold">Register Here</h3>
              </div>
              <hr />
              <form
                method="post"
                @submit.prevent="m_registerUser()"
                class="form-signin"
              >
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-label-group">
                      <label for="name">Your Name</label>
                      <input
                       
                        type="text"
                        v-model="registerUser.name"
                        id="name"
                        class="form-control inputBorder"
                        placeholder="Enter your full name"
                        :class="{ errorBorder: register_error.name != null }"
                      />
                      <strong class="text-danger" v-if="register_error.name">{{
                        register_error.name[0]
                      }}</strong>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-label-group">
                      <label for="inputPhone">Phone Number</label>
                      <input
                        :class="{ errorBorder: register_error.phone != null }"
                        type="number"
                        id="inputPhone"
                        v-model="registerUser.phone"
                        class="form-control inputBorder"
                        placeholder="Phone / Mobile"
                      />
                      <strong class="text-danger" v-if="register_error.phone">{{
                        register_error.phone[0]
                      }}</strong>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-label-group">
                      <label for="inputEmail">Email address</label>
                      <input
                        :class="{ errorBorder: register_error.email != null }"
                        type="email"
                        id="inputEmail"
                        v-model="registerUser.email"
                        class="form-control inputBorder"
                        placeholder="Email Address"
                      />
                      <strong class="text-danger" v-if="register_error.email">{{
                        register_error.email[0]
                      }}</strong>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-label-group">
                      <label for="inputPassword">Password</label>
                      <input
                        :class="{ errorBorder: register_error.password != null }"
                        type="password"
                        id="inputPassword"
                        class="form-control inputBorder"
                        v-model="registerUser.password"
                        placeholder="Password"
                        autocomplete="new-password"
                      />
                      <!-- autocomplete="new password dile ..and eita just password e use korle email eo ar auto complete hobe na..email e use na korleo hobe" -->
                      <strong
                        class="text-danger"
                        v-if="register_error.password"
                        >{{ register_error.password[0] }}</strong
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-label-group">
                      <label for="inputConfirmPassword">Confirm Password</label>
                      <input
                        :class="{ errorBorder: register_error.confirm_password != null }"
                        type="password"
                        id="inputConfirmPassword"
                        v-model="registerUser.confirm_password"
                        class="form-control inputBorder"
                        placeholder="Password Confirmation"
                      />
                      <strong
                        class="text-danger"
                        v-if="register_error.confirm_password"
                        >{{ register_error.confirm_password[0] }}</strong
                      >
                    </div>
                  </div>
                </div>

                <div class="custom-control custom-checkbox mb-3">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="customCheck1"
                  />
                  <label class="custom-control-label" for="customCheck1"
                    >I agree with terms & conditions</label
                  >
                </div>
                <div class="row">
                  <div class="col-md-1"></div>
                  <div class="col-md-10">
                    <div class="bottomBtn">
                      <button
                        class="btn btn-lg btn-block text-uppercase"
                        style="background: #000000; color: #ffffff"
                        type="submit"
                      >
                        Register
                      </button>

                      <hr class="mb-3 mt-4" />
                      <div class="forgetPass text-center">
                        <span class="d-inline-block text-dark"
                          >Already you have registered?
                          <router-link
                            :to="{ name: 'login' }"
                            class="text-primary"
                          >
                            Login
                          </router-link>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-1"></div>
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
  },
  data() {
    return {
      registerUser: {
        name: "",
        phone: "",
        email: "",
        password: "",
        confirm_password: "",
      },
      register_error: {},
    };
  },

  methods: {
    m_registerUser() {
      let registerForm = new FormData();
      registerForm.append("name", this.registerUser.name);
      registerForm.append("phone", this.registerUser.phone);
      registerForm.append("email", this.registerUser.email);
      registerForm.append("password", this.registerUser.password);
      registerForm.append(
        "confirm_password",
        this.registerUser.confirm_password
      );

      axios
        .post(this.$store.state.apiURL + "auth/register", registerForm)
        .then((response) => {
        //   console.log(response.data);
          this.registerUser.name = "";
          this.registerUser.phone = "";
          this.registerUser.email = "";
          this.registerUser.password = "";
          this.registerUser.confirm_password = "";
          this.register_error = {};
          this.$router.push({name:'login', params: { registerSuccMsg:  response.data.message}});
        })
        .catch((error) => {
        //   console.log(error.response.data.errors);
          this.register_error = error.response.data.errors;
        })
        .finally(() => {});
    },
  },
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
  padding: 1.5rem 2rem 1.3rem 2rem;
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

/* number input er pasher up down arrow remove korar jonno eita */
/* Chrome, Safari, Edge, Opera */
#inputPhone::-webkit-outer-spin-button,
#inputPhone::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
#inputPhone[type="number"] {
  -moz-appearance: textfield;
}

.custom-control-input:checked ~ .custom-control-label::before {
  color: #fff !important;
  border-color: #000000 !important;
  background-color: #000000 !important;
}

.inputBorder{
    border: 1px solid rgb(233 231 231) !important
}

/* error border */
.errorBorder {
  border: 1px solid red !important;
  border-radius: 3px !important;
}
</style>
