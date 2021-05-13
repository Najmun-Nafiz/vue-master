<template lang="">
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                    <div class="card card-login mx-auto mt-5">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form v-on:submit.prevent="login">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <input
                                            type="email"
                                            v-model="user.email"
                                            id="email"
                                            class="form-control"
                                            placeholder="Email address"
                                            autofocus="autofocus"
                                        />
                                        <label for="email">Email address</label>
                                        <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <input
                                            type="password"
                                            v-model="user.password"
                                            id="password"
                                            class="form-control"
                                            placeholder="Password"
                                        />
                                        <label for="password">Password</label>
                                        <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="remember-me" v-model="user.remember_me" />
                                            Remember Password
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </form>
                            <div class="text-center">
                                <router-link to="/register" class="d-block small mt-3">Register an Account</router-link>
                                <router-link to="/resetPassword" class="d-block small">Forgot Password?</router-link>
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
        name: 'Login',
        created() {
            document.querySelector('body').style.backgroundColor = '#3e5a0c';
        },
        data() {
            return {
                user: {
                    email: '',
                    password: '',
                    remember_me: false
                },

                errors: {}
            }
        },
        methods: {
            login: async function() {
                try {
                    const response = await auth.login(this.user);
                    this.errors = {};
                        this.$router.push('/dashboard');
                    // if(response.data.status_code == 200){
                    //     this.$router.push('/dashboard');
                    //     this.$snotify.success(response.data.message);
                    // }
                } catch (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors = error.response.data.errors;
                            this.$snotify.error(error.response.data.message);
                            break;
                        case 401:
                            this.$snotify.error(error.response.data.message);
                            break;
                        case 500:
                            this.$snotify.error(error.response.data.message);
                            break;
                        default:
                            this.$snotify.error('Some error occurred, Please try again!');
                            break;
                    }
                }
            }
        }
    };
</script>
<style></style>
