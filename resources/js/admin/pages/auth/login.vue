<template>
    <div class="loginAuthBox">
        <div class="cardContent border shadow">
            <div class="text-center">
                <img :src="'/img/banners/auth-page.png'" class="img-fluid mb-2 col-10" alt="image">
            </div>
            <div class="box">
                <form @submit.prevent="Login">
                    <div class="form-group mt-3 mb-5">
                        <h1 class="SiteLogo text-center">RaiDOT</h1>
                        <p class="SiteSlogan text-center">Secure Administration</p>
                    </div>
                    <div class="form-group mb-3">
                        <div class="position-relative">
                            <div class="position-absolute start-0 top-50 translate-middle-y ps-4">
                                <i class="fa fa-user SiteIcon" aria-hidden="true"></i>
                            </div>
                        <input id="email" type="email"
                               v-model="LoginForm.email" name="email" class="ps-5 form-control form-control-lg rounded-pill"
                               autocomplete="new-email-123123x"
                               placeholder="Email...">
                        </div>
                        <div class="error-report text-danger"></div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="position-relative">
                            <div class="position-absolute start-0 top-50 translate-middle-y ps-4">
                                <i class="fa fa-lock SiteIcon" aria-hidden="true"></i>
                            </div>
                        <input type="password" id="password" autocomplete="new-password-123123"
                               placeholder="Password..."
                               v-model="LoginForm.password" name="password" class="ps-5 form-control form-control-lg rounded-pill">
                        </div>
                        <div class="error-report text-danger"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="check" class="form-label">
                            <input id="check" type="checkbox" class="form-check-input me-1" name="remember" v-model="LoginForm.remember"> Remember me
                        </label>
                    </div>
                    <div class="form-group mb-3">
                        <button v-if="loading === false" class="btn btn-lg w-100 btn-theme rounded-pill" type="submit">
                            Sign In <i class="fa fa-sign-in ms-3" aria-hidden="true"></i>
                        </button>
                        <button v-if="loading !== false" class="btn btn-lg w-100 btn-theme rounded-pill opacity-75" type="button">
                            Signing In...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import ApiService from "../../services/ApiService.js";
import ApiRoutes from "../../services/ApiRoutes.js";

export default {
    data() {
        return {
            LoginForm: {
                email: '',
                password: '',
                remember: false
            },
            errorMsg: null,
            error: null,
            loading: false,
            publicPath: import.meta.env.BASE_URL
        }
    },
    created() {

    },
    mounted() {
    },
    methods: {
        Login() {
            this.loading = true;
            ApiService.ClearErrorHandler();
            ApiService.POST(ApiRoutes.Login, this.LoginForm, (res) => {
                if (parseInt(res.status) === 200) {
                    window.location.reload()
                } else {
                    this.loading = false;
                    ApiService.ErrorHandler(res.error);
                }
            })
        },
    }
}
</script>
