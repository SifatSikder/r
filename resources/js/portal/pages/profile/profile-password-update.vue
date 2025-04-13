<template>
    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white">

                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="card shadow p-sm-5 p-3">
                            <form id="profilePasswordUpdate" class="w-100" @submit.prevent="updatePassword" enctype="multipart/form-data">

                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>Current Password:</strong></label>
                                    <input type="password" class="form-control" name="current_password" required>
                                    <div class="error-report text-danger"></div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>New Password:</strong></label>
                                    <input type="password" class="form-control" name="password" required>
                                    <div class="error-report text-danger"></div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>Re-type New Password:</strong></label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                    <div class="error-report text-danger"></div>
                                </div>
                                <div class="form-group">
                                    <button class="w-100 btn btn-warning rounded-pill">Update Password</button>
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
import ApiService from "../../services/ApiService";
import ApiRoutes from "../../services/ApiRoutes";
import { createToaster } from "@meforma/vue-toaster";
import Swal from "sweetalert2";
const Toaster = createToaster({position: 'bottom-right'});
export default {
    data() {
        return {
            loading: 1,
            UserInfo: window.core.UserInfo
        }
    },
    computed: {},
    watch: {},
    methods: {
        updatePassword: function (){
            const THIS = this;
            this.loading = true;
            ApiService.ClearErrorHandler();
            const formData = new FormData(document.getElementById('profilePasswordUpdate'));
            ApiService.POST_FORM_DATA(ApiRoutes.profile_update_password, formData, function (res){
                THIS.loading = false;
                if(res.status === 200){
                    Toaster.success(res.msg);
                    THIS.$router.push({name: 'Profile'});
                } else {
                    ApiService.ErrorHandler(res.error);
                }
            })
        }
    },
    created() {
    },
    mounted() {
        window.scrollTo(0, 0);
    },
}
</script>
