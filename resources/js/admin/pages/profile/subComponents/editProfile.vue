<template>
    <div class="card w-100 h-100">
        <div class="bg-light">
            <div class="h3 w-100 ps-3 py-3">Edit Profile</div>
        </div>
        <div class="py-4 px-3">
            <form class="w-100" @submit.prevent="updateProfile()">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" v-model="profileParam.name">
                            <div class="error-report text-danger"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" v-model="profileParam.email">
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
            profileParam: {
                name: '',
                email: '',
            },
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
                    this.profileParam.name = this.profile.name
                    this.profileParam.email = this.profile.email
                }
            })
        },

        updateProfile() {
            let THIS = this;
            ApiService.ClearErrorHandler();
            this.loading = true
            ApiService.POST(ApiRoutes.UpdateProfile, THIS.profileParam, (res) => {
                THIS.loading = false;
                if (parseInt(res.status) === 200) {
                    toaster.success(res.msg);
                } else {
                    ApiService.ErrorHandler(res.error);
                }
            })
        },
    }

}

</script>
