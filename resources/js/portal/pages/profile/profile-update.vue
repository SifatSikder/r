<template>
    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white">

                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="card shadow p-sm-5 p-3">
                            <form id="profileUpdate" class="w-100" @submit.prevent="updateProfile" enctype="multipart/form-data">

                                <div class="form-group mb-4">
                                    <div class="w-100 text-center mt-5">
                                        <div class="w-100 text-center">
                                            <img v-if="UserInfo.avatar == null" class="profile-avatar" :src="'/img/user.png'" alt="">
                                            <img v-if="UserInfo.avatar != null" class="profile-avatar" :src="'/storage/media/image/'+UserInfo.avatar" alt="">
                                        </div>
                                        <label for="changeProfileAvatar" class="cursor_pointer"><small class="badge bg-danger rounded-pill">Change Avatar</small></label>
                                        <input type="file" class="d-none" id="changeProfileAvatar" name="file">
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>First Name:</strong></label>
                                    <input type="text" class="form-control" :value="UserInfo.first_name" name="first_name" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>Last Name:</strong></label>
                                    <input type="text" class="form-control" :value="UserInfo.last_name" name="last_name" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>Email Address:</strong></label>
                                    <input type="email" class="form-control" :value="UserInfo.email" name="email" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>Phone:</strong></label>
                                    <input type="tel" class="form-control" :value="UserInfo.phone" name="phone">
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>Company:</strong></label>
                                    <input type="text" class="form-control" :value="UserInfo.company" name="company">
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label"><strong>Website:</strong></label>
                                    <input type="text" class="form-control" :value="UserInfo.website" name="website">
                                </div>
                                <div class="form-group">
                                    <button class="w-100 btn btn-warning rounded-pill">Update Profile</button>
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
        updateProfile: function (){
            const THIS = this;
            const formData = new FormData(document.getElementById('profileUpdate'));
            ApiService.POST_FORM_DATA(ApiRoutes.profile_update, formData, function (res){
                if(res.status === 200){
                    Toaster.success(res.msg);
                    THIS.$router.push({name: 'Profile'});
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
