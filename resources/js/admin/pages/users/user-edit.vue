<template>
    <div class="container-lg">
        <div class="w-100">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 col-md-12">

                    <form class="w-100" @submit.prevent="UpdateUser">
                        <div class="card question-holder">
                            <div class="card-header bg-white py-3 d-flex justify-content-between sticky-top">
                                <h4 class="m-0"><strong class="text-dark">User User</strong></h4>
                                <div class="">
                                    <router-link class="btn btn-sm btn-secondary rounded-pill px-3 me-2" :to="{name: 'Users'}">Cancel</router-link>
                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Save Changes</button>
                                </div>
                            </div>
                            <div class="card-body p-2 p-lg-5" v-if="user !== null">
                                <div class="row">
                                    <div class="col-lg-12 mb-1">
                                        <div class="w-100 p-4">
                                            <div class="error-report-g"></div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group" :class="{'d-none': !user.avatar}"
                                                                 v-if="user.avatar !== null">
                                                                <img :src="user.avatar_full_path"
                                                                     style="width: 150px; height: 150px;border-radius: 50%;object-fit: cover;border: 5px solid #e6e6e6;">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label class="form-label"><strong>Avatar</strong></label>
                                                                <input type="file" class="form-control" name="avatar"
                                                                       @change="attachFile">
                                                                <div class="error-report text-danger"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>First Name</strong></label>
                                                        <input type="text" class="form-control" name="first_name" v-model="user.first_name" placeholder="First Name">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Last Name</strong></label>
                                                        <input type="text" class="form-control" name="last_name" v-model="user.last_name" placeholder="Last Name">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Email</strong></label>
                                                        <input type="email" class="form-control" name="email" v-model="user.email" placeholder="Email">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Phone</strong></label>
                                                        <input type="tel" class="form-control" name="phone" v-model="user.phone" placeholder="Phone">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Company</strong></label>
                                                        <input type="text" class="form-control" name="company" v-model="user.company" placeholder="Company">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Website</strong></label>
                                                        <input type="tel" class="form-control" name="website" v-model="user.phone" placeholder="Website">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Subscription Type</strong></label>
                                                        <select name="subscription_type" class="form-select" v-model="user.subscription_type">
                                                            <option value="free">Free</option>
                                                            <option value="premium">Premium</option>
                                                        </select>
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <hr>
                                                    <p class="alert alert-info">
                                                        If you want to update user password then fill the password inputs and submit otherwise leave them blank.
                                                    </p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Password</strong></label>
                                                        <input type="password" class="form-control" autocomplete="new-password" name="password" v-model="user.password" placeholder="Password">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-4">
                                                        <label class="form-label"><strong>Re-Type Password</strong></label>
                                                        <input type="password" class="form-control" name="password_confirmation" v-model="user.password_confirmation" placeholder="Re-type Password">
                                                        <div class="error-report text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>


<script>
import ApiService from "../../services/ApiService";
import ApiRoutes from "../../services/ApiRoutes";
import {createToaster} from "@meforma/vue-toaster";

const Toaster = createToaster({position: 'top-right'});

export default {
    components: {},
    data() {
        return {
            Loading: false,
            user_id: null,
            user: null
        }
    },
    methods: {
        attachFile: function (event) {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append("file", file);
            formData.append("media_type", 1);
            this.Loading = true;
            ApiService.UPLOAD(ApiRoutes.MEDIA, formData, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.user.avatar = res.data.file_path;
                    this.user.avatar_full_path = res.data.full_file_path;
                }
            })
        },
        UpdateUser() {
            this.Loading = true;
            ApiService.ClearErrorHandler();
            ApiService.POST(ApiRoutes.UpdateUser, this.user, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    Toaster.success(res.msg);
                    this.$router.push({name: 'Users'})
                } else {
                    ApiService.ErrorHandler(res.error);
                }
            })
        },
        getUser() {
            this.Loading = true;
            ApiService.POST(ApiRoutes.GetUser, {user_id: this.user_id}, (res) => {
                this.Loading = false;
                if (parseInt(res.status) === 200) {
                    this.user = res.data;
                }
            })
        }

    },
    created() {
        this.user_id = this.$route.params.user_id;
        this.getUser()
    },
    mounted() {
    }
};
</script>
