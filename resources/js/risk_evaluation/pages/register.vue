<template>

    <div class="w-100">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card p-3 shadow">
                    <div class="card-body">
                        <form class="w-100 py-3" @submit.prevent="Register">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-5 text-center">
                                        <h1 class="text-dark"><strong>Rai<span class="text-danger">DOT</span></strong></h1>
                                        <h3 class="text-dark"><strong>Let's Create Your Account</strong></h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-lg rounded-pill"
                                               name="first_name" v-model="param.first_name" placeholder="First Name *" required>
                                        <div class="error-report text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-lg rounded-pill"
                                               name="last_name" v-model="param.last_name" placeholder="Last Name *" required>
                                        <div class="error-report text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control form-control-lg rounded-pill"
                                               name="email" v-model="param.email" placeholder="Email Address *" required >
                                        <div class="error-report text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="tel" class="form-control form-control-lg rounded-pill"
                                               name="phone" v-model="param.phone" placeholder="Phone">
                                        <div class="error-report text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-lg rounded-pill"
                                               name="company" v-model="param.company" placeholder="Company Name">
                                        <div class="error-report text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-lg rounded-pill"
                                               name="website" v-model="param.website" placeholder="Website URL">
                                        <div class="error-report text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="password" autocomplete="new-password" class="form-control form-control-lg rounded-pill"
                                               name="password" v-model="param.password" placeholder="Password *" required>
                                        <div class="error-report text-danger"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <input type="password" autocomplete="new-password" class="form-control form-control-lg rounded-pill"
                                               name="password_confirmation" v-model="param.password_confirmation" placeholder="Re-type Password *" required>
                                        <div class="error-report text-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                                <input type="hidden" name="g-recaptcha-response" v-model="param['g-recaptcha-response']" id="g-recaptcha-response-v3">
                                <button type="submit" v-if="loading === false" class="w-100 btn btn-lg btn-primary rounded-pill m-0">Create Account</button>
                                <button type="button" v-if="loading === true" class="w-100 btn btn-lg btn-primary rounded-pill m-0">Creating Account...</button>
                            </div>
                            <div class="form-group mb-3 text-center text-secondary">
                                <strong>Already have an account? </strong>
                                <router-link :to="{name: 'Login'}" class="text-secondary"><strong>Login Now</strong></router-link>
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
            param: {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                company: '',
                website: '',
                password: '',
                password_confirmation: '',
                'g-recaptcha-response': ''
            }
        }
    },
    computed: {},
    watch: {},
    methods: {
        Register() {
            this.loading = true;
            ApiService.ClearErrorHandler();
            ApiService.POST(ApiRoutes.Register, this.param, (res) => {
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
                    THIS.param['g-recaptcha-response'] = token;

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

