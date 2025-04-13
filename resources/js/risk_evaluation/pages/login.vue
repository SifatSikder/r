<template>

    <div class="w-100">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card p-3 shadow">
                    <div class="card-body">
                        <form class="w-100 py-3" @submit.prevent="Login">
                            <div class="form-group mb-5 text-center">
                                <h1><strong>Login</strong></h1>
                            </div>
                            <div class="form-group mt-3 mb-3">
                                <input type="email" v-model="LoginForm.email" class="form-control form-control-lg rounded-pill" name="email" placeholder="Email Address">
                                <div class="error-report text-danger"></div>
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" v-model="LoginForm.password" autocomplete="new-password" name="password" class="form-control form-control-lg rounded-pill" placeholder="Password">
                                <div class="error-report text-danger"></div>
                            </div>
                            <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" @change="LoginForm.remember = !LoginForm.remember" name="remember" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Remember Me
                                    </label>
                                </div>
                                <a class="text-decoration-none text-secondary" href="/forgot/password"><strong>Forgot Password?</strong></a>
                            </div>
                            <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                                <input type="hidden" name="g-recaptcha-response" v-model="LoginForm['g-recaptcha-response']" id="g-recaptcha-response-v3">
                                <button type="submit" v-if="loading === false" class="w-100 btn btn-lg btn-primary rounded-pill m-0">Login Now</button>
                                <button type="button" v-if="loading === true" class="w-100 btn btn-lg btn-primary rounded-pill m-0">Processing...</button>
                            </div>
                            <div class="form-group mb-3 text-center text-secondary">
                                <strong>--- OR ---</strong>
                                <br>
                                <router-link  :to="{name: 'Register'}" class="text-secondary"><strong>Create New Account</strong></router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
import ApiService from "../services/ApiService";
import ApiRoutes from "../services/ApiRoutes";

export default {
    data() {
        return {
            loading: false,
            UserInfo: window.core.UserInfo,
            LoginForm: {
                email: '',
                password: '',
                remember: false,
                'g-recaptcha-response': ''
            }
        }
    },
    computed: {},
    watch: {},
    methods: {
        Login() {
            this.loading = true;
            ApiService.ClearErrorHandler();
            ApiService.POST(ApiRoutes.Login, this.LoginForm, (res) => {
                if (parseInt(res.status) === 200) {
                    window.location.href = '/risk-evaluation/project-intro';
                    // this.$router.push({name: 'ProjectIntro'})
                } else {
                    this.loading = false;
                    ApiService.ErrorHandler(res.error);
                }
            })
        },
    },
    created() {
        if(this.UserInfo != null){
            this.$router.push({name: 'ProjectIntro'})
        }
    },
    mounted() {
        let THIS = this;
        window.scrollTo(0, 0);
        // Use the reCAPTCHA API ready function
        grecaptcha.ready(function () {
            // Execute reCAPTCHA with the site key and the specified action 'submit'
            grecaptcha.execute(window.RECAPTCHA_SITE_KEY, { action: 'submit' }).then(
                function (token) {
                    // Log the obtained reCAPTCHA token to the console
                    console.log(token);
                    THIS.LoginForm['g-recaptcha-response'] = token;

                    // Get the target element with the ID 'g-recaptcha-response-v3'
                    const target = document.getElementById('g-recaptcha-response-v3');

                    // Set the obtained token as the value of the target element
                    target.value = token;
                }
            );
        });
    },
}
</script>

