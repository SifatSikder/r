<template>

    <div class="card w-100 h-100">
        <div class="bg-light">
            <div class="h3 w-100 ps-3 py-3">Change Password</div>
        </div>
        <form @submit.prevent="updatePassword()" class="py-4 px-3">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" v-model="password.current_password">
                        <div class="error-report text-danger"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" v-model="password.password">
                        <div class="error-report text-danger"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" v-model="password.password_confirmation">
                        <div class="error-report text-danger"></div>
                    </div>
                    <div class="form-group mb-3 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-3" v-if="loading === false"> Save Changes </button>
                        <button type="button" class="btn btn-primary rounded-pill px-5" v-if="loading === true">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round"
                                 class="css-i6dzq1 la-spin">
                                <line x1="12" y1="2" x2="12" y2="6"></line>
                                <line x1="12" y1="18" x2="12" y2="22"></line>
                                <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                <line x1="2" y1="12" x2="6" y2="12"></line>
                                <line x1="18" y1="12" x2="22" y2="12"></line>
                                <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>

        </form>
    </div>

</template>

<script>

import ApiService from "../../../services/ApiService";
import ApiRoutes from "../../../services/ApiRoutes";
import {createToaster} from "@meforma/vue-toaster";
const toaster = createToaster({
    position: 'top-right'
});

export default {

    data(){

        return{
            profile: null,
            loading: false,
            password: {
                current_password: '',
                password: '',
                password_confirmation: '',
            }
        }

    },

    mounted() {

        this.getMe()

    },

    methods: {

        getMe: function () {
            ApiService.POST(ApiRoutes.Profile, {}, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.profile = res.data
                }
            })
        },

        updatePassword() {
            ApiService.ClearErrorHandler();
            this.loading = true
            ApiService.POST(ApiRoutes.ChangePassword, this.password, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    toaster.info(res.msg);
                    this.password = {
                        current_password: '',
                        password: '',
                        password_confirmation: '',
                    }
                } else {
                    ApiService.ErrorHandler(res.error);
                }
            })
        },

    }

}

</script>
