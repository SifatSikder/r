<template>
    <div class="container-lg">

        <div class="w-100 bg-white p-3 shadow mb-4 d-flex justify-content-between align-items-center">
            <input type="text" class="form-control" v-model="keyword" @keyup="searchUser" style="width: 300px" placeholder="Search User">
            <router-link class="btn btn-primary rounded-pill px-3 btn-sm" :to="{name: 'UserCreate'}">New User</router-link>
        </div>

        <div class="body-loading" v-if="Loading === true">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-3x fa-spin fa-cog text-theme"></i> <br> Please Wait ...
            </div>
        </div>

        <div class="w-100">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6" v-for="(user, index) in users">
                    <div class="eachUser w-100 bg-white shadow mb-4">
                        <div class="w-100 ox-2 py-5">
                            <div class="w-100 text-center">
                                <img class="border border-3" :src="user.avatar" alt="">
                            </div>
                            <div class="w-100 py-2 text-center">
                                <router-link :to="{name: 'UserEdit', params: {user_id: user._id}}" class="fs-5 text-secondary text-decoration-none"><strong>{{ user.name }}</strong></router-link>
                                <br>
                                <span class="badge bg-success" v-if="user.subscription_type === 'premium'">Premium User</span>
                                <span class="badge bg-secondary" v-if="user.subscription_type !== 'premium'">Free User</span>
                            </div>
                            <div class="w-100 d-flex justify-content-between align-items-center mt-5">
                                <div class="w-100 text-center">
                                    <strong class="fs-5 text-secondary">{{ user.risk_evaluation }}</strong> <br> <span class="text-secondary">Risk Evaluation</span>
                                </div>
                                <div class="w-100 text-center">
                                    <strong class="fs-5 text-secondary">{{ user.fair_decision }}</strong> <br> <span class="text-secondary">Fair Decision</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 d-flex justify-content-between align-items-center p-2">
                            <router-link :to="{name: 'UserEdit', params:{user_id: user._id}}" class="w-100 btn btn-sm btn-outline-primary rounded-pill me-1">Edit</router-link>
                            <a @click="deleteUser(user)" class="w-100 btn btn-sm btn-outline-danger rounded-pill ms-1">Delete</a>
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
import Swal from "sweetalert2";

export default {
    components: {},
    data() {
        return {
            Loading: false,
            searchTimeout: null,
            keyword: '',
            users: []
        };
    },
    methods: {
        getUsers: function () {
            const THIS = this;
            this.Loading = true;
            ApiService.POST(ApiRoutes.Users, {keyword: this.keyword}, (res) => {
                THIS.Loading = false;
                if (parseInt(res.status) === 200) {
                    THIS.users = res.data;
                }
            })
        },
        searchUser: function (){
            if(this.searchTimeout !== null){
                clearTimeout(this.searchTimeout);
            }
            this.searchTimeout = setTimeout(() => {
                clearTimeout(this.searchTimeout);
                this.getUsers();
            }, 1000);
        },
        deleteUser(user) {
            Swal.fire({
                title: 'Delete User',
                html: "<strong class='text-danger'>Are you sure?</strong> <br><br> <p class='alert alert-danger'>This action will remove all risk evaluation and fair decision analysis and other information of this user permanently.</p>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff005a',
                cancelButtonColor: '#777777',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    ApiService.POST(ApiRoutes.DeleteUser, {user_id: user._id}, (res) => {
                        this.Loading = false;
                        if (parseInt(res.status) === 200) {
                            this.getUsers();
                            Toaster.success(res.msg);
                        }
                    })
                }
            })
        }
    },
    created() {
        this.getUsers();
    },
    mounted() {
    }
};
</script>
