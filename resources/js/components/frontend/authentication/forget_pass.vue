<template>
  <div>
    <div class="container mt-5 pt-5">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card card-signin my-5">
            <div class="card-body">
              <div class="loginHeader">
                <h3 class="text-center font-weight-bold">Reset Password</h3>
              </div>
              <hr />
              <form method="POST" class="form-signin">
                <div class="form-label-group">
                  <label for="inputEmail">Email address</label>
                  <input
                    style="border: 1px solid rgb(233 231 231) !important"
                    type="email"
                    id="inputEmail"
                    class="form-control"
                    placeholder="Enter your email to get OTP"
                  />
                </div>
                <div class="bottomBtn text-center">
                  <button
                    class="btn btn-sm btn-success text-uppercase"
                    type="submit"
                  >
                    Recover Password
                  </button>

                  <div class="forgetPass text-center mt-3">
                    <span class="d-inline-block text-dark"
                      >Go back to
                      <router-link :to="{ name: 'login' }" class="text-primary">
                        login page.
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
  padding: 0.6rem 1rem;
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
</style>
