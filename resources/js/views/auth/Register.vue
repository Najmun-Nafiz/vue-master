<template lang="">
    <div>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-8 col-12">
              <div class="card card-register mx-auto mt-5">
                <div class="card-header text-center">Register an Account</div>
                  <div class="card-body">
                      <form v-on:submit.prevent="register">
                          <div class="form-group mb-0">
                              <div class="form-row">
                                  <div class="col-md-6">
                                      <div class="form-label-group">
                                          <input
                                              type="text"
                                              v-model="user.name"
                                              id="name"
                                              class="form-control"
                                              placeholder="Enter Full Name"
                                              autofocus="autofocus"
                                          />
                                          <label for="name"
                                              >Enter Full Name</label
                                          >
                                          <div
                                              class="invalid-feedback"
                                              v-if="errors.name"
                                          >
                                              {{ errors.name[0] }}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <div class="form-label-group">
                                              <input
                                                  type="email"
                                                  v-model="user.email"
                                                  id="email"
                                                  class="form-control"
                                                  placeholder="Email address"
                                              />
                                              <label for="email"
                                                  >Email address</label
                                              >
                                              <div
                                                  class="invalid-feedback"
                                                  v-if="errors.email"
                                              >
                                                  {{ errors.email[0] }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="form-row">
                                  <div class="col-md-6">
                                      <div class="form-label-group">
                                          <input
                                              type="password"
                                              v-model="user.password"
                                              id="password"
                                              class="form-control"
                                              placeholder="Password"
                                          />
                                          <label for="password">Password</label>
                                          <div
                                              class="invalid-feedback"
                                              v-if="errors.password"
                                          >
                                              {{ errors.password[0] }}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-label-group">
                                          <input
                                              type="password"
                                              v-model="user.password_confirmation"
                                              id="password_confirmation"
                                              class="form-control"
                                              placeholder="Confirm password"
                                          />
                                          <label for="password_confirmation"
                                              >Confirm password</label
                                          >
                                          <div
                                              class="invalid-feedback"
                                              v-if="errors.password_confirmation"
                                          >
                                              {{
                                                  errors.password_confirmation[0]
                                              }}
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <button type="submit" class="btn btn-primary btn-block">
                              Register
                          </button>
                      </form>
                      <div class="text-center">
                          <router-link class="d-block small mt-3" to="/login"
                              >Login Page</router-link
                          >
                          <router-link to="/resetPassword" class="d-block small"
                              >Forgot Password?</router-link
                          >
                      </div>
                  </div>
              </div>
            </div>
          </div>
            
        </div>
    </div>
</template>
<script>
import * as auth from "../../services/auth_service";
export default {
    name: "Register",
    data() {
        return {
            user: {
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            },

            errors: {}
        };
    },

    created() {
        document.querySelector("body").style.backgroundColor = "#3e5a0c";
    },

    methods: {
        register: async function() {
            try {
                const response = await auth.register(this.user);
                this.error = {};
                if(response.data.status_code == 201){
                  this.$router.push("/login");
                  this.$snotify.success(response.data.message);
                }
                
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        this.$snotify.error(error.response.data.message);
                        break;
                    case 500:
                        this.$snotify.error(error.response.data.message);
                        break;
                    default:
                        this.$snotify.error(
                            "Some error occurred, Please try again..!"
                        );
                        break;
                }
            }
        }
    }
};
</script>
<style></style>
