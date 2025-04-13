<template>

    <div class="w-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-3">
                    <div class="card py-4 w-100" v-if="profile != null">
                        <div class="w-100 d-flex justify-content-center mb-2">
                            <div class="position-relative">
                                <img :src="'/img/user.png'" alt="user.png" style="width: 100px" class="img-fluid">
                                <div class="remove-btn shadow">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 d-flex justify-content-center mb-2">
                            <label for="upload-image" class="btn btn-sm btn-primary rounded-pill py-1 px-3">
                                <small>Change Avatar</small>
                                <input type="file" id="upload-image" class="d-none">
                            </label>
                        </div>
                        <div class="w-100">
                            <div class="fw-bold text-center pt-4">{{ profile.name }}</div>
                            <div class="text-secondary text-center mb-2">{{ profile.email }}</div>
                        </div>
                        <hr>

                        <ul class="w-100 position-relative dropdown-menu dropdown-menu-end border-0 show">
                            <li class="px-5"><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'Profile'}">Profile</router-link></li>
                            <li class="px-5"><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'EditProfile'}">Update Profile</router-link></li>
                            <li class="px-5"><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'ChangePassword'}">Change Password</router-link></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="px-5"><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'NotificationSettings'}">Notification Settings</router-link></li>
                            <li class="px-5"><router-link class="dropdown-item rounded-pill text-center mb-1" :to="{name: 'AccountSettings'}">Account Settings</router-link></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="px-5"><a class="btn btn-sm btn-danger w-100 rounded-pill mt-3" href="javascript:void(0)" @click="Logout">Logout</a></li>
                        </ul>

                    </div>
                </div>
                <div class="col-md-12 col-lg-9">
                    <router-view/>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
import ApiService from "../../services/ApiService";
import ApiRoutes from "../../services/ApiRoutes";

export default {
    data() {
        return {
            profile: null,
            loading: false,
        }
    },
    computed: {},
    watch: {},
    methods: {
        getMe: function () {
            ApiService.POST(ApiRoutes.Profile, {}, (res) => {
                this.loading = false;
                if (parseInt(res.status) === 200) {
                    this.profile = res.data
                }
            })
        },
        Logout() {
            this.logoutLoading = true;
            ApiService.POST(ApiRoutes.Logout, {}, (res) => {
                this.logoutLoading = false;
                if (parseInt(res.status) === 200) {
                    window.location.reload();
                }
            });
        }
    },
    created() {

    },
    mounted() {
        this.getMe()

        // $("#EditModal").on("hide.bs.modal", () => {
        //     ApiService.ClearErrorHandler();
        //     this.profileParam.name = '';
        // });
        //
        // $("#PasswordModal").on("hide.bs.modal", () => {
        //     ApiService.ClearErrorHandler();
        //     this.password.current_password = '';
        //     this.password.password = '';
        //     this.password.password_confirmation = '';
        // });

    },
}
</script>

